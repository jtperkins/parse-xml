<?php

namespace App\Jobs;

use App\Classes\RssParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class HandleRss implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $rss_path;

    private $rss_url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rss_path, $rss_url)
    {
        $this->rss_path = $rss_path;

        $this->rss_url = $rss_url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        RssParser::Parse(simplexml_load_file($this->rss_path), $this->rss_url);

        Storage::delete($this->rss_path);
    }
}
