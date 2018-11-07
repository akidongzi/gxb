<?php

namespace App\Models\Traits;

use App\Models\Position;
use App\Models\Article;
use App\Models\ArticleRelLabel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait Block.
 */
trait NewsBlock
{
	
	/**
	 * 根据id获取内容
	 *
	 * @param  array $arrId
	 * @return Builder
	 */
	protected function _getBuildBySpecialId($arrId)
	{
		$query = Article::whereIn('id', $arrId);
		return $query;
	}

	/**
	 * 根据标签获取内容
	 *
	 * @param array $arrLableId
     * @param int   $type
	 * @return Builder
	 */
	protected function _getBuildByLables($arrLableId, $type = 1)
	{
		$arrArticleId = ArticleRelLabel::whereIn('label_id', $arrLableId)
        	->pluck('article_id')
        	->toArray();
    	$query = Article::whereIn('id', $arrArticleId);

    	if (! empty($type)) {
            $query = $query->where('type', $type);
        }

    	return $query;
	}

	public function getPageBuild($type = 1)
	{
		$arrLableId = $this->labels->pluck('id')->unique()->toArray();
		return $this->_getBuildByLables($arrLableId, $type);
	}

	/**
	 * 获取模块内容
	 *
	 * @param  String $code
	 * @return html
	 */
	public function getBlock($positionId = 0)
	{
		if ($positionId != 0) {
		}
		$block = $this->block;
		if (empty($block)) {
			return;
		}
		$query = $this->getDataBuild($this);
		$view =\View::make($block->tpl, [
			'title'     => $block->title,
			'data'      => $query->get(),
			'position'  => $this,
		]);

		return $view->render();
	}

	/**
	 * 获取对应位置数据 (指定id 优先)
	 *
	 * @param  \App\Models\Position $position
	 * @return Builder
	 */
	public function getDataBuild(Position $position)
	{
		$showNum = $position->num_show;
		if (!$showNum) {
			$showNum = 15;
		}
		$arrId = [];
		if ($position->content_ids) {
			$arrId = explode(',', $position->content_ids);
		}

		$arrLableId = $position->labels->pluck('id')->unique()->toArray();

		if ($arrId) {
			 //数量及排序按输入确定
			$query = $this->_getBuildBySpecialId($arrId);

		} else {
			$query = $this->_getBuildByLables($arrLableId);
			// 排序
			switch ($position->sort_type) {
                case Position::SORT_BY_PV:
                    $query =
                        $query
                            ->orderBy('fake_pv', $position->sort_dir)
                            ->orderBy('pv', $position->sort_dir)
                            ->orderBy('id', $position->sort_dir)
                    ;
                    break;

                case Position::SORT_BY_CUSTOM_SORT:
                    $query =
                        $query
                            ->orderBy('sort', $position->sort_dir)
                            ->orderBy('id', $position->sort_dir)
                    ;
                    break;

                case Position::SORT_BY_PUBLISH_TIME:
                    $query = $query->orderBy('published_at', $position->sort_dir);
                    break;

                default:
                    break;
            }

			// 数量
			$query = $query->take($showNum);
		}

		return $query;
	}

	/**
	 * 获取对应模块数据
	 *
	 * @return Collection
	 */
	public function getData()
	{
		$query = $this->getDataBuild($this);
		return $query->get();
	}

	/**
	 * 获取对应位置的模块
	 * 
	 * @param string $posCode
	 * @return Position
	 */
	public function getBlockByPosition($posCode)
	{
		$code  = "{$this->code}{$posCode}";
		$builder = Position::where('code', $code);
		if (!$builder->exists()) {
			$builder = Position::where('code', $posCode);
		}

		if ($builder) {
			return $builder->first();
		}
		return null;
	}
}
