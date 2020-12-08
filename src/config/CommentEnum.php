<?php

namespace coderius\comments\config;

abstract class CommentEnum
{
    const COMMENTS_TABLE = 'comments';
    const COMMENTS_CREATORS_TABLE = 'comments_creators';
    const COMMENTS_UPDATERS_TABLE = 'comments_updaters';
    const COMMENTS_GUESTS_TABLE = 'commented_guests';

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

}
