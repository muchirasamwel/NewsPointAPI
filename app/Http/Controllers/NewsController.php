<?php

namespace App\Http\Controllers;

use App\Services\GuardianNewsService;
use App\Services\NewsApiNewsService;
use App\Services\NyTimesNewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function collectNews(Request $request)
    {
        $search = $request->get('search');

        $guardianNews = $this->getGuardianNews($search ?? '');
        $newsAPINews = $this->getNewsApiNews($search ?? '');
        $nYTimesNews = $this->getNyTimesNews($search ?? '');

        return Http::success([
            "guardianNews" => $guardianNews,
            'newsAPINews' => $newsAPINews,
            'nYTimesNews' => $nYTimesNews
        ]);
    }

    private function getGuardianNews(String $search): array
    {
        if (!$search) {
            $sources = $this->getSources();
            if ($sources && !in_array('Guardian News', $sources)) {
                return [];
            }
        }
        $guardianNewsService = new GuardianNewsService($search);

        return $guardianNewsService->transformNews();
    }

    private function getNewsApiNews(String $search): array
    {
        if (!$search) {
            $sources = $this->getSources();
            if ($sources) {
                $newsAPINewsService = new NewsApiNewsService($search, $sources);
            } else {
                $newsAPINewsService = new NewsApiNewsService('news');
            }
        } else {
            $newsAPINewsService = new NewsApiNewsService($search);
        }

        return $newsAPINewsService->transformNews();
    }

    private function getNyTimesNews(String $search): array
    {
        if (!$search) {
            $sources = $this->getSources();
            if ($sources && !in_array('New York Times News', $sources)) {
                return [];
            }
        }

        $nYTimesNewsService = new NyTimesNewsService($search);

        return $nYTimesNewsService->transformNews();
    }

    private function getSources()
    {
        $pref = Auth::user()->user_preferences;
        if ($pref && $pref['sources']) {
            return $pref['sources'];
        }

        return null;
    }
}
