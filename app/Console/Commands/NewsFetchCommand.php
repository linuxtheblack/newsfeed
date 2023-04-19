<?php

namespace App\Console\Commands;

use App\Http\Resources\articleResource;
use App\NewsFetcher;
use Illuminate\Console\Command;

class NewsFetchCommand extends Command
{
    protected $signature = 'news:fetch';

    protected $description = 'Print all news articles in JSON format';

    public function handle(): void
    {
        $this->setNewsFetcher(new NewsFetcher());

        $this->line($this->fetcher->fetch()->map(fn($article) => new articleResource($article))->toJson());
    }

    public function setNewsFetcher($newsFetcher)
    {
        return $this->fetcher = $newsFetcher;
    }

}
