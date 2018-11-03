<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Aliyun\OssClientService;
use Plank\Metable\Metable;

class Article extends Model
{
    use SoftDeletes, Metable;

    const META_AUTHOR               = 'author.name';
    const META_AUTHOR_BRIEF         = 'author.brief';
    const META_COUNTRY              = 'country.name';
    const META_CITY                 = 'city.name';
    const META_ACTIVITY_START_TIME  = 'activity.start_time';
    const META_ACTIVITY_END_TIME    = 'activity.end_time';
    const META_ACTIVITY_BRAND       = 'activity.brand';
    const META_SUBACTIVITY          = 'activity.subactivity';
    const META_MEDIA_SOURCE         = 'media.source';
    const META_UNIVERSITY           = 'university.name';

    public static $metaKeys = [
        self::META_AUTHOR,
        self::META_AUTHOR_BRIEF,
        self::META_COUNTRY,
        self::META_CITY,
        self::META_ACTIVITY_START_TIME,
        self::META_ACTIVITY_END_TIME,
        self::META_ACTIVITY_BRAND,
        self::META_SUBACTIVITY,
        self::META_MEDIA_SOURCE,
        self::META_UNIVERSITY,
    ];

    const TYPE_ADVERT   = -1;
    const TYPE_NORMAL   = 1;
    const TYPE_ATLAS    = 2;
    const TYPE_VIDEO    = 3;

    public static $articleTypes = [
        self::TYPE_ADVERT   => '广告',
        self::TYPE_NORMAL   => '文章',
        self::TYPE_ATLAS    => '图集',
        self::TYPE_VIDEO    => '视频',
    ];

    public static $mediaSources = ['官宣', '报道', '外媒'];

    // 不允许集体赋值的字段
    protected $guarded = [];

    protected $dates = ['deleted_at', 'published_at'];

    protected $appends=['atlas', 'banner_url', 'covers_url', 'covers_num'];

    protected $casts = [
        'covers' => 'array',
    ];

    protected $fillable = ['covers'];

    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.articles.edit', $this) . '" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>';
    }

    public function getDeleteButtonAttribute()
    {
            return '<a href="' . route('admin.articles.destroy', $this) . '"
                 data-method="delete"
                 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
                 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
                 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
                 class="dropdown-item">' . __('buttons.general.crud.delete') . '</a> ';
    }


    public function getActionButtonsAttribute()
    {


        if ($this->type == 1) {
            return '
        	<div class="btn-group btn-group-sm" role="group" aria-label="User Actions">
    		  ' . $this->edit_button . '
    		
    		  <div class="btn-group btn-group-sm" role="group">
    			<button id="userActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    			  More
    			</button>
    			<div class="dropdown-menu" aria-labelledby="userActions">
    			  ' . $this->delete_button . '
    			</div>
    		  </div>
    		</div>';
        } else if ($this->type == 2) {
            return '
            <div class="btn-group btn-group-sm" role="group" aria-label="User Actions">
            <a href="' . route('admin.article_atlas.edit', $this) . '" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>
            </div><div class="btn-group btn-group-sm" role="group">
                <button id="userActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  More
                </button>
                <div class="dropdown-menu" aria-labelledby="userActions">
                  <a href="' . route('admin.article_atlas.destroy', $this) . '"
                 data-method="delete"
                 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
                 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
                 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
                 class="dropdown-item">' . __('buttons.general.crud.delete') . '</a>
                </div>
            </div><div class="btn-group btn-group-sm" role="group" aria-label="User Actions">
            <a href="' . route('admin.article_has_atlas.index', ['article_id'=>$this->id]) . '" class="btn btn-primary">设置图集</a>
            ';
        }
    }

    public function labels()
    {
        return $this->belongsToMany(
            Label::class,
            'article_rel_labels',
            'article_id', 'label_id'
        );
    }

    public function getAtlasAttribute()
    {
        return $this->belongsToMany(
            Atlas::class,
            'article_has_atlas',
            'article_id', 'atlas_id'
        )->orderBy('sort')
            ->get();
    }

    public function scopeHasCoverImage(Builder $query, $flag = true)
    {
        if ($flag) {
            return $query->whereNotNull('banner')
                ->orWhereNotNull('covers');
        }

        return $query->whereNull('banner')
            ->whereNull('covers');
    }

    /**
     * 说明: 返回轮播图拼装好的地址
     *
     * @return mixed
     * @author 郭庆
     */
    public function getBannerUrlAttribute()
    {
        if (empty($this->covers)) {
            if (empty($this->banner)) {
                return null;
            }

            return config('frontend.storage_base_url') . $this->banner;
        }
        $path = array_values($this->covers)[0];

        return app(OssClientService::class)->getFullPicUrl($path);
    }

    public function getCoversUrlAttribute()
    {
        $urls = [];
        foreach ((array)$this->covers as $path) {
            if (empty($path)) {
                continue;
            }
            $urls[] = app(OssClientService::class)->getFullPicUrl($path);
        }

        $urls = array_slice(array_filter($urls), 0, 4);
        return $urls;
    }


    public function getCoversNumAttribute() 
    {
        if ($this->type == 2) {
            return count($this->atlas);
        }

        return count($this->coversUrl);
    }


    /**
     * 更新图集类文章的封面图
     *
     * @param bool $save
     * @return $this
     */
    public function updateAtlasArticleCovers($save = true)
    {
        $atlasImages = $this->belongsToMany(
            Atlas::class,
            'article_has_atlas',
            'article_id', 'atlas_id'
        )->orderBy('sort')
            ->take(3)
            ->get()
            ->pluck('banner');

        $this->covers =  $atlasImages->toArray();
        if ($save) {
            $this->save();
        }

        return $this;
    }
}
