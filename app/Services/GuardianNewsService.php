<?php

namespace App\Services;

use App\Interfaces\NewsTransformInterface;

/**
 * Used for the fetch of The guardian news via the guardian news api
 * Then create a uniform structure that will be used in the front end by all news
 */

class GuardianNewsService extends NewsService implements NewsTransformInterface
{

    private String $search;

    public function __construct(String $search)
    {
        parent::__construct("https://content.guardianapis.com/search", [
            'api-key' => env('GUARDIAN_API_KEY'),
            'q' => $search,
            'page-size' => '10',
            "sort-by" => 'relevance',
            'query-fields' => 'headline,body',
            'show-fields' => 'headline,thumbnail,body',
            'show-tags' => 'contributor'
        ]);
        $this->search = $search;
    }
    public function transformNews(): array
    {
        $response = $this->getNews($this->search);
        $results = $response['response']['results'];
        $news = collect($results)->map(fn ($result) => [
            "title" => $result['fields']['headline'],
            "body" => $result['fields']['body'],
            "thumbnail" => $result['fields']['thumbnail'],
            "author" => $result['tags'] && $result['tags'][0] ? $result['tags'][0]['webTitle'] : null,
            "date" => $result['webPublicationDate'],
            "category" => $result['sectionName'],
            "source" => "The Guardian"
        ]);
        return $news->toArray();
    }
}
