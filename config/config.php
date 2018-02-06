<?php
return [
    'routes'=>[
        "/post/edit/{id}"=>"admin:edit",
        "/post/create"=>"admin:create",
        "/post/delete"=>'admin:delete',
        "/posts"=>"admin:posts",
        //-----------------------------
        "/"=>"post:index",
        "/test"=>"post:test",
        "/archive/{year}/{month}"=>"post:archive",
        "/post/{id}"=>"post:detail",
        "/admin"=>"admin:index",
        "404"=>"error:notFound",
        //----------------------
        "/login"=>"auth:login",
        "/logout"=>"auth:logout",

    ],
    "paginator"=>[
        "per_page"=>6,
        "range"=>3 //количество ссылок на соседние страницы слева и справа от текущей
    ],
    "db"=>[
        "host"=>"mysql:host=localhost;dbname=blog",
        "user"=>"root",
        "password"=>""
    ]
];