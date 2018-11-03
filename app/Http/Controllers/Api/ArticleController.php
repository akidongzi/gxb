<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ArticleApiException as AAE;
use App\Models\Article;
use App\Models\ArticleRelLabel;
use App\Models\Label;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Api\ArticleRequest;
use DB;
use Illuminate\Support\Facades\Log;

/**
 * 文章入库
 */
class ArticleController extends Controller
{
    protected function coverFilter($covers)
    {
        return array_filter($covers, function ($val) {
            $minWidth = 300;
            $info = @getimagesize($val);
            if (
                ! $info ||
                $info[0] < $minWidth
            ) {
                //竖图不用做封面
                return false;
            }
            return true;
        });
    }

	public function store(ArticleRequest $request)
    {
        $resp = [
            'errno' => 0,
            'data'  => null,
        ];

        $article = null;
        $trans = false;

    	try {
            Log::debug('api.article.post.debug', ['data' => $request->all()]);

            $covers = $request->input('covers', []);
            $covers = $this->coverFilter($covers);

            DB::beginTransaction();
            $trans = true;

            $article = new Article();
            $article->title         = $request->input('title');
            $article->covers        = $covers;
            $article->brief         = $request->input('brief');
            $article->url           = $request->input('url');
            $article->author        = $request->input('author');
            $article->content       = $request->input('content');
            $article->source        = $request->input('source');
            $article->published_at  = $request->input('published_at');
            $article->bot           = 1;
            $article->save();

            // 标签
            $labels = $request->input('labels');
            if ($labels) {
                foreach ($labels as $label) {
                    $labelModel = Label::where('name', $label)
                        ->first();
                    if (! $labelModel) {
                        Log::debug('api.article.post.debug', ['unknown_label' => $label]);
                        continue;
                    }
                    $reLabelModel = new ArticleRelLabel();
                    $reLabelModel->article_id = $article->id;
                    $reLabelModel->label_id   = $labelModel->id;
                    $reLabelModel->save();
                }
            }

            // 图集 Todo: 确认是否需要
//            $atlases = $request->input('atlases');
//            if ($atlases) {
//            }

            //throw AAE::e(AAE::ERR_SERVER_ERROR);

            DB::commit();

        } catch (\Exception $e) {
            if ($trans) {
                DB::rollBack();
            }

            if ($e instanceof AAE) {
                $resp['errno'] = $e->getCode();
                $resp['errors'][] = $e->getMessage();

            } else {
                $resp['errno'] = AAE::ERR_SERVER_ERROR;
                $resp['errors'][] = AAE::m(AAE::ERR_SERVER_ERROR);
            }

            Log::error('api.article.post.error',  $e->getTrace());
        }

        return $resp;
    }
}