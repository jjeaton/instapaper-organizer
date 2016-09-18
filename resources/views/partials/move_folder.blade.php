<form method="post" action="{{action('BookmarksController@move', $bookmark->bookmark_id)}}" class="js-move-bookmark" style="display: inline-block;">
	<select name="folder_id" data-bookmark-id="{{ $bookmark->bookmark_id }}">
		<option value="unread">Unread</option>
		@foreach($folders as $folder_id => $folder)
			<option value="{{ $folder_id }}" {{ ( $folder_id == $currentFolderId ) ? 'selected' : '' }}>{{ $folder }}</option>
		@endforeach
	</select>
	<input type="submit" value="Move" class="btn btn-default">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="bookmark_id" value="{{ $bookmark->bookmark_id }}">
</form>
