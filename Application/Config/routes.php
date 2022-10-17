<?php

return [
    'user/create' => 'user/create',
    'user/add' => 'user/add',
    'user/edit' => 'user/edit',
    'user/delete' => 'user/delete',
    'user/update/([0-9]+)' => 'user/update',
//    '' => 'main/index',
    '' => 'user/index',
    'user/([a-z]+)/([0-9]+)' => 'user/update/$1/$2',
];
