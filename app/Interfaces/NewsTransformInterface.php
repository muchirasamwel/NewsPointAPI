<?php

namespace App\Interfaces;

interface NewsTransformInterface
{
    public function transformNews(String $search): array;
}
