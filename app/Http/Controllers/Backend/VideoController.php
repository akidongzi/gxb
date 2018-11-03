<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\VideoRequest;
use App\Models\Label;
use App\Models\Position;
use App\Models\Video;
use App\Models\VideoRelLabel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $where = [];
        $query = Video::where($where);

        if (!empty($request->title)) {
            $query = $query->where('title', 'like', '%' . $request->title . '%');
        }

        $videos = $query
            ->orderBy('created_at', 'desc')
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->appends($request->all());

        return view('backend.video.index', ['videos' => $videos]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $labels = Label::get();
        return view('backend.video.create', ['labels' => $labels]);
    }

    /**
     * @param Request $request
     * @param $inputName
     * @param bool $isUpdate
     * @return array
     * @throws \Exception
     */
    protected function uploadVideo(Request $request, $inputName, $isUpdate = false)
    {
        if (! $request->hasFile($inputName)) {
            if ($isUpdate) {
                return null;
            }

            throw new \Exception('请上传视频');
        }

        $r = substr(md5(mt_rand(0, 0xffff) . microtime()), 0, 2);
        $path = $request
            ->file('video')
            ->store('public/videos/' . $r);

        return [
            'path' => Storage::url($path),
            'size' => Storage::size($path),
        ];
    }


    /**
     * @param VideoRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function store(VideoRequest $request)
    {
        \DB::beginTransaction();
        try {
            $uploaded = $this->uploadVideo($request, 'video');

            $video = Video::create([
                'title'     => $request->title,
                'source'    => $request->source,
                'poster'    => $request->poster,
                'file'      => $uploaded['path'],
                'size'      => $uploaded['size'],
                'editor'    => $request->editor,
                'sort'      => $request->sort ?? 0,
            ]);

            foreach ($request->labels as $labelId) {
                VideoRelLabel::create([
                    'video_id' => $video->id,
                    'label_id' => $labelId,
                ]);
            }
            \DB::commit();

        } catch (\Exception $e) {
            dd($e);
            \DB::rollBack();
            return redirect()
                ->route('admin.videos.index')
                ->withFlashError('添加视频失败');
        }

        return redirect()
            ->route('admin.videos.index')
            ->withFlashSuccess('添加视频成功');
    }

    /**
     * @param Video $video
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Video $video)
    {
        $labels = Label::get();
        return view(
            'backend.video.edit',
            [
                'labels'    => $labels,
                'video'     => $video,
            ]
        );
    }

    /**
     * @param Video $video
     * @param VideoRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function update(Video $video, VideoRequest $request)
    {
        \DB::beginTransaction();
        try {
            $uploaded = $this->uploadVideo($request, 'video', true);
            $update = [
                'title' => $request->title,
                'source' => $request->source,
                'poster' => $request->poster,
                'editor' => $request->editor,
                'sort' => $request->sort ?? 0,
            ];

            if (! empty($uploaded)) {
                $update['file'] = $uploaded['path'];
                $update['size'] = $uploaded['size'];
            }

            Video::where(['id' => $video->id])
                ->update($update);

            if ($request->labels != $video->labels->pluck('id')->toArray()) {
                VideoRelLabel::where('video_id', $video->id)->delete();

                foreach ($request->labels as $labelId) {
                    VideoRelLabel::create([
                        'video_id' => $video->id,
                        'label_id' => $labelId
                    ]);
                }
            }
            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()
                ->route('admin.videos.index')
                ->withFlashError('添加视频失败');
        }

        return redirect()
            ->route('admin.videos.index')
            ->withFlashSuccess('修改视频成功');
    }

    /**
     * @param Video $video
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Video $video)
    {
        \DB::beginTransaction();
        try {
            $prefix = config('filesystems.disks.public.url');
            $filePath = str_replace($prefix . '/', '', $video->file);

            Storage::delete($filePath);

            $video->delete();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()
                ->route('admin.videos.index')
                ->withFlashError('删除视频失败');
        }

        return redirect()
            ->route('admin.videos.index')
            ->withFlashSuccess('删除视频成功');
    }

    public function apiListVideos(Request $request)
    {
        $resp = [
            'StatusCode' => 200,
            'ResultData' => null
        ];

        try {
            $where = [];
            $keys = [];

            $query = Video::where($where);

            if (!empty($request->position_id) && !empty($position = Position::find($request->position_id))) {
                $lableIds = $position->labels->pluck('id')->unique()->toArray();
                $videoIds = VideoRelLabel::whereIn('label_id', $lableIds)
                    ->pluck('video_id')
                    ->toArray();
                $videoIds = array_keys(array_count_values($videoIds), count($lableIds));

                $query = $query->whereIn('id', $videoIds);
                $keys[] = $position->name;
            }

            if (!empty($request->title)) {
                $query = $query->where('title', 'like', '%' . $request->title . '%');
            }

            $resp['ResultData'] = $query
                ->orderBy('sort', 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->paginate(10);

        } catch (\Exception $e) {
            $resp['StatusCode'] = 500;
            $resp['ErrorMessage'] = $e->getMessage();
        }

        return $resp;
    }
}
