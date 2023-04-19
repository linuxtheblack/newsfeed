<?php

namespace Tests\Unit\Console\Commands;

use App\Models\article;
use App\NewsFetcher;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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
}
