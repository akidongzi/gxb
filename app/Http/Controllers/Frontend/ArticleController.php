<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;
use App\Models\ArticleRelLabel;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Plank\Metable\Meta;

class ArticleController extends Controller
{
    protected function defaultListResponse($position)
    {
        $viewPath = 'frontend.list';

        // 模块
        $recommendPosition = $position->getBlockByPosition('JCTJ');
        $hotPosition       = $position->getBlockByPosition('RDPH');

        // 数据
        $perPage = 15;
        $builder = $position->getPageBuild(0);

        $builder = $builder->orderBy('sort', 'desc')
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc');
        $query   = $builder->paginate($perPage);

        // 加载?
        $loading = $query->currentPage() == $query->lastPage() ? false : true;

        // 导航
        $labels = Position::where(['stage' => 1, 'nav_show' => 1])->orderBy('sort')->get();

        return view($viewPath, [
            'list' => $query,
            'labels' => $labels,
            'recommendPosition' => $recommendPosition,
            'hotPosition' => $hotPosition,
            'position' => $position,
            'loading'  => $loading,

        ]);
    }

    protected function viewpointSubjectPageResponse($position)
    {

        $viewPath = 'frontend.guandian-list-new';

        // 模块
        $recommendPosition = $position->getBlockByPosition('JCTJ');
        $hotPosition       = $position->getBlockByPosition('RDPH');

        // 数据
        $perPage = 15;
        $builder = $position->getPageBuild(0);

        $builder = $builder->orderBy('sort', 'desc')
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc');
        $query   = $builder->paginate($perPage);

        // 加载?
        $loading = $query->currentPage() == $query->lastPage() ? false : true;

        // 导航
        $labels = Position::where(['stage' => 1, 'nav_show' => 1])->orderBy('sort')->get();

        return view($viewPath, [
            'list' => $query,
            'labels' => $labels,
            'recommendPosition' => $recommendPosition,
            'hotPosition' => $hotPosition,
            'position' => $position,
            'loading'  => $loading,

        ]);
    }

    protected function overseaPageResponse(Position $position)
    {
        $data = [];
        // 导航
        $labels = Position::where(['stage' => 1, 'nav_show' => 1])->orderBy('sort')->get();

        // 海外推荐头条
        $zggtoutiaoPosition    = Position::where('code', 'ZGGTT')->first();

        // 中国馆新闻
        $zggTimePosition   = Position::where('code', 'ZGG')->first();


        // 中国文化中心
        $zggwhTimePosition   = Position::where('code', 'ZGWHZX')->first();
        $zggwhTimePositionData = $zggwhTimePosition->getData(3);
        // 中国文化中心排行

        // 孔子学院
        $kzxyTimePosition   = Position::where('code', 'KZXY')->first();

        // 对外交流机构
        $dwjlTimePosition   = Position::where('code', 'DWJLJG')->first();

        // 新闻要点
        $newPointsPosition  = Position::where('code', 'QT')->first();

        // 模块
        $zgwhPosition       = $position->getBlockByPosition('ZGWHZX');

//            print_r($newPointsPosition->getData(3)[0]->id); exit;
        $data['zggtoutiaoPosition'] = $zggtoutiaoPosition;
        $data['newPointsPosition'] = $newPointsPosition;
        $data['zggTimePosition'] = $zggTimePosition;
        $data['zggwhTimePosition'] = $zggwhTimePosition;
        $data['kzxyTimePosition'] = $kzxyTimePosition;
        $data['dwjlTimePosition'] = $dwjlTimePosition;
        $data['zgwhPosition'] = $zgwhPosition;
        $data['position'] = $position;
        $data['labels'] = $labels;
        $viewPath = 'frontend.zgg-list';

        return view($viewPath, $data);
    }


    public function index_china(Request $request)
    {
        $viewPath = 'frontend.list';

        // 位置
        $positionId = $request->get('position_id');
        $position = Position::find($positionId);
        $pposition = Position::find($position->parent_id);
        if (!$position) {
            exit;
        }

        if ($position->code == 'GD') {
//            $viewPath = 'frontend.guandian-list';
//            if ($request->get('new_tpl')) {
            $viewPath = 'frontend.guandian-list-new';
//            }
        }else if( $position->code== "ZGG"){
            $viewPath = 'frontend.zgg-list';
        }

        // 模块
        $hotPosition       = $position->getBlockByPosition('RDPH');
        $qtposition = $position->getBlockByPosition('QT');   //  其他

        // 海外推荐头条
        $zggtoutiaoPosition    = Position::where('code', 'ZGGTT')->first();


        // 数据
        $perPage = 15;
        $builder = $position->getPageBuild(0);

        $builder = $builder->orderBy('sort', 'desc')
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc');
        $query   = $builder->paginate($perPage);

        // 加载?
        $loading = $query->currentPage() == $query->lastPage() ? false : true;

        // 导航
        $labels = Position::where(['stage' => 1, 'nav_show' => 1])->orderBy('sort')->get();

        return view($viewPath, [
            'list' => $query,
            'labels' => $labels,
            'qtposition' => $qtposition,
            'hotPosition' => $hotPosition,
            'zggtoutiaoPosition ' => $zggtoutiaoPosition ,
            'position' => $position,
            'pposition' => $pposition,
            'loading'  => $loading,

        ]);
    }

    public function pavilion($position)
    {
        $viewPath = 'frontend.pavilion-list';

        // 位置
        $pposition = Position::find($position->parent_id);
        if (!$position) {
            exit;
        }

        $sideArticle = Article::whereIn("id", explode(",", $position->content_ids))
            ->get();

        // 海外推荐头条
        $zggtoutiaoPosition    = Position::where('code', 'ZGGTT')->first();
        // 数据
        $perPage = 15;
        $builder = $position->getPageBuild(0);

        $builder = $builder->orderBy('sort', 'desc')
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc');
        $query   = $builder->paginate($perPage);

        // 加载?
        $loading = $query->currentPage() == $query->lastPage() ? false : true;

        // 模块
        $recommendPosition = $position->getBlockByPosition('JCTJ');
        $hotPosition       = $position->getBlockByPosition('RDPH');
        $qtposition = $position->getBlockByPosition('QT');   //  其他

        // 导航
        $labels = Position::where(['stage' => 1, 'nav_show' => 1])->orderBy('sort')->get();


        return view($viewPath, [
            'list' => $query,
            'labels' => $labels,
            'qtposition' => $qtposition,
            'recommendPosition' => $recommendPosition,
            'zggtoutiaoPosition ' => $zggtoutiaoPosition ,
            'position' => $position,
            'pposition' => $pposition,
            'sideArticle' => $sideArticle,
            'ext_data' => $position->ext_data,
            'loading'  => $loading,

        ]);
    }

    protected function exchangeActivitySubjectPageResponse($position)
    {
        $listMode = request()->get('list_mode');
        $viewPath = 'frontend.jiaoliuhuodong-waterfall';
        if ($listMode) {
            $viewPath = 'frontend.jiaoliuhuodong-list';
        }

        $headlinePos = Position::where('code', 'JLHDZTYTT')
            ->first();
        $headline = [];
        if ($headlinePos) {
            $headline = $headlinePos->getData();
        }

        // 导航
        $labels = Position::where(['stage' => 1, 'nav_show' => 1])
            ->orderBy('sort')
            ->get();

        $brandActivities = Meta::query()
            ->where(['metable_type' => Article::class, 'key' => Article::META_ACTIVITY_BRAND])
            ->distinct()
            ->select(['value', 'type', 'key'])
            ->get();

        $subActivities = Meta::query()
            ->where(['metable_type' => Article::class, 'key' => Article::META_SUBACTIVITY])
            ->distinct()
            ->select(['value', 'type', 'key'])
            ->get();

        return view($viewPath, [
            'position'          => $position,
            'headline'          => $headline,
            'labels'            => $labels,
            'brand_activities'  => $brandActivities,
            'sub_activities'    => $subActivities,
        ]);
    }

    protected function outsideTheBoxSubjectPageResponse($position)
    {

    }


    public function index(Request $request)
    {
        // 位置
        $positionId = $request->get('position_id');
        $position = Position::find($positionId);
        if (!$position) {
            exit;
        }

        switch ($position->code) {
            //观点
            case 'GD':
                return $this->viewpointSubjectPageResponse($position);
                break;

            //交流活动
            case 'JLHD':
                return $this->exchangeActivitySubjectPageResponse($position);
                break;

            case 'HWPT':
	        return $this->overseaPageResponse($position);
	        break;
            case 'ZGG':  // 海外平台=》中国馆
	        return $this->pavilion($position);
	        break;
            case 'KZXY':// 海外平台=》孔子学院
	        return $this->pavilion($position);
	        break;
            case 'ZGWHZX':// 海外平台=》中国文化中心
	        return $this->pavilion($position);
	        break;
            
            //他山之石
            case 'TSZS':
                return $this->outsideTheBoxSubjectPageResponse($position);
                break;

            default:
                return $this->defaultListResponse($position);
                break;
        }
    }

    /**
     * 搜索
     */
    public function search(Request $request)
    {
        $title = $request->keyword;
        $query = Article::where('title', 'like', '%'. $title . '%');

        $query = $query
            ->orderBy('sort', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        // 加载?
        $loading = $query->currentPage() == $query->lastPage() ? false : true;

        // 导航
        $labels = Position::where(['stage' => 1, 'nav_show' => 1])->orderBy('sort')->get();

         // 模块
        $recommendPosition = Position::where('code', 'JCTJ')->first();
        $hotPosition       = Position::where('code', 'RDPH')->first();

        return view('frontend.search', [
            'list' => $query,
            'labels' => $labels,
            'recommendPosition' => $recommendPosition,
            'hotPosition' => $hotPosition,
            'loading'  => $loading,
            'loading'  => $loading,
        ]);
    }

    public function pages(Request $request)
    {
        $where = [];
        $keys = [];

        $query = Article::where($where);

        if (! empty($request->type)) {
            $query = $query->where('type', (int) $request->type);
        }

        if (! empty($request->last_id)) {
            $query = $query->where('id', '>', $request->last_id);
        }

        if (! empty($request->luts)) {
            $query = $query->where('published_at', '>', date('Y-m-d H:i:s', $request->luts));
        }

        if (! empty($request->position_id) && !empty($position = Position::find($request->position_id))) {
            $lableIds = $position
                            ->labels
                            ->pluck('id')
                            ->unique()
                            ->toArray();

            $articleIds = ArticleRelLabel::whereIn('label_id', $lableIds)
                ->pluck('article_id')
                ->toArray();
            //$articleIds = array_keys(array_count_values($articleIds), count($lableIds));

            $query = $query->whereIn('id', $articleIds);
            $keys[] = $position->name;
        }

        if (!empty($request->title)) {
            $query = $query->where('title', 'like', '%' . $request->title . '%');
        }

        $result = $query
            ->orderBy('sort', 'desc')
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        $last_id = 0;
        $luts = 0;
        if ($result->count()) {
            $last_id = $result[0]['id'];
            $luts = strtotime($result[0]['published_at']);
        }

        if (! empty($position)) {
            switch ($position->code) {
                case 'GD':
                    foreach ($result as & $item) {
                        $author = $item->getMeta(Article::META_AUTHOR);
                        if ($author) {
                            $item->title = $author . ': ' . $item->title;
                        }
                    }
                    break;
            }
        }

        return response()->json(['StatusCode' => 200, 'ResultData' => $result, 'last_id'=>$last_id, 'updated_at' => $luts]);
    }

    public function show(Article $article, Request $request)
    {
        // 位置信息
        $positionId = $request->get('position_id');
        $position   = Position::find($positionId);
        if (!$position) {
            exit;
        }

        $viewPath = 'frontend.info';
        if ($position->code == 'GD') {
            $viewPath = 'frontend.guandian-info';
        }
    
        // 版块
        $recommendPosition = $position->getBlockByPosition('JCTJ');
        $hotPosition       = $position->getBlockByPosition('RDPH');

         // 导航
        $labels = Position::where(['stage' => 1, 'nav_show' => 1])->orderBy('sort')->get();

        // pv
        $article->increment('pv');

        return view($viewPath, [
            'position' => $position,
            'article' => $article,
            'labels' => $labels,

            'recommendPosition' => $recommendPosition,
            'hotPosition' => $hotPosition,
        ]);
    }

    public function apiShow($id)
    {
        $resp = [
            'data'  => null,
            'error' => null,
        ];
        request();

        try {
            $article = Article::find($id);
            if (empty($article)) {
                throw new \Exception('404 Not Found');
            }
            $article->increment('pv');
            $resp['data'] = $article->toArray();

        } catch (\Exception $e) {
            $resp['error'] = $e->getMessage();
        }

        return $resp;
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
            ->where('type', 2)
            ->orderBy('sort', 'desc')
            ->orderBy('created_at', 'desc')
            ->take($num)
            ->get();
    }
}
