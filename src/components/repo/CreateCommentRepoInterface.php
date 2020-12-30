<?php

namespace coderius\comments\components\repo;

use coderius\comments\components\entities\CommentEntity;

interface CreateCommentRepoInterface{

    public function saveComment(CommentEntity $entity);

}