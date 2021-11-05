<?php

namespace App\Classes;

use App\Models\Episode;
use App\Models\Podcast;
use Carbon\Carbon;
use SimpleXMLElement;

class Rss
{
    public static function Parse(SimpleXMLElement $rss_object, string $rss_url)
    {
        if ($podcast = Podcast::firstWhere(['rss_feed_url' => $rss_url])) {

            $podcast->update([
                'artwork_url' => isset($rss_object->channel->image->url) ? $rss_object->channel->image->url : null,
                'description' => isset($rss_object->channel->description) ? $rss_object->channel->description : null,
                'website_url' => isset($rss_object->channel->link) ? $rss_object->channel->link : null
            ]);

            static::_parse_tems($rss_object, $podcast);

        } else {

            $podcast = Podcast::create([
                'title' => isset($rss_object->channel->title) ? $rss_object->channel->title : null,
                'artwork_url' => isset($rss_object->channel->image->url) ? $rss_object->channel->image->url : null,
                'rss_feed_url' => $rss_url,
                'description' => isset($rss_object->channel->description) ? $rss_object->channel->description : null,
                'language' => $rss_object->channel->language,
                'website_url' => isset($rss_object->channel->link) ? $rss_object->channel->link : null
            ]);

            static::_parse_tems($rss_object, $podcast);

        }
    }

    public static function _parse_tems(SimpleXMLElement $rss_object, Podcast $podcast)
    {
        $episodes = [];

        if (count($rss_object->channel->item)) {

            foreach ($rss_object->channel->item as $item) {

                if (!Episode::firstWhere(['title' => $item->title, 'podcast_id' => $podcast->id])) {

                    $now = Carbon::now();

                    $episodes[] = [
                        'title' => $item->title,
                        'audio_url' => isset($item->enclosure['url']) ? $item->enclosure['url'] : null,
                        'description' => isset($item->description) ? $item->description : null,
                        'episode_url' => isset($item->link) ? $item->link : null,
                        'podcast_id' => $podcast->id,
                        'created_at' => $now,
                        'updated_at' => $now
                    ];

                }

            }

            Episode::insert($episodes);

        }
        
    }

}