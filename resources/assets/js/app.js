
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: 'body'
});

$(document).ready(function() {
	$('#js-folder-select').on('change', function() {
		var folderId = $( this ).find( 'option:selected' ).val();
		var currentUrl = window.location;

		window.location = currentUrl.href.replace( /\/list\/?.*$/, '\/list\/' + folderId );
		return;
	});

	$('#bookmark-list').on('click', '.js-archive-bookmark', function(e) {
		e.preventDefault();

		var $this = $( this );
		var bookmarkId = $this.data('id');
		var $row = $this.closest('li');
		window.console.log(APP_URL + '/ajax/archive/' + parseInt(bookmarkId, 10));
		$.ajax(
			APP_URL + '/ajax/archive/' + parseInt(bookmarkId, 10)
		).done(function(resp) {
			console.log(resp);
			$row.fadeOut('fast', function() {
				$( this ).remove();
			});
		}).fail(function(resp) {
			console.log(resp);
		});
	});

	$('#bookmark-list').on('click', '.js-delete-bookmark', function(e) {
		e.preventDefault();

		var $this = $( this );
		var bookmarkId = $this.data('id');
		var $row = $this.closest('li');
		window.console.log(APP_URL + '/ajax/delete/' + parseInt(bookmarkId, 10));
		$.ajax(
			APP_URL + '/ajax/delete/' + parseInt(bookmarkId, 10)
		).done(function(resp) {
			console.log(resp);
			$row.fadeOut('fast', function() {
				$( this ).remove();
			});
		}).fail(function(resp) {
			console.log(resp);
		});
	});

	$(document).on('submit', '.js-move-bookmark', function(e) {
		var $this = $(this);
		var token = $this.find('input[name=_token]').val();
		var folderId = $this.find( 'option:selected' ).val();
		var bookmarkId = $this.find('input[name=bookmark_id]').val();
		var $row = $this.closest('li');

		$.ajax({
			'type': 'POST',
			'url': APP_URL + '/ajax/move/' + parseInt(bookmarkId, 10),
			'data': {
				'_token': token,
				'folder_id': folderId
			}
		}).done(function(resp) {
			console.log(resp);
			$row.fadeOut('fast', function() {
				$( this ).remove();
			});
		}).fail(function(resp) {
			console.log(resp);
		});

		e.preventDefault();
	});

});
