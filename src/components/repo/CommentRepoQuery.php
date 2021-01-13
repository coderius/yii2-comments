<?php

namespace coderius\comments\components\repo;

use \yii\db\Query;
use coderius\comments\components\entities\CommentEntity;
use coderius\comments\components\entities\LikeEntity;

class CommentRepoQuery implements CommentRepoInterface{

    // const STATUS_ACTIVE = 1;
    // const STATUS_DESIBLED = 2;

    private $tableName = 'comments';
    private $likesTableName = 'comments_likes';

    public function getCommentsByMaterialId($materialId, $filter = [], $order = ['createdAt' => SORT_ASC]){
        // var_dump($filter);die;
        $rows = (new \yii\db\Query())
        ->select(['*'])
        ->from($this->tableName)
        ->where(['materialId' => $materialId]);

        if(!empty($filter)){
            foreach($filter as $key => $cond){
                $rows = $rows->andFilterWhere($cond);
            }
        }

        $rows = $rows->orderBy($order);
        
        $rows = $rows->all();

        // var_dump($rows->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);die;

        $entities = [];
        foreach($rows as $row){
            
            $entities[] = CommentEntity::createFromArray($row);
        }

        return $entities;
    }

    public function getCommentsByMaterialIdWithCountLikes($materialId, $filter = [], $order = ['createdAt' => SORT_ASC]){
        // var_dump($filter);die;
        $rows = (new \yii\db\Query())
        ->select([
            "{$this->tableName}.*",
            'sum(ls.score) as surrogateLikesCount'
        ])
        ->from($this->tableName)
        ->leftJoin("{$this->likesTableName} ls", "{$this->tableName}.id = ls.commentId")
        ->where(['materialId' => $materialId]);

        if(!empty($filter)){
            foreach($filter as $key => $cond){
                $rows = $rows->andFilterWhere($cond);
            }
        }

        $rows = $rows->orderBy($order)->groupBy(["{$this->tableName}.id"]);
        $rows = $rows->all();

        // var_dump($rows->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);die;

        $entities = [];
        foreach($rows as $row){
            
            $entities[] = CommentEntity::createFromArray($row);
        }

        return $entities;
    }

    public function getCommentsByMaterialIdWithtLikes($materialId, $filter = [], $order = ['createdAt' => SORT_ASC]){
        // var_dump($filter);die;
        $rows = (new \yii\db\Query())
        ->select([
            "{$this->tableName}.*",
            'sum(ls.score) as surrogateLikesCount'
        ])
        ->from($this->tableName)
        ->leftJoin("{$this->likesTableName} ls", "{$this->tableName}.id = ls.commentId")
        ->where(['materialId' => $materialId]);

        if(!empty($filter)){
            foreach($filter as $key => $cond){
                $rows = $rows->andFilterWhere($cond);
            }
        }

        $rows = $rows
        ->orderBy($order)->groupBy(["{$this->tableName}.id"])
        ->indexBy('id');
        $rows = $rows->all();

        // var_dump($rows->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);die;

        $commentsIds = array_keys($rows);
        $likes = (new \yii\db\Query())
            ->from($this->likesTableName)
            ->where(['commentId' => $commentsIds])
            ->all();

        $commentsEntities = [];
        $likesEntities = [];

        foreach($likes as $like){
            $likesEntities[] = LikeEntity::createFromArray($like);
        }

        foreach($rows as $id => $row){
            $com = CommentEntity::createFromArray($row);
            foreach($likesEntities as $like){
                
                if($com->isRelatedLike($like)){
                    $com->addLike($like);
                }
            }
            $commentsEntities[] = $com;
            // var_dump($com->countLikes());
        }

        return $commentsEntities;
    }

    public function findByCommentId($id){
        $row = (new \yii\db\Query())
            ->from($this->tableName)
            ->where(['id' => $id])
            ->one();

        return $row ? CommentEntity::createFromArray($row) : false;
    }

    public function countAll($filter){
        $rows = (new \yii\db\Query())
            ->from($this->tableName);

        if(!empty($filter)){
            foreach($filter as $key => $cond){
                $rows = $rows->andFilterWhere($cond);
            }
        }

        return $rows->count();
    }

}