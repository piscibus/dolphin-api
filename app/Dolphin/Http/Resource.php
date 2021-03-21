<?php


namespace App\Dolphin\Http;

use Illuminate\Http\Resources\Json\JsonResource;
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
    protected $includes = [];

    /**
     * Transform the resource into an array.
     *
     * @param mixed $request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->handle($request);
        if ($request->has('include')) {
            foreach ((array)$request->get('include') as $item) {
                $data = $this->fetchIncludes($item, $data, $request);
            }
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
     * @param $item
     * @param array $data
     * @param $request
     * @return array
     */
    protected function fetchIncludes($item, array $data, $request): array
    {
        if (!in_array($item, $this->includes)) {
            return $data;
        }

        $camelCase = (string)Str::of($item)->camel();
        $method = sprintf('include%s', ucfirst($camelCase));
        /** @var Resource $resource */
        $resource = $this->$method($this->resource);
        $data[$item] = $resource->toArray($request);
        return $data;
    }
}
