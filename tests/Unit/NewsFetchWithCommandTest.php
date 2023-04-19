<?php

namespace Tests\Unit\Console\Commands;

use Tests\TestCase;
class NewsFetchWithCommandTest extends TestCase
{
    public function testHandle()
    {
        $this->artisan('news:fetch')
            ->expectsOutput($this->getJson('/')->getContent());
    }
}

