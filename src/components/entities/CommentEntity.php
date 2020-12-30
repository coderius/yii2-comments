<?php 

namespace coderius\comments\components\entities;

use coderius\comments\components\entities\values\CommentId;

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

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
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
}