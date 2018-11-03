<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\PositionRequest;
use App\Models\Label;
use App\Models\Position;
use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $where = [];
        if (!empty($request->parent_id)) {
            $where['parent_id'] = $request->parent_id;
        }
        if (!empty($request->stage)) {
            $where['stage'] = $request->stage;
        }
        $query = Position::where($where);

        if (!empty($request->name)) {
            $query = $query->where('name', 'like', '%' . $request->name . '%');
        }

        $result = $query
            ->with('parentPosition')
            ->orderBy('stage', 'ASC')
            ->orderBy('sort', 'ASC')
            ->orderBy('id', 'DESC')
            ->paginate(15)
            ->appends($request->all());

        return view('backend.position.index', ['positions' => $result]);
    }

    /**
     * 说明: 创建位置视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function create()
    {
        $positions = Position::where(['stage' => 1])->get();
        $blocks  = Block::get();

        return view('backend.position.create', ['positions' => $positions, 'blocks'=>$blocks]);
    }

    /**
     * 说明: 添加位置
     *
     * @param PositionRequest $request
     * @return mixed
     * @author 郭庆
     */
    public function store(PositionRequest $request)
    {
        Position::create([
            'name'      => $request->name,
            'code'      => $request->code ?? '',
            'stage'     => $request->stage,
            'parent_id' => $request->parent_id,
            'nav_show'  => $request->nav_show ?? 2,
            'msort'     => $request->msort ?? 0,
            'sort'      => $request->sort ?? 0,
            'block_id'  => $request->block_id ?? 0,
        ]);

        return redirect()->route('admin.positions.index')->withFlashSuccess('创建位置成功');
    }

    /**
     * 说明: 修改视图
     *
     * @param Position $position
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function edit(Position $position)
    {
        $parents = Position::where(['stage' => 1])->get();
        $blocks  = Block::get();

        return view('backend.position.edit', [
            'position' => $position,
            'parents'  => $parents,
            'blocks'   => $blocks,
        ]);
    }

    /**
     * 说明: 修改位置
     *
     * @param Position $position
     * @param PositionRequest $request
     * @return mixed
     * @author 郭庆
     */
    public function update(Position $position, PositionRequest $request)
    {
        Position::where(['id' => $position->id])->update([
            'name'      => $request->name,
            'stage'     => $request->stage,
            'code'      => $request->code ?? '',
            'parent_id' => $request->parent_id,
            'nav_show'  => $request->nav_show ?? 2,
            'sort'      => $request->sort ?? 0,
            'msort'     => $request->msort ?? 0,
            'block_id'  => $request->block_id ?? 0,
        ]);

        return redirect()->route('admin.positions.index')->withFlashSuccess('修改位置成功');
    }

    /**
     * 说明: 删除位置
     *
     * @param Position $position
     * @return mixed
     * @author 郭庆
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()->route('admin.positions.index')->withFlashSuccess('删除位置成功');
    }
}
