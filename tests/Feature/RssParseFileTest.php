<?php

namespace Tests\Feature;

use App\Models\Podcast;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RssParseFileTest extends TestCase
{
    /**
     * Test Parsing SimpleXMLElement.
     *
     * @return void
     */
    public function test_parsing_xml_object(string $description = 'testing out atributes and properties of the SimpleXlmElement')
    {
        $rss_object = @simplexml_load_file('https://nosleeppodcast.libsyn.com/rss');

        $path = storage_path().'/app/rss/'.$rss_object->channel->title.'.xml';

        $rss_object->asXML($path);

        $this->assertTrue(property_exists($rss_object, 'channel'));

        $this->assertTrue((isset($rss_object->channel)));

        $this->assertTrue((isset($rss_object->channel->title)));

        $this->assertTrue(count($rss_object->channel->item) > 0);

        $this->assertTrue($rss_object->channel->item->count() > 0);

        $this->assertTrue(isset($rss_object->channel->item[0]));

        $this->assertTrue(isset($rss_object->channel->item[0]->enclosure['url']));

        $this->assertFalse(isset($rss_object->testing));

        $rss_object->testing = '';
        $this->assertFalse(isset($rss_object->testing) && !$rss_object->testing);
    }
}
