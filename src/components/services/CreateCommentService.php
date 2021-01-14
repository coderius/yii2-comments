<?php

namespace coderius\comments\components\services;

use coderius\comments\components\dto\CreateLikeDto;
use coderius\comments\components\entities\LikeEntity;
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

    public function createLike($commentId)
    {
        $com = $this->commentReadRepo->findByCommentId($commentId);
        $curIp = UserDetectService::getUserIpString();
        if($com->hasLikeFromIp($curIp)){
            //get like, update score, save, return dto CreateLikeDto
            $like = $com->getLikeFromIp($curIp);
            $like->toggleScore();

            $this->createCommentRepo->updateLike($com, $like);
            $dto = new CreateLikeDto();
            $dto->commentId = $com->getIdString();
            $dto->likeStatus = $like->getScore();
            $dto->likesCount = $com->countActiveLikes();
            return $dto;
            
        }else{
            //create like entity, save in comment, return dto CreateLikeDto
            $like = LikeEntity::createNewLike([
                'commentId' => $com->getId(),
                'ipStr' => $curIp,
            ]);
            $com->addLike($like);
            $this->createCommentRepo->createLike($com, $like);
            
            $dto = new CreateLikeDto();
            $dto->commentId = $com->getIdString();
            $dto->likeStatus = $like->getScore();
            $dto->likesCount = $com->countActiveLikes();
            return $dto;
        }
    }
}
