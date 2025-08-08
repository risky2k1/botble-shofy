<?php

return [
    [
        'name' => 'Page builders',
        'flag' => 'page-builder.index',
    ],
    [
        'name' => 'Builder',
        'flag' => 'page-builder.builder',
        'parent_flag' => 'page-builder.index',
    ],
    [
        'name' => 'Save builder',
        'flag' => 'page-builder.save',
        'parent_flag' => 'page-builder.index',
    ],
];
