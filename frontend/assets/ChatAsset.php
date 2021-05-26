<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ChatAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/chat.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
    ];
    public $depends = [
        AppAsset::class,
    ];
}
