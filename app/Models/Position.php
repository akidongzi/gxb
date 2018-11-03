<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Traits\NewsBlock;

class Position extends Model
{
    use SoftDeletes;
    use NewsBlock;

    // 不允许集体赋值的字段
    protected $guarded = [];

    protected $dates = ['deleted_at'];

    //根据内容发布时间来排序
    const SORT_BY_PUBLISH_TIME  = 0;
    //根据内容pv来排序
    const SORT_BY_PV            = 1;
    //根据自定义sort值来排序
    const SORT_BY_CUSTOM_SORT   = 2;

    const SORT_DIRECTION_ASC    = 'ASC';
    const SORT_DIRECTION_DESC   = 'DESC';

    public static $sortTypes = [
        self::SORT_BY_PUBLISH_TIME  => [
            'name'  => '发布时间',
            'desc'  => '根据内容的发布时间来排序。',
        ],
        self::SORT_BY_PV            => [
            'name'  => '内容pv',
            'desc'  => '根据内容的PV值来排序。当值相同时，使用第二排序字段id来排序。',
        ],
        self::SORT_BY_CUSTOM_SORT   => [
            'name'  => '自定义sort值',
            'desc'  => '根据自定义的sort值来排序。当值相同时，使用第二字段id来排序。',
        ],
    ];

    public static $sortDirections = [
        self::SORT_DIRECTION_DESC   => '倒序',
        self::SORT_DIRECTION_ASC    => '正序',
    ];


    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.positions.edit', $this) . '" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>';

        return '<a href="' . route('admin.positions.edit', $this) . '"
                 class="btn btn-success dropdown-item">编辑</a> ';
    }

    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.positions.destroy', $this) . '"
                 data-method="delete"
                 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
                 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
                 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
                 class="dropdown-item">' . __('buttons.general.crud.delete') . '</a> ';
    }

    public function getLabelsButtonAttribute()
    {
        return '<a href="/admin/positions_labels/'.$this->id.'"
                 class="btn btn-success dropdown-item">绑定标签</a> '.
                 '<a href="/admin/positions_content/'.$this->id.'"
                 class="btn btn-success dropdown-item">绑定文章</a> ';
    }

    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group btn-group-sm" role="group">' 
          . $this->edit_button .
          '
		  <div class="btn-group btn-group-sm" role="group">
            <button id="userActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
            . __('buttons.general.crud.more').'</button>
            <div class="dropdown-menu" aria-labelledby="userActions">' 
            . $this->labels_button. $this->delete_button . 
            '</div>
		  </div>
		</div>';
    }

    public function parentPosition()
    {
        return $this->hasOne(Position::class, 'id', 'parent_id');
    }

    public function getNavShowCnAttribute()
    {
        return $this->nav_show === 1 ? '<span style="color: red;">展示</span>' : '不展示';
    }

    public function childPositions()
    {
        return $this->hasMany(Position::class, 'parent_id', 'id')->where('nav_show',1);
    }

    public function block()
    {
        return $this->hasOne(Block::class, 'id', 'block_id');
    }


    public function labels()
    {
        return $this->belongsToMany(
            Label::class,
            'position_rel_labels',
            'position_id', 'label_id'
        );
    }
}
