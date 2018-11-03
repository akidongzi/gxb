<?php

Route::middleware(['mobile.nav'])->group(function () {
    Route::get('/', 'IndexController@index')
        ->name('index');

    Route::get('/list', function () {
        return view('mobile.list');
    })->name('list');

    Route::get('/list-gallery', function () {
        return view('mobile.list-gallery');
    })->where(['id' => '[0-9]+'])
        ->name('gallery.list');

});

Route::get('/api/pages', 'IndexController@pages')
    ->name('article.pages');
Route::get('/api/recommend_pages', 'IndexController@recommend')
    ->name('article.recommend');

Route::get('/article', function () {
    return view('mobile.article');
})->name('article.detail');


Route::get('/article', 'IndexController@article')
    ->name('article.detail');

Route::get('/list-video', function () {
    return view('mobile.list-video');
})->where(['id' => '[0-9]+'])
    ->name('video.list');

Route::get('/gallery', function () {
    return view('mobile.photo-gallery');
})->where(['id' => '[0-9]+'])
    ->name('gallery.detail');

Route::get('/search', function () {
    return view('mobile.search');
})->where(['id' => '[0-9]+'])
    ->name('search');

