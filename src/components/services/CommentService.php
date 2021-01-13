<?php 

namespace coderius\comments\components\services;

use yii\base\BaseObject;
use coderius\comments\components\repo\CommentRepoInterface;
use coderius\comments\components\repo\CommentRepoQuery;
use coderius\comments\components\dto\CommentDto;
use coderius\comments\components\dto\CommentDtoCreator;
use coderius\comments\components\enum\CommentEnum;
use coderius\comments\components\entities\CommentEntity;

class CommentService extends BaseObject{

    public $commentRepo;

    public function __construct(CommentRepoInterface $commentRepo, $config = [])
    {
        $this->commentRepo = $commentRepo;

        parent::__construct($config);
    }

    public function getCommentsTree($materialId, $maxLevel = null){
        $filter = [];
        $filter[] = ['status' => CommentEnum::STATUS_ACTIVE];
        
        if($maxLevel > 0){
            $filter[] = ['<=', 'level', new \yii\db\Expression($maxLevel)];
        }
        // var_dump($this->commentRepo->getCommentsByMaterialIdWithtLikes($materialId, $filter));
        $entities = $this->commentRepo->getCommentsByMaterialIdWithtLikes($materialId, $filter);
        
        if (empty($entities)) {
            return null;
        }
        $dto = CommentDtoCreator::fromEntities($entities);
        // var_dump($dto);
        $tree = static::buildTree($dto);
        // var_dump($tree);
        return $tree;
    }

    protected static function buildTree(&$data, $rootID = null)
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

    public function getActiveCommentsCountForMaterial($materialId){
        $maxLevel = 0;
        $filter[] = ['materialId' => $materialId];
        $filter[] = ['<=', 'level', new \yii\db\Expression($maxLevel)];
        $filter[] = ['status' => CommentEnum::STATUS_ACTIVE];
        return $this->commentRepo->countAll($filter);
    }

    /**
     * Count recursive array of objacts CommentDto
     *
     * @param [type] $tree
     * @param integer $count
     * @return void
     */
    public static function getCountTree($tree, $count = 0){
        if(count($tree) == 0){
            return $count;
        }
        
        foreach ($tree as $id => $item) {
            $count ++;
            
            if(count($item->children) > 0){
                $count = self::getCountTree($item->children, $count);
                
            }
            
        }
        return $count;
    }
 
    public static function hasActiveLikeFromIp(CommentEntity $comment){
        $curIp = UserDetectService::getUserIpString();
        if($comment->countLikes() > 0){
            foreach($comment->getLikes() as $like){
                if($like->isEqualIp($curIp) && $like->isActiveLike()){
                    return true;
                }
            }
        }

        return false;

    }

}