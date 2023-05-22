<?php

namespace App\Services;

use App\Interfaces\NewsTransformInterface;

/**
 * Used for the fetch of The guardian news via the guardian news api
 * Then create a uniform structure that will be used in the front end by all news
 */

class GuardianNewsService extends NewsService implements NewsTransformInterface
{
    public function transformNews(String $search): array
    {
        $response = $this->getNews($search);
        $results = $response['response']['results'];
        $news = collect($results)->map(fn ($result) => [
            "title" => $result['fields']['headline'],
            "body" => $result['fields']['body'],
            "thumbnail" => $result['fields']['thumbnail'],
            "author" => $result['tags'][0]['webTitle'],
            "date" => $result['webPublicationDate'],
        ]);
        return $news->toArray();
    }
}
