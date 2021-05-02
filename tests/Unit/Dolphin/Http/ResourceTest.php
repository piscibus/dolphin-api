<?php

namespace Tests\Unit\Dolphin\Http;

use App\Dolphin\Http\InvalidIncludeException;
use App\Dolphin\Http\Request;
use App\Dolphin\Http\Resource;
use BadMethodCallException;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    /**
     * @var Resource
     */
    private $stub;

    /**
     * @var Request
     */
    private $request;

    /**
     * @test
     */
    public function test_it_transforms_resource_into_array()
    {
        $this->assertIsArray($this->stub->toArray($this->request));
    }

    /**
     * @test
     */
    public function test_it_validates_includes()
    {
        $this->expectException(InvalidIncludeException::class);
        $this->request->merge(['includes' => 'invalid,includes']);
        $this->stub->toArray($this->request);
    }

    /**
     * @test
     */
    public function test_it_fetches_includes()
    {
        $this->expectException(BadMethodCallException::class);
        $this->stub->setAvailableIncludes(['foo', 'bar']);
        $this->request->merge(['includes' => 'foo,bar']);
        $this->stub->toArray($this->request);
    }

    /**
     * @test
     */
    public function test_it_fetches_default_includes()
    {
        $this->expectException(BadMethodCallException::class);
        $this->stub->setDefaultIncludes(['foo', 'bar']);
        $this->stub->toArray($this->request);
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var Request $request */
        $this->request = $this->getMockForAbstractClass(Request::class);
        /** @var Model $model */
        $model = $this->getMockForAbstractClass(Model::class);
        /** @var Resource $stub */
        $this->stub = $this->getMockForAbstractClass(Resource::class, [$model]);
    }
}
