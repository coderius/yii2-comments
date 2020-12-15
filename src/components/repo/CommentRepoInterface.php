<?php

namespace coderius\comments\components\repo;

interface CommentRepoInterface{

    public function getCommentsByMaterialId($materialId, $filter = []);

}