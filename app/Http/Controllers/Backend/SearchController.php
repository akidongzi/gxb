<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ArticleRequest;
use App\Models\Article;
use App\Models\ArticleRelLabel;
use App\Models\Label;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class SearchController extends Controller
{
	/**
     * 说明: 综合查询页面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
    	// 参数
    	$params = http_build_query(array_filter([
    		'labels' => $request->labels,
    		'title'  => $request->title,
    		'date'   => $request->date,
    	]));

 		// 获取标签
 		$labels = Label::get();

		// 搜索
 		$tab = $request->get('tab', 'article');

 		switch ($request->tab) {
 			case 'article':
 				$list = $this->getArticleCollection($request);
 				break;
 			case 'atlas':
 				$list = $this->getAtlasCollection($request);
 				break;
 			case 'video':
 				$list = $this->getVideoCollection($request);
 				break;
 			default:
 				$list = $this->getArticleCollection($request);
 				break;
 		}


    	return view('backend.search.index',[
    		'labels' => $labels,
    		'list'   => $list,
    		'params' => $params,
    	]);
    }

    protected function getArticleCollection(Request $request) 
    {
    	$title  = $request->get('title');
    	$labels = $request->get('labels');
    	$date   = $request->get('date');

    	$query = Article::where([
    		'type' => 1,
    	]);
    	if ( !empty($title)) {
            $query = $query->where('title', 'like', '%' . $title . '%');
        }
        if ( !empty($labels)) {
        	$arrArticleId = ArticleRelLabel::whereIn('label_id', $labels)
	            ->pluck('article_id')
	            ->toArray();
	        $query = $query->whereIn('id', $arrArticleId);
        }
        if ( !empty($date)) {
        	$query = $query->whereDate('created_at', $date);
        }


		$list = $query
            ->orderBy('created_at', 'desc')
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->appends($request->all());
        return $list;
    }

    protected function getAtlasCollection(Request $request)
    {
    	$title  = $request->get('title');
    	$labels = $request->get('labels');
    	$date   = $request->get('date');

    	$query = Article::where([
    		'type' => 2,
    	]);
    	if ( !empty($title)) {
            $query = $query->where('title', 'like', '%' . $title . '%');
        }
        if ( !empty($labels)) {
        	$arrArticleId = ArticleRelLabel::whereIn('label_id', $labels)
	            ->pluck('article_id')
	            ->toArray();
	        $query = $query->whereIn('id', $arrArticleId);
        }
        if ( !empty($date)) {
        	$query = $query->whereDate('created_at', $date);
        }

		$list = $query
            ->orderBy('created_at', 'desc')
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->appends($request->all());
        return $list;
    }


    protected function getVideoCollection(Request $request)
    {
    	$list = $query = Video::orderBy('id', 'desc')
 			->paginate(15)
            ->appends($request->all());

    	return $list;
    }
}