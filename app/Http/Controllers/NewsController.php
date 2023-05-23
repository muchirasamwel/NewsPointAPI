<?php

namespace App\Http\Controllers;

use App\Services\GuardianNewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function collectNews(Request $request)
    {
        $search = $request->get('search');
        $guardianNews = $this->getGuardianNews($search);

        return Http::success([
            "guardianNews" => $guardianNews
        ]);
    }

    private function getGuardianNews(String $search): array
    {
        $guardianNewsService = new GuardianNewsService($search);

        return $guardianNewsService->transformNews();
    }
}
