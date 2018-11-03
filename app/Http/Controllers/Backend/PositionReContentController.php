<?php

namespace App\Http\Controllers\Backend;

use App\Models\Label;
use App\Models\Position;
use App\Models\PositionRelLabel;
use App\Http\Requests\Backend\PositionReContentRequest;
use App\Http\Controllers\Controller;

class PositionReContentController extends Controller
{
    public function content(Position $position)
    {
        return view('backend.position.content', [
            'position'    => $position,
        ]);
    }

    public function save(Position $position, PositionReContentRequest $request)
    {
        \DB::beginTransaction();
        try {
            $position = Position::find($position->id);
            $position->content_ids  = trim($request->content_ids);
            $position->save();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('admin.positions.index')->withFlashDanger('绑定内容失败'.$e->getMessage());
        }

        return redirect()->route('admin.positions.index')->withFlashSuccess('绑定内容成功');
    }
}
