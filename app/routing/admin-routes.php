<?php
$router=new AltoRouter;

$router->map('GET','/','App\Controllers\IndexController@show','home');

// for admin
$router->map('GET','/admin','App\Controllers\Admin\DashboardController@show','admin-panel');
$router->map('POST','/admin','App\Controllers\Admin\DashboardController@get','admin form');

//service management
$router->map('GET','/admin/service/categories','App\Controllers\Admin\ServiceCategoryController@show','service_category');
$router->map('POST','/admin/service/categories','App\Controllers\Admin\ServiceCategoryController@store','create_service_category');
$router->map('POST','/admin/service/categories/[i:id]/edit','App\Controllers\Admin\ServiceCategoryController@edit','edit_service_category');
$router->map('POST','/admin/service/categories/[i:id]/delete','App\Controllers\Admin\ServiceCategoryController@delete','delete_category');