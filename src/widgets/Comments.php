<?php

namespace coderius\comments\widgets;

use coderius\comments\traits\ModuleTrait;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Json;
use coderius\comments\components\services\CommentService;

class Comments extends Widget
{
    use ModuleTrait;

    
    public $defaultAvatar;

    public $commentView = 'index';

    public $materialId;

    public $commentsBlockTitle = 'Comments';

    public $commentsFormButtonTitle = 'Add Reply';

    public $commentReplyLinkTitle = 'Reply';
    public $commentsInputNameLabel = 'Your Name';
    public $commentsTextareaLabel = 'Your Comment';
    public $commentsCaptchaLabel = 'Captcha';
    public $commentsInputNamePlaceholder = 'Write your First Name';
    public $commentsTextareaPlaceholder = 'Write your comment ...';

    public $clientOptions = [];

    protected $avatarBaseUrl;
    
    protected $wrapperId;

    private $commentService;

    protected $encryptedData;

    const JS_PLUGIN = 'comments';

    public function init()
    {
        parent::init();

        if (null === $this->materialId) {
            throw new InvalidConfigException('`entityId` is required!');
        }
        $this->encryptedData = $this->getEncryptedData(['materialId' => $this->materialId]);
        $this->wrapperId = 'Comments-'.$this->getId();
        $this->commentService = $this->getCommentService();

        $this->registerAssets();
        
    }

    public function run()
    {
        $commentsTree = $this->commentService->getCommentsTree($this->materialId);
        $countComments = CommentService::getCountTree($commentsTree);
        
        return $this->render($this->commentView, [
            'commentsTree' => $commentsTree,
            'encryptedData' => $this->encryptedData,
            'commentsBlockTitle' => Yii::t('coderius.comments.messages', $this->commentsBlockTitle) . " ({$countComments})",
            'commentsFormButtonTitle' => Yii::t('coderius.comments.messages', $this->commentsFormButtonTitle),
            'commentReplyLinkTitle' => Yii::t('coderius.comments.messages', $this->commentReplyLinkTitle),
            'commentsInputNameLabel' => Yii::t('coderius.comments.messages', $this->commentsInputNameLabel),
            'commentsTextareaLabel' => Yii::t('coderius.comments.messages', $this->commentsTextareaLabel),
            'commentsCaptchaLabel' => Yii::t('coderius.comments.messages', $this->commentsCaptchaLabel),
            'commentsInputNamePlaceholder' => Yii::t('coderius.comments.messages', $this->commentsInputNamePlaceholder),
            'commentsTextareaPlaceholder' => Yii::t('coderius.comments.messages', $this->commentsTextareaPlaceholder),
            'wrapperId' => $this->wrapperId,
            'defaultAvatar' => $this->defaultAvatar,
            'avatarBaseUrl' => 'avatarBaseUrl'
        ]);
    }

    protected function registerAssets()
    {
        //Default avatar url
        $avAs = AvatarsAsset::publicate();
        $this->defaultAvatar = null === $this->defaultAvatar ? $avAs->getDefaultAvatarUrl() : $this->defaultAvatar;
        $this->avatarBaseUrl = $avAs->getRegularAvatarUrl();
        $view = $this->getView();
        CommentsAsset::register($view);
        $view->registerJs("jQuery('#{$this->wrapperId}').".self::JS_PLUGIN."({$this->getClientOptions()});");
    }

    protected function getClientOptions()
    {
        // $this->clientOptions['formSelector'] = '#' . $this->formId;

        return Json::encode($this->clientOptions);
    }
}
