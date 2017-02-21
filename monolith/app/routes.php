<?php

use \App\Controllers\IndexController;
use \App\Controllers\ArticleController;

$articleService = new \App\Services\ArticleService();

$app->mount('/', new IndexController($articleService));
$app->mount('/read', new ArticleController($articleService));
