<?php

namespace Tests\Unit\Console\Commands;


use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class NewsFetchWithEndpointTest extends TestCase
{
    /**
     * Test Web Endpoint
     * @test
     */
    public function httpEndpointReturnsExpectedFormat()
    {
        $response = $this->getJson('/');
        $response->assertStatus(200);

        // Assert that the first item in the response contains the expected structure
        $response->assertJson(fn (AssertableJson $json) =>
        $json->hasAll(['0.title', '0.author', '0.subTitle', '0.article', '0.publishedAt'])
        );
    }
}
