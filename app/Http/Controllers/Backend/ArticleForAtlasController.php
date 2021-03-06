<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ArticleForAtlasRequest;
use App\Models\Article;
use App\Models\ArticleRelLabel;
use App\Models\Label;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleForAtlasController extends Controller
{
    /**
     * 说明: 图集文章管理列表页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function index(Request $request)
    {
        $where = ['type' => 2];

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

        return view('backend.article_atlas.index', ['articles' => $result]);
    }

    /**
     * 说明: 创建图集文章视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function create()
    {
        $labels = Label::get();
        return view('backend.article_atlas.create', ['labels' => $labels]);
    }

    /**
     * 说明: 添加图集文章
     *
     * @param ArticleForAtlasRequest $request
     * @return mixed
     * @author 郭庆
     */
    public function store(ArticleForAtlasRequest $request)
    {

        \DB::beginTransaction();
        try {

            $article = new Article;
            $article->title = $request->title;
            $article->source = $request->source;
            $article->type = 2;
            $article->brief = $request->brief;
            $article->url = $request->url;
            $article->author = $request->author;
            $article->sort = $request->sort??0;
            $article->published_at = date('Y-m-d H:i:s');
            $article->save();
            
            foreach ($request->labels as $labelId) {
                ArticleRelLabel::create([
                    'article_id' => $article->id,
                    'label_id' => $labelId
                ]);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('admin.article_atlas.index')->withFlashDanger('添加图集文章失败' . $e->getMessage());
        }

        return redirect()->route('admin.article_atlas.index')->withFlashSuccess('添加图集文章成功');
    }

    /**
     * 说明: 修改视图
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $labels = Label::get();

        return view('backend.article_atlas.edit', ['labels' => $labels, 'article' => $article]);
    }

    /**
     * 说明: 修改图集文章
     *
     * @param $id
     * @param ArticleForAtlasRequest $request
     * @return mixed
     * @author 郭庆
     */
    public function update($id, ArticleForAtlasRequest $request)
    {
        $article = Article::findOrFail($id);

        \DB::beginTransaction();
        try {
            Article::where(['id' => $article->id])->update([
                'title' => $request->title,
                'source' => $request->source,
                'brief' => $request->brief,
                'url' => $request->url,
                'author' => $request->author,
                'sort' => $request->sort??0,
            ]);

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
            return redirect()->route('admin.article_atlas.index')->withFlashDanger('添加图集文章失败' . $e->getMessage());
        }

        return redirect()->route('admin.article_atlas.index')->withFlashSuccess('修改图集文章成功');
    }

    /**
     * 说明: 删除图集文章
     *
     * @param $id
     * @author 郭庆
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $article->delete();

        return redirect()->route('admin.article_atlas.index')->withFlashSuccess('删除图集文章成功');
    }
}
