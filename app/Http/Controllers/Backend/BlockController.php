<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\BlockRequest;
use App\Models\Label;
use App\Models\Position;
use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlockController extends Controller
{
    /**
     * 模块列表
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $where = [];
        $query = Block::where($where);
        if (!empty($request->name)) {
            $query = $query->where('name', 'like', '%' . $request->name . '%');
        }

        $result = $query
            ->orderBy('id', 'DESC')
            ->paginate(15)
            ->appends($request->all());

        return view('backend.block.index', ['blocks' => $result]);
    }

    /**
     * 创建模块视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.block.create');
    }

    /**
     * 添加模块
     *
     * @param BlockRequest $request
     * @return mixed
     */
    public function store(BlockRequest $request)
    {
        Block::create([
            'title' => $request->title,
            'tpl' => $request->tpl,
            'code' => $request->code ?? '',
            'desc' => $request->desc,
        ]);

        return redirect()->route('admin.blocks.index')->withFlashSuccess('创建模块成功');
    }

    /**
     * 修改视图
     *
     * @param Block $block
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Block $block)
    {
        return view('backend.block.edit', ['block' => $block]);
    }

    /**
     * 修改模块
     *
     * @param Block $block
     * @param BlockRequest $request
     * @return mixed
     */
    public function update(Block $block, BlockRequest $request)
    {
        Block::where(['id' => $block->id])->update([
            'title' => $request->title,
            // 'code' => $request->code,
            'tpl' => $request->tpl,
            'desc' => $request->desc,
        ]);

        return redirect()->route('admin.blocks.index')->withFlashSuccess('修改模块成功');
    }

    /**
     * 删除模块
     *
     * @param Block $block
     * @return mixed
     */
    public function destroy(Block $block)
    {
        $block->delete();

        return redirect()->route('admin.blocks.index')->withFlashSuccess('删除模块成功');
    }
}
