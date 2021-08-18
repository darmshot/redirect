<?php

namespace Tests\Services;

use App\Services\Link;
use Tests\TestCase;

class LinkTest extends TestCase
{

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    private Link $link;

    protected function setUp(): void
    {
        parent::setUp();

        $this->link = app(Link::class);
    }

    public function testGetShortUrl()
    {
        $url = 'https://medium.com/@nykolas.z/dns-resolvers-performance-compared-cloudflare-x-google-x-quad9-x-opendns-149e803734e5';

        $shortUrl = $this->link->getShortUrl($url);

        $this->assertTrue($shortUrl === url('53c45f'));
    }

    public function testGetFullUrl()
    {
        $url = 'https://medium.com/@nykolas.z/dns-resolvers-performance-compared-cloudflare-x-google-x-quad9-x-opendns-149e803734e5';

        $fullUrl = $this->link->getFullUrl('53c45f');

        $this->assertTrue($fullUrl === $url);

        $fullUrl = $this->link->getFullUrl('not exist');

        $this->assertTrue($fullUrl === '');
    }
}
