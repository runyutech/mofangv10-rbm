<?php 

use think\facade\Route;
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
// 不需要登录
Route::group('console/v1',function (){
    Route::get('rainyunrbm/product/:product_id', "\\server\\rainyunrbm\\controller\\home\\ProductController@getProductInfo");
    Route::get('rainyunrbm/product/:product_id/ip_types', "\\server\\rainyunrbm\\controller\\home\\ProductController@getIpTypeMap");
    Route::get('rainyunrbm/product/:product_id/os_templates', "\\server\\rainyunrbm\\controller\\home\\ProductController@getOsTemplates");
    Route::get('rainyunrbm/forum_topic/:topic_id', "\\server\\rainyunrbm\\controller\\home\\ProductController@getForumTopic");

})->allowCrossDomain([
    'Access-Control-Allow-Origin'        => $origin,
    'Access-Control-Allow-Credentials'   => 'true',
    'Access-Control-Max-Age'             => 600,
])->middleware(\app\http\middleware\Check::class);

// 前台需要登录
Route::group('console/v1',function (){
    Route::get('rainyunrbm/host', "\\server\\rainyunrbm\\controller\\home\\HostController@hostList");

    Route::get('rainyunrbm/host/:host_id/configoption', "\\server\\rainyunrbm\\controller\\home\\HostController@detail");

    Route::get('rainyunrbm/host/:host_id/configoption/area', "\\server\\rainyunrbm\\controller\\home\\HostController@clientAreaOutput");
    Route::post('rainyunrbm/host/:host_id/configoption/chart', "\\server\\rainyunrbm\\controller\\home\\HostController@chartData");
    Route::post('rainyunrbm/host/:host_id/provision/status', "\\server\\rainyunrbm\\controller\\home\\HostController@provisionFuncStatus");
    Route::post('rainyunrbm/host/:host_id/provision/:func', "\\server\\rainyunrbm\\controller\\home\\HostController@provisionFunc")->middleware(\app\http\middleware\CheckClientOperatePassword::class);
    Route::get('rainyunrbm/host/:host_id/upgrade', "\\server\\rainyunrbm\\controller\\home\\HostController@upgradePage");

    Route::post('rainyunrbm/host/:host_id/upgrade', "\\server\\rainyunrbm\\controller\\home\\HostController@upgrade");

    Route::get('rainyunrbm/host/:host_id/upgrade_config', "\\server\\rainyunrbm\\controller\\home\\HostController@upgradeConfigPage");

    Route::post('rainyunrbm/host/:host_id/upgrade_config', "\\server\\rainyunrbm\\controller\\home\\HostController@upgradeConfig");

    Route::get('rainyunrbm/host/:host_id/renew', "\\server\\rainyunrbm\\controller\\home\\HostController@renewPage");

    // NAT转发管理
    Route::get('rainyunrbm/host/:host_id/nat', "\\server\\rainyunrbm\\controller\\home\\HostController@natList");
    Route::post('rainyunrbm/host/:host_id/nat', "\\server\\rainyunrbm\\controller\\home\\HostController@natAdd");
    Route::delete('rainyunrbm/host/:host_id/nat/:nat_id', "\\server\\rainyunrbm\\controller\\home\\HostController@natDel");
})->allowCrossDomain([
    'Access-Control-Allow-Origin'        => $origin,
    'Access-Control-Allow-Credentials'   => 'true',
    'Access-Control-Max-Age'             => 600,
])->middleware(\app\http\middleware\CheckHome::class)
    ->middleware(\app\http\middleware\ParamFilter::class)
    ->middleware(\app\http\middleware\RejectRepeatRequest::class);

Route::group('console/v1',function (){
    Route::post('rainyunrbm/host/:host_id/sync_upgrade_price', "\\server\\rainyunrbm\\controller\\home\\HostController@syncUpgradePrice");
    Route::post('rainyunrbm/host/:host_id/sync_upgrade_config_price', "\\server\\rainyunrbm\\controller\\home\\HostController@syncUpgradeConfigPrice");
})->allowCrossDomain([
    'Access-Control-Allow-Origin'        => $origin,
    'Access-Control-Allow-Credentials'   => 'true',
    'Access-Control-Max-Age'             => 600,
])->middleware(\app\http\middleware\CheckHome::class)
    ->middleware(\app\http\middleware\ParamFilter::class);

Route::group(DIR_ADMIN . '/v1',function (){
    Route::get('rainyunrbm/product_config/:product_id', "\\server\\rainyunrbm\\controller\\admin\\ProductConfigController@getConfig");

    // 保存产品配置
    Route::post('rainyunrbm/product_config', "\\server\\rainyunrbm\\controller\\admin\\ProductConfigController@saveConfig");
})->allowCrossDomain([
    'Access-Control-Allow-Origin'        => $origin,
    'Access-Control-Allow-Credentials'   => 'true',
    'Access-Control-Max-Age'             => 600,
])
    ->middleware(\app\http\middleware\CheckAdmin::class)
    ->middleware(\app\http\middleware\ParamFilter::class);