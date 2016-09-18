<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\Instapaper\Instapaper;

class Move extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:folder {folder_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move 500 unread bookmarks to the specified folder.';

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

        $folder_id = intval( $this->argument('folder_id') );
        $bookmarks = $instapaper->client->list_bookmarks( 500, 'unread' );
        $bar = $this->output->createProgressBar(count($bookmarks));

        $moved = 0;
        foreach ($bookmarks as $bookmark) {
            if ( $bookmark->type === "bookmark" ) {
                $instapaper->request('bookmarks/move', [
                    'bookmark_id' => intval($bookmark->bookmark_id),
                    'folder_id' => $folder_id,
                ]);
                $moved++;
                $bar->advance();
                sleep(rand(0,2));
            }
        }
        $bar->finish();
        $this->line('Moved ' . $moved . ' bookmarks.');
    }
}
