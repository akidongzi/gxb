<?php
/**
 * Created by PhpStorm.
 * User: lindowx
 * Date: 2018/10/29
 * Time: 13:09
 */
namespace App\Http\Controllers\Api;

use App\Exceptions\SubjectApiException as SubjAE;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleRelLabel;
use App\Models\Label;
use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Plank\Metable\Meta;

/**
 * Class SubjectController
 * @package App\Http\Controllers\Api
 */
class SubjectController extends Controller
{
    /**
     * @param Position $pos
     * @param array $fetches
     * @return array
     */
    protected function exchangeActivityData(Position $pos, array $fetches)
    {
        $respData = [];
        $request = request();

        foreach ($fetches as $key) {
            switch ($key) {
                case 'tags':
                    $tags = Label::orderByRaw('RAND()')->take(15)->get();
                    foreach ($tags as $tag) {
                        $respData['tags'][] = [
                            'id'    => $tag->id,
                            'name'  => $tag->name,
                        ];
                    }
                    break;

                case 'articles':

                    $articleParams = (array) $request->get('articles');
                    $page = $articleParams['page'] ?? 1;


                    $query = Article::query();
                    $metaQuery = null;
                    $articleIdIn = null;
                    $tagIdIn = $pos->labels->pluck('id');

                    /**
                     * 查询满足meta条件的文章id
                     *
                     * @param $key
                     * @param $operator
                     * @param null $value
                     * @return \Illuminate\Support\Collection
                     */
                    $whereMeta = function ($key, $operator, $value = null) {
                        if ($value == null) {
                            $value = $operator;
                            $operator = '=';
                        }

                        $metaQuery = Meta::query()
                            ->where('metable_type', Article::class)
                            ->where('key', $key)
                            ->where('value', $operator, $value);

                        return $metaQuery->get()->pluck('metable_id');
                    };

                    //设置文章id列表
                    $setArticleIn = function ($in) use(& $articleIdIn) {

                        if ($articleIdIn == null) {
                            $articleIdIn = $in;
                        } else {
                            $articleIdIn = $articleIdIn->intersect($in);
                        }
                    };

                    if (! empty($articleParams['type'])) {
                        $query->where('type', $articleParams['type']);
                    }

                    //标签筛选
                    if (! empty($articleParams['tid'])) {
                        $tags = explode(',', trim($articleParams['tid']));
                        $tagIdIn = $tagIdIn->intersect($tags);
                    }
                    //兼顾默认标签筛选
                    $articleIds = ArticleRelLabel::whereIn('label_id', $tagIdIn)
                        ->get()
                        ->pluck('article_id');
                    $setArticleIn($articleIds);


                    if (! empty($articleParams['ats'])) {
                        $metableIds = $whereMeta(Article::META_ACTIVITY_START_TIME, '<=', $articleParams['ats']);
                        $setArticleIn($metableIds);
                        $metableIds = $whereMeta(Article::META_ACTIVITY_END_TIME, '>=', $articleParams['ats']);
                        $setArticleIn($metableIds);
                    }

                    if (! empty($articleParams['ate'])) {
                        $metableIds = $whereMeta(Article::META_ACTIVITY_START_TIME, '<=', $articleParams['ate']);
                        $setArticleIn($metableIds);
                        $metableIds = $whereMeta(Article::META_ACTIVITY_END_TIME, '>=', $articleParams['ate']);
                        $setArticleIn($metableIds);
                    }

                    if (! empty($articleParams['act'])) {
                        $metableIds = $whereMeta(Article::META_ACTIVITY_BRAND, $articleParams['act']);
                        $setArticleIn($metableIds);
                    }

                    if (! empty($articleParams['sact'])) {
                        $metableIds = $whereMeta(Article::META_SUBACTIVITY, $articleParams['sact']);
                        $setArticleIn($metableIds);
                    }

                    if (! empty($articleParams['cntry'])) {
                        $country = '%' . str_replace('\\', '_', json_encode($articleParams['cntry'])) . '%';
                        $metableIds = $whereMeta(Article::META_COUNTRY, 'LIKE', $country);
                        $setArticleIn($metableIds);
                    }

                    if (! empty($articleParams['city'])) {
                        $city = '%' . str_replace('\\', '_', json_encode($articleParams['city'])) . '%';
                        $metableIds = $whereMeta(Article::META_CITY, 'LIKE', $city);
                        $setArticleIn($metableIds);
                    }

                    if (! empty($articleParams['ms'])) {
                        $metableIds = $whereMeta(Article::META_MEDIA_SOURCE, $articleParams['ms']);
                        $setArticleIn($metableIds);
                    }


                    if (! empty($articleParams['kw'])) {
                        $query->where('title', 'LIKE', "%{$articleParams['kw']}%");
                    }

                    if ($articleIdIn != null) {
                        $query->whereIn('id', $articleIdIn);
                    }

                    $query->orderBy('sort')
                        ->orderBy('published_at', 'DESC');

                    $articlesPaginate = $query->paginate(
                        15,
                        ['id', 'title', 'brief', 'banner', 'type', 'covers', 'published_at'],
                        'page',
                        $page
                    );

                    $result = $articlesPaginate->items();
                    $data = $articlesPaginate->toArray();

                    foreach ($result as & $item) {
                        $labels = $item->labels->toArray();
                        foreach ($labels as & $lbl) {
                            $lbl = [
                                'id'    => $lbl['id'],
                                'name'  => $lbl['name'],
                            ];
                        }

                        $item->meta;
                        $item = $item->toArray();

                        $item['page_url'] = route(
                            'frontend.articles.show',
                            ['article' => $item['id'], 'position_id' => $pos->id]
                        );

                        $metaData = [];
                        foreach ($item['meta'] as $metaKey => $meta) {
                            //Arr::set($metaData, $metaKey, $meta['value']);
                            $metaData[$metaKey] = $meta['value'];
                        }
                        $item['meta_data'] = $metaData;

                        $item['tags'] = $labels;
                        $item['cover'] = $item['banner_url'];
                        $item['published_at'] = substr($item['published_at'], 0, 10);

                        //简述最多76个字
                        $item['brief'] = mb_substr($item['brief'], 0, 76)
                            . (mb_strlen($item['brief']) > 76 ? '...' : '');

                        //去掉文章中无用的字段
                        unset($item['meta']);
                        unset($item['banner_url']);
                        unset($item['banner']);
                        unset($item['covers']);
                        unset($item['covers_url']);
                        unset($item['covers_num']);
                        unset($item['labels']);
                        unset($item['atlas']);
                    }

                    //去掉分页结构中无用的字段
                    unset($data['first_page_url']);
                    unset($data['last_page_url']);
                    unset($data['next_page_url']);
                    unset($data['prev_page_url']);
                    unset($data['path']);

                    $data['data'] = $result;
                    $respData['articles'] = $data;

                    break;

                default:
                    break;
            }
        }

        return $respData;
    }

    public function subjectPageData($id, Request $request)
    {
        $resp = [
            'status'    => 1,
            'data'      => null,
        ];

        try {
            $pos = Position::find($id);
            if (! $pos) {
                throw SubjAE::e(SubjAE::ERR_BAD_REQUEST);
            }

            $dataKeys = ['tags', 'articles'];
            $fetches = $request->get('fetch');
            if (! empty($fetches)) {
                $fetches = explode(',', trim($fetches));
                $fetchesArr = array_filter($fetches, function ($k) use(& $dataKeys) {
                    if (! in_array($k, $dataKeys)) {
                        return false;
                    }
                    return true;
                });

                $dataKeys = $fetchesArr;
            }

            switch ($pos->code) {
                case 'JLHD':
                    $resp['data'] = $this->exchangeActivityData($pos, $dataKeys);
                    break;

                default:
                    throw SubjAE::e(SubjAE::ERR_NOT_FOUND, '未知的专题页');
                    break;
            }

        } catch (\Exception $e) {
            $resp['status'] = 0;
            $resp['errno'] = $e->getCode();

            if (env('API_DEBUG') == true) {
                $resp['debug'] = $e->__toString();
            }
        }

        return $resp;
    }
}