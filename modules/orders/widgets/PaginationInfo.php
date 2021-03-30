<?php

namespace app\modules\orders\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * PaginationInfo displays info about pagination pages
 */
class PaginationInfo extends Widget
{
    public $pages;

    public function init()
    {
        parent::init();
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution
     */
    public function run()
    {
        $page = $this->pages->page;
        $pageSize = $this->pages->pageSize;
        $total = $this->pages->totalCount;
        $from = $this->pages->getOffset();
        $to = (($page +1) * $pageSize) > $total ? $total : ($page +1) * $pageSize;

        $totalString = $from . ' to ' . $to . ' of ' . $total;
        return Html::encode($totalString);
    }
}
