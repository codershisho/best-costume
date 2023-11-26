<?php

namespace App\Services;

use App\Models\TScrapeSite;

class AnotherScrape extends AbstractScrape
{
    public function scrape(): void
    {
    }

    public function store(): TScrapeSite
    {
        return new TScrapeSite();
    }
}
