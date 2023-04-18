<?php

namespace Tests\Unit;

use App\Models\article;
use App\NewsFetcher;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class NewsFetcherTest extends TestCase
{
    public function testBasic()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function FetchReturnsCollectionOfArticles()
    {
        $fetcher = new NewsFetcher();
        $result = $fetcher->fetch();

        // Asserts
        $this->assertInstanceOf(Collection::class, $result);

        $result->each(function ($article) {
            $this->assertInstanceOf(article::class, $article);
            $this->assertIsString($article->title);
            $this->assertIsString($article->article);
            $this->assertIsString($article->subTitle);
            $this->assertIsString($article->author);
            $this->assertInstanceOf(Carbon::class, $article->publishedAt);
        });
    }

    /**
     * @test
     */
    public function returnsExpectedFormatWithResource()
    {
        $response = $this->getJson('/');
        $response->assertStatus(200);

        // Assert that the first item in the response contains the expected structure
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['0.title', '0.author', '0.subTitle', '0.article', '0.publishedAt'])
        );
    }
}
