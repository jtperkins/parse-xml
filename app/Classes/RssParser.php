<?php

namespace App\Classes;

use App\Models\Podcast;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class RssParser
{
    public static function Parse(SimpleXMLElement $rss_object, string $rss_url)
    {
        if ($podcast = Podcast::where('title', $rss_object->channel->title)->first()) {
            $podcast->update([
                'artwork_url' => $rss_object->channel->image->url,
                'description' => $rss_object->channel->description,
                'language' => $rss_object->channel->language,
            ]);

            if (@isset($rss_object->channel->link)) {
                $podcast->update(['website_url' => $rss_object->channel->link]);
            }

            static::ParseItems($rss_object);
        } else {
            $podcast = Podcast::create([
                'title' => $rss_object->channel->title,
                'artwork_url' => $rss_object->channel->image->url,
                'rss_feed_url' => $rss_url,
                'description' => $rss_object->channel->description,
                'language' => $rss_object->channel->language,
            ]);

            if ($podcast && @isset($rss_object->channel->link)) {
                $podcast->update(['website_url' => $rss_object->channel->link]);
            }

            static::ParseItems($rss_object);
        }
    }

    public static function ParseItems(SimpleXMLElement $rss_object)
    {
        if (count($rss_object->channel->item)) {
            
        }
        
    }
}