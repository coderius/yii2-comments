<?php

namespace coderius\comments\components\repo;

use coderius\comments\components\entities\CommentEntity;
use coderius\comments\components\entities\LikeEntity;

interface CreateCommentRepoInterface{

    public function saveComment(CommentEntity $entity);

    public function updateLike(CommentEntity $entity, LikeEntity $like);

    public function createLike(CommentEntity $entity, LikeEntity $like);

}