<?php

namespace coderius\comments\components\services;

use coderius\comments\components\dto\CommentDtoCreator;
use coderius\comments\components\entities\CommentEntity;
use coderius\comments\components\entities\values\CommentId;
use coderius\comments\components\enum\CommentEnum;
use coderius\comments\components\repo\CreateCommentRepoInterface;
use coderius\comments\components\repo\CommentRepoInterface;
use coderius\comments\models\CommentFormModel;
use coderius\comments\traits\ModuleTrait;
use Yii;
use yii\base\BaseObject;

class CreateCommentService extends BaseObject
{
    use ModuleTrait;

    public $createCommentRepo;
    public $commentReadRepo;

    public function __construct(
        CreateCommentRepoInterface $createCommentRepo,
        CommentRepoInterface $commentReadRepo,
        $config = []
        ) {
        $this->createCommentRepo = $createCommentRepo;
        $this->commentReadRepo = $commentReadRepo;

        parent::__construct($config);
    }

    public function createComment(CommentFormModel $formModel)
    {
        $array = [
            'id' => CommentId::next(),
            'materialId' => $this->getDecryptedData($formModel->encryptedData)['materialId'],
            'content' => $formModel->commentText,
            'parentId' => $formModel->parentId,
            'level' => 0, // add if reply
            'status' => CommentEnum::STATUS_ACTIVE,
            'ipStr' => UserDetectService::getUserIpString(),
            'introducedName' => $formModel->commentorFirstName,
            'introducedAvatar' => $formModel->introducedAvatar ?  : null,
            'createdBy' => Yii::$app->user->isGuest ? null : Yii::$app->user->id,
            'updatedBy' => null,
            'createdAt' => time(),
            'updatedAt' => null,
        ];
        $entity = new CommentEntity($array);
        $created = $this->createCommentRepo->saveComment($entity);
        if ($created) {
            $entity = $this->commentReadRepo->findByCommentId($entity->getId());
            return CommentDtoCreator::fromEntity($entity);
            
        }
        
        return false;
    }
}
