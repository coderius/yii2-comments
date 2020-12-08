<?php

return [
    'GET api/default/index' => 'default/index',
    'GET api/default/comments-tree/<entity:\w+>/<entityId:\d+>' => 'default/comments-tree',
    'GET api/default/comments-tree/<entity:\w+>/<entityId:\d+>/<pageNum:\d+>' => 'default/comments-tree',
    'GET api/default/comments-count/<entity:\w+>/<entityId:\d+>' => 'default/comments-count',

    // 'GET api/default/is-guest' => 'default/is-guest',

    'POST api/default/is-human' => 'default/is-human',

    'POST api/default/create-comment' => 'default/create-comment',
    // 'default/<action>' => 'default/<action>',
];