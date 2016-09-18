<select name="folder" id="js-folder-select">
	<option value="unread">Unread</option>
	@foreach($folders as $folder_id => $folder)
		<option value="{{ $folder_id }}" {{ ( $folder_id == $currentFolderId ) ? 'selected' : '' }}>{{ $folder }}</option>
	@endforeach
</select>
