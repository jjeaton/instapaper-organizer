# Instapaper Organizer

An app to help you quickly scan through and organize your Instapaper bookmarks.

![screenshot](https://cloud.githubusercontent.com/assets/835509/18612124/d93a2d9a-7d1e-11e6-8355-d66dbe09d09e.png)

## Why would I need this?

_You wouldn't._

I had nearly 3,000 articles saved in Instapaper and the existing app wasn't designed to allow me to quickly move/archive/delete bookmarks. After the Pinterest acquisition was announced I figured I should get to reading and organizing these before something terrible happens. It was a quick fun app to get some more Laravel experience.

You need a paid Instapaper account with full API access in order to use this app.

I am running the site using [Laravel Valet](https://laravel.com/docs/5.3/valet) on my local machine. No database is required to run the app.

## Configuration

Copy .env.example to .env and provide your Instapaper credentials:

```
INSTAPAPER_CONSUMER_KEY=
INSTAPAPER_CONSUMER_SECRET=
X_AUTH_USERNAME=
X_AUTH_PASSWORD=
```

`SG_FOLDER_ID` is optional, and only used for the `instapaper:seth` artisan command.

## Artisan Commands

```
php artisan instapaper:count
```

Count bookmarks in all folders

```
php artisan instapaper:seth {folder_id}
```

Move all Seth Godin bookmarks in `{folder_id}` to the `seth` folder.

```
php artisan instapaper:folder {folder_id}
```

Move up to 500 bookmarks from Unread to `{folder_id}`. (The API only allows a max of 500 bookmarks returned, so I created multiple folders and put 500 bookmarks in each folder so each could be reviewed.)

## Credits

Uses [InstapaperOauth](https://github.com/randyhoyt/InstapaperOAuth) to connect to the Instapaper API.

## License

[MIT license](http://opensource.org/licenses/MIT).
