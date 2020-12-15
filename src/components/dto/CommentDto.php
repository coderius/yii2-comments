<?php

namespace coderius\comments\components\dto;

class CommentDto{
    public $id;
    public $materialId;
    public $content;
    public $parentId;
    public $level;
    public $status;
    public $ipStr;
    public $introducedName;
    public $introducedAvatar;
    public $createdBy;
    public $updatedBy;
    public $createdAt;
    public $updatedAt;
    public $children = [];
}