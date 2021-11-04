<?php

namespace App\Console\Commands;

use App\Jobs\HandleRss;
use App\Models\Podcast;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RssFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:feed {feed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used to retrieve and parse an RSS feed';

    /**
     * The console command help text.
     *
     * @var string
     */
    protected $help = 'You can figure it out.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rss_feed = $this->argument('feed');

        if ($rss_feed) $rss_object = @simplexml_load_file($rss_feed);

        if ($rss_object) {

            // TODO: logic to check if directory already exists?
            Storage::makeDirectory('rss');

            $path = storage_path().'/app/rss/'.$rss_object->channel->title.'.xml';

            $rss_object->asXml($path);

            HandleRss::dispatch($path, $rss_feed);

            $this->info('The rss_feed was found and job started.');

        } else {

            $this->error('Uh-oh, no rss feed was found!');

        }

        return Command::SUCCESS;
    }
}
