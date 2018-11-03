<?php

/**
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);

Route::get(
    'dashboard',
    'DashboardController@index'
)->name('dashboard');

Route::resource('labels', 'LabelController');

Route::resource('articles', 'ArticleController');
Route::resource('article_atlas', 'ArticleForAtlasController');
Route::resource('article_has_atlas', 'ArticleHasAtlasController');

Route::resource('banners', 'BannerController');
Route::post('uploadBanner', 'ArticleController@uploadBanner');
Route::resource('positions', 'PositionController');

// 绑定内容
Route::get('positions_content/{position}', 'PositionReContentController@content');
Route::post(
    'positions_saveContent/{position}',
    'PositionReContentController@save'
)->name('saveContent');

// 检索
Route::resource('search', 'SearchController');

// 绑定标签
Route::get(
    'positions_labels/{position}',
    'PositionRelLabelController@Labels'
);

//标签查询接口
Route::get(
    'api/labels',
    'LabelController@Labels'
)->name('api.labels');

Route::post(
    'positions_saveLabels/{position}',
    'PositionRelLabelController@saveLabels'
)->name('savelables');

Route::resource('videos', 'VideoController');

Route::resource('blocks', 'BlockController');