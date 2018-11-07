<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\PositionRequest;
use App\Models\Label;
use App\Models\Position;
use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Overtrue\Pinyin\Pinyin;

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
        $pinyin = new Pinyin();
        $position = Position::create([
            'name'      => $request->name,
            'code'      => strtoupper($pinyin->abbr($request->name, PINYIN_KEEP_NUMBER)),
            'stage'     => $request->stage,
            'parent_id' => $request->parent_id,
            'nav_show'  => $request->nav_show ?? 2,
            'msort'     => $request->msort ?? 0,
            'sort'      => $request->sort ?? 0,
            'block_id'  => $request->block_id ?? 0,
        ]);

        $extData = [];
        $posTxtKeys = $request->get('pos_text_key');
        if (! empty($posTxtKeys)) {
            $posTxtKeys = array_filter($posTxtKeys);
            $posTxtValues = $request->get('pos_text_value');
            if (! empty($posTxtKeys) && count($posTxtKeys) == count($posTxtValues)) {
                $extData['txt'] = array_combine($posTxtKeys, $posTxtValues);
            }
        }

        $posImgKeys = $request->get('pos_img_key');
        if (! empty($posImgKeys)) {
            $posImgKeys = array_filter($posImgKeys);
            $posImgValues = $request->get('pos_img_value');
            if (! empty($posImgKeys) && count($posImgKeys) == count($posImgValues)) {
                $extData['img'] = array_combine($posImgKeys, $posImgValues);
            }
        }

        if (! empty($extData)) {
            $position->setMeta(Position::META_PAGE_EXT_DATA, $extData);
        }

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
        $extData = $position->getMeta(Position::META_PAGE_EXT_DATA);

        return view('backend.position.edit', [
            'position' => $position,
            'parents'  => $parents,
            'blocks'   => $blocks,
            'ext_data' => $extData,
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
        $data = [
            'name'      => $request->name,
            'stage'     => $request->stage,
            'parent_id' => $request->parent_id,
            'nav_show'  => $request->nav_show ?? 2,
            'sort'      => $request->sort ?? 0,
            'msort'     => $request->msort ?? 0,
            'block_id'  => $request->block_id ?? 0,
        ];
        if ($request->name != $position->name) {
            $pinyin = new Pinyin();
            $data['code'] = strtoupper($pinyin->abbr($request->name, PINYIN_KEEP_NUMBER));
        }

        $extData = [];
        $posTxtKeys = $request->get('pos_text_key');
        if (! empty($posTxtKeys)) {
            $posTxtKeys = array_filter($posTxtKeys);
            $posTxtValues = $request->get('pos_text_value');
            if (! empty($posTxtKeys) && count($posTxtKeys) == count($posTxtValues)) {
                $extData['txt'] = array_combine($posTxtKeys, $posTxtValues);
            }
        }

        $posImgKeys = $request->get('pos_img_key');
        if (! empty($posImgKeys)) {
            $posImgKeys = array_filter($posImgKeys);
            $posImgValues = $request->get('pos_img_value');
            if (! empty($posImgKeys) && count($posImgKeys) == count($posImgValues)) {
                $extData['img'] = array_combine($posImgKeys, $posImgValues);
            }
        }

        if (! empty($extData)) {
            $position->setMeta(Position::META_PAGE_EXT_DATA, $extData);
        }

        Position::where(['id' => $position->id])->update($data);
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
