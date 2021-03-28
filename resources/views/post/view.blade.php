@extends('layouts.index')

@section('content')

    <div class="container">
        @if($post_edit == 1)
            <div class="right-top-btns">
                <div class="right-top-btns-item js-link-copy" data-link="{{ route('show', ['slug' => $post['url_edit']]) }}">Editable Link</div>
                <div class="right-top-btns-item js-link-copy" data-link="{{ route('show', ['slug' => $post['url_view']]) }}">Share Link</div>
            </div>
            <form method="post" action="{{ route('update', ['slug' => $post['url_edit']], false) }}" onsubmit="return false;">
                @csrf
                <textarea name="content" class="js-content main-textarea" autofocus>{{ $post['content'] }}</textarea>
            </form>
        @else
            <div class="right-top-btns">
                <div class="right-top-btns-item js-select-all">Select All</div>
            </div>
            <div class="content-view" id="content_view">{{ $post['content'] }}</div>
        @endif

        <a href="/" target="_blank" class="container-logo">Sketchpad.pw</a>
    </div>

@endsection