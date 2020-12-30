<?php

namespace coderius\comments\components\repo;

use \yii\db\Query;
use coderius\comments\components\entities\CommentEntity;
use Yii;

class CreateCommentRepoDAO implements CreateCommentRepoInterface{

    private $tableName = 'comments';

    public function saveComment(CommentEntity $entity){
        $sql = Yii::$app->db->createCommand()->insert($this->tableName, [
            'id' => $entity->getId(),
            'materialId' => $entity->getMaterialId(),
            'content' => $entity->getContent(),
            'parentId' => $entity->getParentId(),
            'level' => $entity->getLevel(),
            'status' => $entity->getStatus(),
            'ipStr' => $entity->getIpStr(),
            'introducedName' => $entity->getIntroducedName(),
            'introducedAvatar' => $entity->getIntroducedAvatar(),
            'createdBy' => $entity->getCreatedBy(),
            'updatedBy' => $entity->getUpdatedBy(),
            'createdAt' => $entity->getCreatedAt(),
            'updatedAt' => $entity->getUpdatedAt(),

        ])->execute();

        return $sql > 0;
    }

}