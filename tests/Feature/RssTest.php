<?php

namespace Tests\Feature;

use App\Classes\Rss;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RssTest extends TestCase
{
    /**
     * @test
     * Test Rss Parse method
     * 
     * @return void
     */
    public function test_rss_parse()
    {
        $test_rss_urls = [
            'https://www.omnycontent.com/d/playlist/2b465d4a-14ee-4fbe-a3c2-ac46009a2d5a/b1907157-de93-4ea2-a952-ac700085150f/be1924e3-559d-4f7d-98e5-ac7000851521/podcast.rss',
            'https://nosleeppodcast.libsyn.com/rss',
            'https://www.omnycontent.com/d/playlist/aaea4e69-af51-495e-afc9-a9760146922b/43816ad6-9ef9-4bd5-9694-aadc001411b2/808b901f-5d31-4eb8-91a6-aadc001411c0/podcast.rss',
            'https://feeds.megaphone.fm/stuffyoushouldknow',
            'https://feeds.megaphone.fm/stuffyoumissedinhistoryclass',
            'https://media.perpetuatech.com/feeds/category/f/Q0RDRUE1M0ZENw',
            'https://www.omnycontent.com/d/playlist/aaea4e69-af51-495e-afc9-a9760146922b/d2c4e775-99ce-4c17-b04c-ac380133d68c/2c6993d0-eac8-4252-8c4e-ac380133d69a/podcast.rss',
            'https://ca-ns-1.bulkstorage.ca/v1/AUTH_0d09c87549084f4ba4ad4a9e807d0d76/11278/feeds/2Z1NJ.xml?temp_url_sig=2e376730d701ec438e41860eafba6627c105b0ff&temp_url_expires=1923141286&inline',
            'https://feed.podbean.com/thatwasgeniuspodcast/feed.xml',
            'http://podcasts.subsplash.com/ec8de47/podcast.rss',
            'https://feeds.megaphone.fm/VMP5705694065',
            'https://feeds.simplecast.com/54nAGcIl'
        ];

        foreach ($test_rss_urls as $rss) {
            Rss::Parse(simplexml_load_file($rss), $rss);
        }
    }
}
