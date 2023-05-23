<?php

namespace App\Http\Controllers;

use App\Services\GuardianNewsService;
use App\Services\NewsApiNewsService;
use App\Services\NyTimesNewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function collectNews(Request $request)
    {
        $search = $request->get('search');

        $guardianNews = $this->getGuardianNews($search ?? '');
        $newsAPINews = $this->getNewsApiNews($search ?? 'news');
        $nYTimesNews = $this->getNyTimesNews($search ?? '');

        return Http::success([
            "guardianNews" => $guardianNews,
            'newsAPINews' => $newsAPINews,
            'nYTimesNews' => $nYTimesNews
        ]);
    }

    private function getGuardianNews(String $search): array
    {
        $guardianNewsService = new GuardianNewsService($search);

        return $guardianNewsService->transformNews();
    }

    private function getNewsApiNews(String $search): array
    {
        $newsAPINewsService = new NewsApiNewsService($search);

        return $newsAPINewsService->transformNews();
    }

    private function getNyTimesNews(String $search): array
    {
        $nYTimesNewsService = new NyTimesNewsService($search);

        return $nYTimesNewsService->transformNews();
    }
}
