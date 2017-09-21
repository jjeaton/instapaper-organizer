<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\Instapaper\Instapaper;

class FolderCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instapaper:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count bookmarks in all folders';

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

        $counts = [];
        $total = 0;
        $folders = $instapaper->client->list_folders();

        $bookmarks = $instapaper->client->list_bookmarks( 500, 'unread' );
        $counts[] = ['unread', count($bookmarks)];

        foreach ($folders as $key => $folder) {
            $bookmarks = $instapaper->client->list_bookmarks( 500, $folder->folder_id );
            $count = count($bookmarks);
            $counts[] = [$folder->title, $count];
            $total += $count;
        }

        $counts[] = ['Total', $total];
        $this->table(['Folder', 'Count'], $counts);
    }
}
