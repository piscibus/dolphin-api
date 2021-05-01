<?php

namespace App\Dolphin\Http;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Resource
 * @package App\Dolphin\Http
 */
abstract class Resource extends JsonResource
{
    /**
     * List of included data
     *
     * @var array
     */
    protected array $availableIncludes = [];

    /**
     * @var Collection
     */
    protected Collection $qualifiedIncludes;

    /**
     * Resource constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->qualifiedIncludes = new Collection();
    }

    /**
     * @param  array  $availableIncludes
     * @return self
     */
    public function setAvailableIncludes(array $availableIncludes): self
    {
        $this->availableIncludes = $availableIncludes;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getQualifiedIncludes(): Collection
    {
        return $this->qualifiedIncludes;
    }

    /**
     * @param $item
     * @param  array  $data
     * @param $request
     * @return array
     */
    protected function fetchIncludes($item, array $data, $request): array
    {
        if (!in_array($item, $this->availableIncludes)) {
            return $data;
        }

        $camelCase = (string) Str::of($item)->camel();
        $method = sprintf('include%s', ucfirst($camelCase));
        /** @var Resource $resource */
        $resource = $this->$method($this->resource);
        $data[$item] = $resource->toArray($request);
        return $data;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  mixed  $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = $this->handle($request);
        $includes = $this->parseIncludes($request);

        if ($includes->count()) {
            $data = $this->appendIncludes($includes, $data, $request);
        }

        return $data;
    }

    /**
     * Handles the resource transformation into an array
     *
     * @param $request
     * @return array
     */
    abstract protected function handle($request): array;

    /**
     * @param  Request  $request
     * @return Collection
     */
    public function parseIncludes(Request $request): Collection
    {
        $includes = Str::of((string) $request->get('includes'))->explode(',');
        return $includes->map(fn (string $item) => trim($item));
    }

    /**
     * @param  Collection  $includes
     * @param  array  $data
     * @param  Request  $request
     * @return array
     */
    protected function appendIncludes(Collection $includes, array $data, Request $request): array
    {
        $this->validateIncludes($includes);
        foreach ($includes as $include) {
            $data[$include] = $this->fetchIncludeAble($include, $request);
        }
        return $data;
    }

    /**
     * @param  Collection  $includes
     */
    public function validateIncludes(Collection $includes): void
    {
        $validIncludes = collect($this->availableIncludes);

        $includes->each(function (string $item) use ($validIncludes) {
            if (!$validIncludes->contains($item)) {
                throw InvalidIncludeException::init($item);
            }

            $item1 = $this->qualifyIncludeAble($item);
            $this->qualifiedIncludes->add($item1);
        });
    }

    /**
     * @param  string  $item
     * @return string
     */
    protected function qualifyIncludeAble(string $item): string
    {
        $camelCase = (string) Str::of($item)->camel();
        return sprintf('include%s', ucfirst($camelCase));
    }

    /**
     * @param  string  $item
     * @param  Request  $request
     * @return array
     */
    protected function fetchIncludeAble(string $item, Request $request): array
    {
        return [];
    }
}
