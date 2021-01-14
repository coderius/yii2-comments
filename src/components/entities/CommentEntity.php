<?php 

namespace coderius\comments\components\entities;

use coderius\comments\components\entities\values\CommentId;
use coderius\comments\components\entities\values\LikeId;
// use coderius\comments\components\entities\values\AbstractId;

class CommentEntity{
    private $id;
    private $materialId;
    private $content;
    private $parentId;
    private $level;
    private $status;
    private $ipStr;
    private $introducedName;
    private $introducedAvatar;
    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;
    private $surrogateLikesCount;//from db
    private $likes = [];


    public function __construct($items = []){
        foreach($items as $key => $value){
            if (property_exists($this, $key)) {
                $setter = 'set' . ucfirst($key);
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                    
                }else{
                    $this->{$key} = $value;
                }
                
            }
        }
    }

    public static function createFromArray($array){
        $id = $array['id'];
        $array['id'] = CommentId::fromString($id);
        return new self($array);
    }

    public function isRelatedLike(LikeEntity $like){
        return $this->getId() == $like->getCommentId();
    }

    public function addLike(LikeEntity $like){
        $lId = LikeEntity::getIdAsString($like->getId());
        $this->likes[$lId] = $like;
    }

    public function getLike(LikeId $id){
        return isset($this->likes[$id->getId()]) ? $this->likes[$id->getId()] : false;
        
    }

    public function hasLikeFromIp(string $ip){
        foreach($this->likes as $like){
            if($like->isEqualIp($ip)){
                return true;
            }
        }
        return false;
    }

    public function getLikeFromIp(string $ip){
        foreach($this->likes as $like){
            if($like->isEqualIp($ip)){
                return $like;
            }
        }
        return false;
    }

    public function countLikes(){
        return count($this->getLikes());
    }

    public function getActiveLikes(){
        if($this->countLikes() > 0){
            $active = [];
            foreach($this->getLikes() as $like){
                if($like->isActiveLike()){
                    $active[] = $like;
                }
            }
            return $active;
        }
        
        return null;
    }

    public function hasActiveLikes(){
        return $this->getActiveLikes() ? true : false;
    }

    public function countActiveLikes(){
        return $this->hasActiveLikes() ? count($this->getActiveLikes()) : 0;
    }

    // public function getActiveLikesIps(){
    //     $arr = [];
    //     if(count($this->getLikes()) > 0){
    //         foreach($this->getLikes() as $like){

    //         }
    //     }
    // }
 
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    public function getIdString()
    {
        return $this->getId()->getId();
    }
    
    public static function getIdAsString(CommentId $id)
    {
        return $id->getId();
    }

    /**
     * Get the value of materialId
     */ 
    public function getMaterialId()
    {
        return $this->materialId;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the value of parentId
     */ 
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Get the value of level
     */ 
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the value of ipStr
     */ 
    public function getIpStr()
    {
        return $this->ipStr;
    }

    /**
     * Get the value of introducedName
     */ 
    public function getIntroducedName()
    {
        return $this->introducedName;
    }

    /**
     * Get the value of introducedAvatar
     */ 
    public function getIntroducedAvatar()
    {
        return $this->introducedAvatar;
    }

    /**
     * Get the value of createdBy
     */ 
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Get the value of updatedBy
     */ 
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(CommentId $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of surrogateLikesCount
     */ 
    public function getSurrogateLikesCount()
    {
        return $this->surrogateLikesCount;
    }

    /**
     * Set the value of surrogateLikesCount
     *
     * @return  self
     */ 
    public function setSurrogateLikesCount($surrogateLikesCount)
    {
        $this->surrogateLikesCount = $surrogateLikesCount ? $surrogateLikesCount : 0;

        return $this;
    }

    /**
     * Get the value of likes
     */ 
    public function getLikes()
    {
        return $this->likes;
    }
}