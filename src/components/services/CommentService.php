<?php 

namespace coderius\comments\components\services;

use yii\base\BaseObject;
use coderius\comments\components\repo\CommentRepoInterface;
use coderius\comments\components\repo\CommentRepoQuery;
use coderius\comments\components\dto\CommentDto;
use coderius\comments\components\dto\CommentDtoCreator;


class CommentService extends BaseObject{

    public $commentRepo;

    public function __construct(CommentRepoInterface $commentRepo, $config = [])
    {
        $this->commentRepo = $commentRepo;

        parent::__construct($config);
    }

    public function getCommentsTree($materialId, $maxLevel = null){
        $filter = [];
        $filter[] = ['status' => CommentRepoQuery::STATUS_ACTIVE];
        // var_dump($maxLevel);
        if($maxLevel > 0){
            $filter[] = ['<=', 'level', new \yii\db\Expression($maxLevel)];
        }
        // var_dump($filter);
        $entities = $this->commentRepo->getCommentsByMaterialId($materialId, $filter);
        
        if (empty($entities)) {
            return null;
        }
        $dto = CommentDtoCreator::fromEntities($entities);
        $tree = static::buildTree($dto);
        
        return $tree;
    }

    protected static function buildTree(&$data, $rootID = 0)
    {
        $tree = [];

        foreach ($data as $id => $node) {
            if ($node->parentId == $rootID) {
                unset($data[$id]);
                $node->children = self::buildTree($data, $node->id);
                $tree[] = $node;
            }
        }

        return $tree;
    }

    // public function getCommentsBlockMeta(){

    // }

    // public function getCommentsFormMeta(){

    // }

}