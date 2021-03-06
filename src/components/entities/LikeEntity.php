<?php 

namespace coderius\comments\components\entities;

use coderius\comments\components\entities\values\CommentId;
use coderius\comments\components\entities\values\LikeId;

class LikeEntity{

    const ACTIVE = 1;
    const DESIBLED = 0;

    private $id;
    private $commentId;
    private $score;
    private $ipStr;
    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

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
        $array['id'] = LikeId::fromString($array['id']);
        $array['commentId'] = CommentId::fromString($array['commentId']);
        return new self($array);
    }

    public static function createNewLike($array){
        $data = [
            'id' => LikeId::next(),
            'commentId' => $array['commentId'],
            'score' => static::ACTIVE,
            'ipStr' => $array['ipStr'],
            'createdAt' => time()
        ];

        return new self($data);
    }

    public static function getIdAsString(LikeId $id)
    {
        return $id->getId();
    }

    public function getIdString()
    {
        return $this->getId()->getId();
    }

    public function isEqualIp(string $ip)
    {
        return $this->getIpStr() == $ip;
    }

    public function isActiveLike()
    {
        return $this->getScore() == static::ACTIVE;
    }
    
    public function toggleScore()
    {
        switch ($this->getScore()) {
            case LikeEntity::DESIBLED:
                $this->setScore(LikeEntity::ACTIVE);
                break;
            case LikeEntity::ACTIVE:
                $this->setScore(LikeEntity::DESIBLED);
                break;
        }
    }
    
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of commentId
     */ 
    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     * Get the value of score
     */ 
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Get the value of ipStr
     */ 
    public function getIpStr()
    {
        return $this->ipStr;
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
     * Set the value of score
     *
     * @return  self
     */ 
    public function setScore(int $score)
    {
        $this->score = $score;

        return $this;
    }

}