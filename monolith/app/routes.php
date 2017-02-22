<?php

$app->mount('/', $app['indexController']);
$app->mount('/read', $app['articleController']);
