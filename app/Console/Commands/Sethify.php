<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\Instapaper\Instapaper;

class Sethify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instapaper:seth {folder_id=unread}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move Seth Godin posts into folder.';

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
     * @return mixed
     */
    public function handle()
    {
        $instapaper = new Instapaper();
        $instapaper->login();
        $instapaper->is_user_active();

        $folder_id = $this->argument('folder_id');
        if ('unread' !== $folder_id) {
            $folder_id = intval($folder_id);
        }

        $bookmarks = $instapaper->client->list_bookmarks(500, $folder_id);

        $moved = 0;
        foreach ($bookmarks as $bookmark) {
            if ( $bookmark->type === "bookmark" ) {
                if (false !== stripos($bookmark->url, 'seths.blog') ) {
                    $this->line('Moving ' . $bookmark->bookmark_id . ': ' . $bookmark->url);
                    $instapaper->request('bookmarks/move', [
                        'bookmark_id' => intval($bookmark->bookmark_id),
                        'folder_id' => intval(env('SG_FOLDER_ID')),
                    ]);
                    $moved++;
                    sleep(rand(0,2));
                }
            }
        }
        $this->line('Moved ' . $moved . ' bookmarks.');
    }
}
