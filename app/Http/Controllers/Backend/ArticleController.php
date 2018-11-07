<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ArticleRequest;
use App\Models\Article;
use App\Models\ArticleRelLabel;
use App\Models\Label;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Services\Aliyun\OssClientService;



class ArticleController extends Controller
{
    /**
     * 说明: 文章管理列表页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function index(Request $request)
    {
        $where = ['type' => 1];

        $query = Article::where($where);

        if (!empty($request->title)) {
            $query = $query->where('title', 'like', '%' . $request->title . '%');
        }

        $result = $query
            ->orderBy('created_at', 'desc')
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->appends($request->all());

        return view('backend.article.index', ['articles' => $result]);
    }

    /**
     * 说明: 创建文章视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function create()
    {
        $labels = Label::get();
        $data = [
            'labels'    => $labels,
            'countries' => Region::where('type', 1)
                ->get(),
            'cities'    => Region::where('type', 3)
                ->get(),
        ];

        return view('backend.article.create', $data);
    }


    /**
     * 说明: 添加文章
     *
     * @param ArticleRequest $request
     * @return mixed
     * @author 郭庆
     */
    public function store(ArticleRequest $request)
    {
        \DB::beginTransaction();
        try {
            $article = new Article();
            $arrCover = explode(',', $request->pics);  
            foreach ($arrCover as $k => $val) {
                $info = parse_url($val);
                $arrCover[$k] = $info['path'];
            }

            if (empty($arrCover)) {
                $arrCover = null;
            }

            $article->covers = $arrCover;
            $article->title  = trim($request->title);
            $article->source = trim($request->source);
            $article->brief  = trim($request->brief);
            $article->url    = trim($request->url);
            $article->author = trim($request->author);
            $article->sort   = $request->sort??0;
            $article->content = $request->get('content');
            $article->published_at = date('Y-m-d H:i:s');
            $article->fake_pv   = $request->get('fake_pv');
            $article->type   = 1;

            $article->save();

            $metas = (array) $request->get('meta');
            foreach ($metas as $metaKey => $metaValue) {
                if (! empty($metaValue)) {
                    $article->setMeta($metaKey, $metaValue);
                }
            }

            foreach ($request->labels as $labelId) {
                ArticleRelLabel::create([
                    'article_id' => $article->id,
                    'label_id' => $labelId,
                ]);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('admin.articles.index')->withFlashError('添加文章失败');
        }

        return redirect()->route('admin.articles.index')->withFlashSuccess('添加文章成功');
    }

    /**
     * 说明: 修改视图
     *
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function edit(Article $article)
    {
        $labels = Label::get();
        $data = [
            'labels'        => $labels,
            'article'       => $article,
            'countries'     => Region::where('type', 1)
                                ->get(),
            'cities'        => Region::where('type', 3)
                                ->get(),
        ];

        return view('backend.article.edit', $data);
    }

    /**
     * 说明: 修改文章
     *
     * @param Article $article
     * @param ArticleRequest $request
     * @return mixed
     * @author 郭庆
     */
    public function update(Article $article, ArticleRequest $request)
    {
        \DB::beginTransaction();
        try {

            $arrCover = explode(',', $request->pics);
            foreach ($arrCover as $k => $val) {
                $info = parse_url($val);
                $arrCover[$k] = $info['path'];
            }
            if (empty($arrCover)) {
                $arrCover = null;
            }

            $article->covers = $arrCover;
            $article->title  = trim($request->title);
            $article->source = trim($request->source);
            $article->brief  = trim($request->brief);
            $article->url    = trim($request->url);
            $article->author = trim($request->author);
            $article->sort   = $request->sort??0;
            $article->content = $request->get('content');
            $article->fake_pv   = $request->get('fake_pv');
            if (empty($article->published_at)) {
                $article->published_at = date('Y-m-d H:i:s');
            }

            $metas = (array) $request->get('meta');
            foreach ($metas as $metaKey => $metaValue) {
                if (! empty($metaValue)) {
                    $article->setMeta($metaKey, $metaValue);
                } else {
                    if ($article->hasMeta($metaKey)) {
                        $article->removeMeta($metaKey);
                    }
                }
            }

            $article->save();

            if ($request->labels != $article->labels->pluck('id')->toArray()) {
                ArticleRelLabel::where('article_id', $article->id)->delete();

                foreach ($request->labels as $labelId) {
                    ArticleRelLabel::create([
                        'article_id' => $article->id,
                        'label_id' => $labelId
                    ]);
                }
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('admin.articles.index')->withFlashError('更新文章失败');
        }

        return redirect()->route('admin.articles.index')->withFlashSuccess('修改文章成功');
    }

    /**
     * 说明: 删除文章
     *
     * @param Article $article
     * @return mixed
     * @author 郭庆
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->withFlashSuccess('删除文章成功');
    }

    public function uploadBanner(Request $request, OssClientService $ossClientService)
    {
        $resp = [
            'StatusCode' => 400,
            'ResultData' => null
        ];

        try {
            if ($request->hasFile('banner')) {
                $file   = $request->file('banner');
                $path   = $file->getPathName();
                // 上传到 oss
                $object = $ossClientService->uploadFile($path);
                $url    = $ossClientService->getFullPicUrl($object);

                $resp = [
                    'StatusCode' => 200,
                    'ResultData' => $url
                ];
            }

        } catch (\Exception $e) {
            $resp['ResultData'] = '上传缩略图错误: ' . $e->getMessage();
        }

        return $resp;
    }
}
