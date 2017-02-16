<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new Th\App('#thFramework', 'home', 'home');
$app->setLayout('bootstrap');
$app->render();
