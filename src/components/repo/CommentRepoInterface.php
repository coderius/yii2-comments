<?php

namespace coderius\comments\components\repo;

interface CommentRepoInterface{

    public function getCommentsByMaterialId($materialId, $filter = []);

    public function findByCommentId($id);

    public function countAll($filter);

    public function getCommentsByMaterialIdWithCountLikes($materialId, $filter = []);

    public function getCommentsByMaterialIdWithtLikes($materialId, $filter = []);
}