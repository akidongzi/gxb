<?php

namespace App\Http\Controllers\Backend;

use App\Models\Label;
use App\Models\Position;
use App\Models\PositionRelLabel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionRelLabelController extends Controller
{
    public function Labels(Position $position)
    {
        return view('backend.position.labels', [
            'myLabels' => $position->labels->pluck('id')->toArray(),
            'labels' => Label::get(),
            'position' => $position,
        ]);
    }

    public function saveLabels(Position $position, Request $request)
    {
        \DB::beginTransaction();
        try {

            if (!empty($request->labels)) {
                PositionRelLabel::whereIn('label_id', $position->labels->pluck('id')->toArray())
                    ->where('position_id', $position->id)
                    ->delete();

                foreach ($request->labels as $labelId) {
                    PositionRelLabel::create([
                        'position_id' => $position->id,
                        'label_id' => $labelId
                    ]);
                }
            }

            if (! isset(Position::$sortTypes[$request->sort_type])) {
                throw new \Exception('不存在的排序依据');
            }

            if (! isset(Position::$sortDirections[$request->sort_dir])) {
                throw new \Exception('不存在的排序方向');
            }

            $position = Position::find($position->id);
            $position->sort_type = intval($request->sort_type);
            $position->sort_dir = $request->sort_dir;
            $position->num_show  = intval($request->num_show);
            $position->save();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('admin.positions.index')->withFlashDanger('绑定标签失败'.$e->getMessage());
        }

        return redirect()->route('admin.positions.index')->withFlashSuccess('绑定标签成功');
    }
}
