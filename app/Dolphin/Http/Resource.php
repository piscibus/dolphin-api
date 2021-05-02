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
     * @var Collection|null
     */
    protected ?Collection $includes = null;

    /**
     * List of included data
     *
     * @var array
     */
    protected array $availableIncludes = [];

    /**
     * @var array
     */
    protected array $defaultIncludes = [];

    /**
     * @param array $availableIncludes
     * @return self
     */
    public function setAvailableIncludes(array $availableIncludes): self
    {
        $this->availableIncludes = $availableIncludes;
        return $this;
    }

    /**
     * @param array $defaultIncludes
     * @return self
     */
    public function setDefaultIncludes(array $defaultIncludes): self
    {
        $this->defaultIncludes = $defaultIncludes;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param mixed $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = $this->handle($request);
        $includes = $this->validateIncludes($request)->merge($this->defaultIncludes);
        foreach ($includes as $item) {
            $data[$item] = $this->fetchIncludeAble($item);
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
     * @param Request $request
     * @return Collection
     */
    public function validateIncludes(Request $request): Collection
    {
        $includes = $this->parseIncludes($request);
        foreach ($includes as $item) {
            $this->validator($item);
        }
        return $includes;
    }

    /**
     * @param Request $request
     * @return Collection
     */
    protected function parseIncludes(Request $request): Collection
    {
        if ($this->hasIncludes($request)) {
            $includes = Str::of((string)$request->get('includes'))->explode(',');
            $this->includes = $includes->map(fn (string $item) => trim($item));
        }
        return $this->includes ?? new Collection();
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function hasIncludes(Request $request): bool
    {
        return is_null($this->includes) && !is_null($request->get('includes'));
    }

    /**
     * @param string $item
     */
    protected function validator(string $item)
    {
        if (!in_array($item, $this->availableIncludes) && !in_array($item, $this->defaultIncludes)) {
            throw InvalidIncludeException::init($item);
        }
    }

    /**
     * @param string $item
     * @return array
     */
    protected function fetchIncludeAble(string $item): array
    {
        $method = $this->qualifyIncludeAble($item);
        /** @var array $result */
        $result = $this->$method($this->resource);
        return $result;
    }

    /**
     * @param string $item
     * @return string
     */
    protected function qualifyIncludeAble(string $item): string
    {
        $camelCase = (string)Str::of($item)->camel();
        return sprintf('include%s', ucfirst($camelCase));
    }
}
