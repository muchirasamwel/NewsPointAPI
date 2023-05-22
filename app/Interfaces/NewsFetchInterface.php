<?php

namespace App\Interfaces;

interface NewsFetchInterface
{
    public function getNews(String $search): array;
}
