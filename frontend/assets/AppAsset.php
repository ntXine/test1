<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'css/bootstrap.css',
	    '//fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext,cyrillic',
		'css/style.css',
    ];
    public $cssOptions = [
    	'type' => 'text/css',
    ];
    public $js = [
	    'js/jquery.js',
        'js/jquery-ui-1.8.23.custom.min.js',
    	'js/config_form.js',
    ];
}
