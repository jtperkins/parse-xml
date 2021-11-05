<?php

namespace App\Jobs;

use App\Classes\Rss;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class HandleRss implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $rss_full_path;

    private $rss_relative_path;

    private $rss_url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rss_full_path, $rss_relative_path, $rss_url)
    {
        $this->rss_full_path = $rss_full_path;

        $this->rss_relative_path = $rss_relative_path;

        $this->rss_url = $rss_url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Rss::Parse(simplexml_load_file($this->rss_full_path), $this->rss_url);

        Storage::delete($this->rss_relative_path);
    }
}
