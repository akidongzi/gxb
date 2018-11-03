<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Atlas;
use App\Models\Video;
use App\Models\Label;
use App\Models\Position;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
    	// 内容数量统计
    	$articleNum  = Article::where('type', 1)->count();
    	$atlasNum    = Article::where('type', 2)->count();
    	$videoNum    = Video::count();
    	$labelNum    = Label::count();
    	$positionNum = Position::count();

        return view('backend.dashboard', [
        	'articleNum'  => $articleNum,
        	'atlasNum'    => $atlasNum,
        	'videoNum'    => $videoNum,
        	'labelNum'    => $labelNum,
        	'positionNum' => $positionNum,
        ]);
    }
}
