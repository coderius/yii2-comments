<?php 

namespace coderius\comments\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use coderius\comments\widgets\ReactAsset;
use coderius\comments\widgets\CommentsAsset;
use coderius\comments\traits\ModuleTrait;

class Comments extends Widget
{
    use ModuleTrait;

    public $commentView = 'index';

    public $materialId;

    public $commentsBlockTitle = 'Comments';

    public $commentsFormButtonTitle = 'Add Reply';

    public $commentReplyLinkTitle = 'Reply';

    private $commentService;

    public function init()
    {
        parent::init();
        
        if (null === $this->materialId) {
            throw new InvalidConfigException('`entityId` is required!');
        }

        $this->commentService = $this->getCommentService();
        
        $this->registerAssets();

    }    

    public function run()
    {
        $commentsTree = $this->commentService->getCommentsTree($this->materialId);
        // var_dump($commentsTree);
        return $this->render($this->commentView, [
            'commentsTree' => $commentsTree,
            'commentsBlockTitle' => Yii::t('coderius.comments.messages', $this->commentsBlockTitle),
            'commentsFormButtonTitle' => Yii::t('coderius.comments.messages', $this->commentsFormButtonTitle),
            'commentReplyLinkTitle' => Yii::t('coderius.comments.messages', $this->commentReplyLinkTitle),
        ]);
    }

    protected function registerAssets()
    {
        $view = $this->getView();
        CommentsAsset::register($view);
        // $view->registerJs("jQuery('#{$this->commentWrapperId}').comment({$this->getClientOptions()});");
    }
}