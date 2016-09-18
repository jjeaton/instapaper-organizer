<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Libraries\Instapaper\Instapaper;

class BookmarksController extends Controller
{
    public function getInstapaper() {
        $instapaper = new Instapaper();
        $instapaper->login();
        $instapaper->is_user_active();
        return $instapaper;
    }

    public function getFolders() {
        $instapaper = $this->getInstapaper();
        $apiFolders = $instapaper->client->list_folders();
        $folders = [];

        foreach ($apiFolders as $key => $folder) {
            $folders[ $folder->folder_id ] = $folder->title;
        }

        return $folders;
    }

    public function folders() {
        return response()->json( $this->getFolders(), 200 );
    }

    public function index($folder_id = 'unread') {
        $instapaper = $this->getInstapaper();

        $folders = $this->getFolders();
        $bookmarks = $instapaper->client->list_bookmarks( 500, $folder_id );

        $currentFolder = ( $folder_id === 'unread' ) ? 'Unread' : $folders[ $folder_id ];

        return view('list', [
            'bookmarks' => $bookmarks,
            'currentFolderId' => $folder_id,
            'currentFolderTitle' => $currentFolder,
            'folders' => $folders,
        ]);
    }

    public function archive($id) {
        $instapaper = $this->getInstapaper();

        $instapaper->request('bookmarks/archive', ['bookmark_id' => intval( $id )]);
        return redirect('/list');
    }

    public function delete($id) {
        $instapaper = $this->getInstapaper();

        $instapaper->request('bookmarks/delete', ['bookmark_id' => intval( $id )]);
        return redirect('/list');
    }

    public function move(Request $request, $id) {
        $instapaper = $this->getInstapaper();
        $folder_id = $request->input('folder_id');

        $instapaper->request('bookmarks/move', [
            'bookmark_id' => intval($id),
            'folder_id' => intval($folder_id),
        ]);
        return redirect('/list/' . $folder_id);
    }

    public function ajaxArchive($id) {
        $instapaper = $this->getInstapaper();

        $response = $instapaper->request('bookmarks/archive', ['bookmark_id' => intval( $id )]);
        return response()->json($response, 200);
    }

    public function ajaxDelete($id) {
        $instapaper = $this->getInstapaper();

        $response = $instapaper->request('bookmarks/delete', ['bookmark_id' => intval( $id )]);
        return response()->json($response, 200);
    }

    public function ajaxMove(Request $request, $id) {
        $instapaper = $this->getInstapaper();
        $folder_id = $request->input('folder_id');

        $response = $instapaper->request('bookmarks/move', [
            'bookmark_id' => intval($id),
            'folder_id' => intval($folder_id),
        ]);
        return response()->json($response, 200);
    }
}
