<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    protected $guarded = [
    ];

    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.blocks.edit', $this) . '" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>';

        return '<a href="' . route('admin.blocks.edit', $this) . '"
                 class="btn btn-success dropdown-item">编辑</a> ';
    }

    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group btn-group-sm" role="group">' 
          . $this->edit_button .
          '</div>';
    }

}
