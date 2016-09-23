@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Folder: {{ $currentFolderTitle }} ({{$totalBookmarks}}) <span style="float:right;">Switch to: @include('partials.switch_folder')</span></div>
                <div class="panel-body">
                    <ol id="bookmark-list">
                        @foreach ($bookmarks as $bookmark)
                            @if ( $bookmark->type === "bookmark" )
                                <li>
                                    <a href="{{ $bookmark->url }}">
                                        {{ $bookmark->title }}
                                    </a>
                                    <a href="{{action('BookmarksController@show', $bookmark->bookmark_id)}}">-</a>
                                     <button data-id="{{$bookmark->bookmark_id}}" class="js-archive-bookmark"><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span></button>
                                    - <button data-id="{{$bookmark->bookmark_id}}" class="js-delete-bookmark"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                                    - @include('partials.move_folder')
                                   <br>
                                   <small style="color:#888;">{{ $bookmark->url }}</small>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
