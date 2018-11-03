<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware'    => [],
    'namespace' => 'Frontend',
], function () {
    Route::get('article/{id}', [
        'uses'      => 'ArticleController@apiShow'
    ])->where(['id' => '[0-9]+']);

    Route::get('article_pages', [
        'uses'      => 'ArticleController@pages'
    ]);
});

Route::group([
    'middleware'    => [],
    'namespace' => 'Backend',
], function () {
    Route::get('list_videos',  'VideoController@apiListVideos');
});


// 由爬虫服务调用的相关接口
Route::group([
    'middleware' => ['signature'],
    'namespace'  => 'Api'
], function () {
    // 文章入库
    Route::post('v1/article', 'ArticleController@store');
});

Route::group([
    'namespace'  => 'Api'
], function () {

    //国家城市查询接口v1
    Route::get('v1/region', [
        'middleware'    => [],
        'uses'          => 'MiscController@countryCityCascade',
    ])->name('api.v1.country-city-query');

    //专题页数据接口v2
    Route::get('v2/subject/{id}', [
        'middleware'    => [],
        'uses'          => 'SubjectController@subjectPageData',
    ])->where('id', '[0-9]+')
        ->name('api.v2.subject-page-data');
});