<?php

namespace coderius\comments\components\repo;

use \yii\db\Query;
use coderius\comments\components\entities\CommentEntity;
use coderius\comments\components\entities\LikeEntity;
use Yii;

class CreateCommentRepoDAO implements CreateCommentRepoInterface{

    private $tableName = 'comments';
    private $likesTableName = 'comments_likes';

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

    public function updateLike(CommentEntity $entity, LikeEntity $like){
        $col = [
            'score' => $like->getScore(),
            'updatedAt' => time()
        ];
        $likeId = $like->getId();
        $where = "id = '{$likeId}'";

        $sql = Yii::$app->db->createCommand()->update($this->likesTableName, $col, $where)->execute();
        return $sql > 0;
    }

    public function createLike(CommentEntity $entity, LikeEntity $like){
        $col = [
            'id' => $like->getIdString(),
            'commentId' => $entity->getId(),
            'score' => $like->getScore(),
            'ipStr' => $like->getIpStr(),
            'createdAt' => time()
        ];
        
        $sql = Yii::$app->db->createCommand()->insert($this->likesTableName, $col)->execute();
        return $sql > 0;
    }

}