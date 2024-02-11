<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';


$openapi = \OpenApi\Generator::scan([__DIR__ . '/../../modules/v1/controllers']);
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();