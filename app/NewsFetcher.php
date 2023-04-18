<?php

namespace App;

use App\Models\Article;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class NewsFetcher
{
    /**
     * @throws \Exception
     */
    public function fetch(): Collection
    {
        $data = $this->fetchFromMyApi();
        return $data->merge($this->fetchFromMyFile());
    }

    /**
     * @throws \Exception
     */
    public function fetchFromMyApi(): Collection
    {
        $response = Http::get('https://my-json-server.typicode.com/patrickreck/news-feed-output/articles');
        $data = $response->collect();

        return $this->formatData($data, 'api');
    }

    private function fetchFromMyFile()
    {
        $json = File::get(base_path('resources/json/file-source.json'));
        $data = collect(json_decode($json, true));

        return $this->formatData($data, 'file');
    }

    /**
     * Format the data structure based on the source
     * returns a collection of Article objects
     *
     * @param Collection $data
     * @param string $source
     * @return Collection
     * @throws \Exception
     */
    private function formatData(Collection $data, string $source): Collection
    {
        $format = [
            'api' => [
                'title' => 'articleTitle',
                'author' => 'author',
                'subTitle' => 'headline',
                'article' => 'articleBody',
                'publishedAt' => 'published',
            ],
            'file' => [
                'title' => 'title',
                'author' => 'authorFirstName',
                'authorLastName' => 'authorLastName',
                'subTitle' => 'bodyText',
                'article' => 'bodyText',
                'publishedAt' => 'dateCreated',
            ],
        ];

        // If the source is not in the format array, throw an exception
        if (!array_key_exists($source, $format)) {
            throw new \Exception('Source not found');
        }

        // Transform the data based on the source
        return $data->map(function ($item) use ($format, $source) {
            $article = new Article();

            $article->title = $item[$format[$source]['title']] ?? 'No title';
            $article->article = $item[$format[$source]['article']] ?? 'No article';

            // Limit the subtitle to 200 characters
            $article->subTitle = \Str::limit($item[$format[$source]['subTitle']] ?? 'No Sub Title', 200);

            // If name is split into two fields, combine them.
            if (array_key_exists('authorLastName', $format[$source])) {
                $article->author =
                    ($item[$format[$source]['author']] ?? 'No First Name') . ' '
                    . ($item[$format[$source]['authorLastName']] ?? 'No Last Name');
            } else {
                $article->author = $item[$format[$source]['author']] ?? 'No Author Name';
            }

            $date = Carbon::parse($item[$format[$source]['publishedAt']] ?? 'now');
            $article->publishedAt = $date->format('d-m-Y H:i:s');;

            return $article;
        });
    }
}
