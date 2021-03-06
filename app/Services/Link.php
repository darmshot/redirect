<?php

namespace App\Services;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Link
{
    /**
     * @var \App\Models\Link
     */
    private \App\Models\Link $link;

    public function __construct(\App\Models\Link $link)
    {
        $this->link = $link;
    }

    /**
     * @throws \Exception
     */
    public function getShortUrl($url): string
    {
        $linkInfo = $this->link->where('url', $url)->first();

        if ($linkInfo === null) {
            $key = $this->generateKey($url);

            $this->link->create([
                'key' => $key,
                'url' => $url
            ]);

        } else {
            $key = $linkInfo->key;
        }

        return $this->createShortUrl($key);
    }

    public function getFullUrl($key): string
    {
        return $this->link->where('key', $key)->first()->url ?? '';
    }

    private function createShortUrl($key): string
    {
        $route = config('service_link.route_short');

        if (Route::has($route)) {
            $result = route($route, ['key' => $key]);
        } else {
            throw new \Exception('Route not found!');
        }

        return $result;
    }

    private function generateKey($url): string
    {
        return hash('crc32b',$url,false);
    }
}
