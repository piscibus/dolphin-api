<?php

namespace Tests\Unit\Dolphin\Http;

use App\Dolphin\Http\InvalidIncludeException;
use App\Dolphin\Http\Request;
use App\Dolphin\Http\Resource;
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
    public function test_it_parses_includes_from_request()
    {
        $this->request->merge(['includes' => 'foo,bar']);
        $this->assertEquals(collect(['foo', 'bar']), $this->stub->parseIncludes($this->request));
    }

    /**
     * @test
     */
    public function test_it_does_not_include_allowed_includes()
    {
        $this->request->merge(['includes' => 'foo,bar']);
        $this->expectException(InvalidIncludeException::class);
        $this->stub->toArray($this->request);
    }

    /**
     * @test
     */
    public function test_it_qualifies_includes_on_validation()
    {
        $this->stub->setAvailableIncludes(['foo', 'bar']);
        $this->stub->validateIncludes(collect(['foo', 'bar']));
        $this->assertEquals(
            ['includeFoo', 'includeBar'],
            $this->stub->getQualifiedIncludes()->toArray()
        );
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
