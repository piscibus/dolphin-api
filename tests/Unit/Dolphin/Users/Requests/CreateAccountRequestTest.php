<?php

namespace Tests\Unit\Dolphin\Users\Requests;

use App\Dolphin\Users\Requests\CreateAccountRequest;
use PHPUnit\Framework\TestCase;

class CreateAccountRequestTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_generates_name_using_email()
    {
        $request = new CreateAccountRequest(['email' => 'cool@email.com']);
        $name = $request->getName();
        $this->assertEquals('cool', $name);
    }

    /**
     * @test
     */
    public function test_it_get_name_if_exists()
    {
        $request = new CreateAccountRequest(['name' => 'Cool Name']);
        $name = $request->getName();
        $this->assertEquals('Cool Name', $name);
    }
}
