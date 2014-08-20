<?php

//Load codeme core
require('codeme_start.php');


/* Codeme PHP Framework v1.0 - Write & Develop by [Minh Tien] - Email: safeservicejt@gmail.com
 * You will create & define route here. Route will check then load controller which you create.
 *
 *
 *
 */

//Database::connect();
//
//$query = Database::query("select * from users limit 0,1");

//$row=Database::fetch_assoc($query,function($result){
//    print_r($result);
//
//});

//print_r($row);

//Route::get('', 'welcome');

Route::get('thong-tin', function () {
    echo 'fixed';
});

Route::pattern('id', '\d+');
Route::get('ac/{id}/at', 'welcome@ab');

Route::get('ac', 'welcome');

Route::pattern('all', '.*?');
Route::get('{all}', 'welcome');






?>