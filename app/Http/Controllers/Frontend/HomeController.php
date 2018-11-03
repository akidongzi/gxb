<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleRelLabel;
use App\Models\Banner;
use App\Models\Label;
use App\Models\Position;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 获取轮播图
        $banners = Banner::orderBy('sort', 'desc')
            ->orderBy('sort', 'desc')
            ->take(4)
            ->get();

        // 导航
        $labels = Position::where(['stage' => 1, 'nav_show' => 1])
            ->orderBy('sort', 'asc')
            ->take(16)
            ->get();
// dump($labels->toArray());

        $model = new Position();
        // 实时要闻
        $newsTimePosition   = Position::where('code', 'SSYW')->first();
        // 新闻要点
        $newPointsPosition  = Position::where('code', 'XWYD')->first();
        // 外宣媒体
        $newsOutPosition    = Position::where('code', 'WXMT')->first();
        // 首页头条
        $toutiaoPosition    = Position::where('code', 'TT')->first();
        // 专题活动
        $themePosition      = Position::where('code', 'ZTHD')->first();
        // 本月焦点
        $monthPointPosition = Position::where('code', 'BYJD')->first();
        // 文化投资
        $culturalPosition   = Position::where('code', 'WHTZ')->first();
        // 精彩推荐
        $recommendPosition  = Position::where('code', 'SYJCTJ')->first();
        // $thematicActivities = $this->articlesByPositionId(7, 4);

// dd(1);
        // // 实时要闻
        // $newsTime = $this->articlesByPositionId(42, 5);
        // // 本月焦点
        // $monthPoints = $this->articlesByPositionId(43, 1);
        // // 文化投资
        // $culturalInvestment = $this->articlesByPositionId(44, 4);

        return view('frontend.index', [
            'newPointsPosition'  => $newPointsPosition,
            'newsTimePosition'   => $newsTimePosition,
            'newsOutPosition'    => $newsOutPosition,
            'toutiaoPosition'    => $toutiaoPosition,
            'themePosition'      => $themePosition,
            'monthPointPosition' => $monthPointPosition,
            'culturalPosition'   => $culturalPosition,
            'recommendPosition'  => $recommendPosition,

            'labels' => $labels,
            'banners' => $banners,

            // 'newsPoints' => $newsPoints,
            // 'newsOut' => $newsOut,
            // 'thematicActivities' => $thematicActivities,
            // 'newsTime' => $newsTime,
            // 'monthPoints' => $monthPoints,
            // 'culturalInvestment' => $culturalInvestment,
            // 'model' => new Position(),
        ]);
    }

    private function articlesByPositionId($positionId, $num)
    {
        $position = Position::find($positionId);
        if (empty($position)) return [];

        $lableIds = $position->labels->pluck('id')->unique()->toArray();
        $articleIds = ArticleRelLabel::whereIn('label_id', $lableIds)
            ->pluck('article_id')
            ->toArray();
        $articleIds = array_keys(array_count_values($articleIds), count($lableIds));

        return Article::whereIn('id', $articleIds)
            ->orderBy('sort', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take($num)
            ->get();
    }
}
