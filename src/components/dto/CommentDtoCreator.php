<?php

namespace coderius\comments\components\dto;

use coderius\comments\components\entities\CommentEntity;
use coderius\comments\components\services\CommentService;
use Yii;

class CommentDtoCreator{

    public static function fromEntities($entities = []){
        $result = [];
        foreach($entities as $entity){
            $result[] = self::fromEntity($entity);
        }
        return $result;
    }

    public static function fromEntity(CommentEntity $entity){
        $dto = new CommentDto;
        $dto->id = $entity->getId();
        $dto->materialId = $entity->getMaterialId();
        $dto->content = $entity->getContent();
        $dto->parentId = $entity->getParentId();
        $dto->level = $entity->getLevel();
        $dto->status = $entity->getStatus();
        $dto->ipStr = $entity->getIpStr();
        $dto->introducedName = $entity->getIntroducedName();
        $dto->introducedAvatar = $entity->getIntroducedAvatar();
        $dto->createdBy = $entity->getCreatedBy();
        $dto->updatedBy = $entity->getUpdatedBy();
        $dto->createdAt = Yii::$app->formatter->asRelativeTime($entity->getCreatedAt());
        $dto->updatedAt = Yii::$app->formatter->asRelativeTime($entity->getUpdatedAt());
        $dto->surrogateLikesCount = $entity->getSurrogateLikesCount();
        $dto->likes = $entity->getLikes();
        $dto->likesCount = $entity->countLikes();
        $dto->hasActiveLikeByIp = CommentService::hasActiveLikeFromIp($entity);//active like for current ip user

        return $dto;
    }

}