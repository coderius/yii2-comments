<?php

namespace coderius\comments\components\repo;

use \yii\db\Query;
use coderius\comments\components\entities\CommentEntity;

class CommentRepoQuery implements CommentRepoInterface{

    // const STATUS_ACTIVE = 1;
    // const STATUS_DESIBLED = 2;

    private $tableName = 'comments';

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