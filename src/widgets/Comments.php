<?php 

namespace coderius\comments\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use coderius\comments\widgets\CommentsAsset;

class Comments extends Widget
{

    public $commentView = 'index';

    public function init()
    {
        parent::init();
        
        $this->registerAssets();

    }    

    public function run()
    {
        return $this->render($this->commentView, [
        
        ]);
    }

    protected function registerAssets()
    {
        $view = $this->getView();
        CommentsAsset::register($view);
        // $view->registerJs("jQuery('#{$this->commentWrapperId}').comment({$this->getClientOptions()});");
    }
}