<?php

//Load codeme core
require('codeme_start.php');


/* Codeme PHP Framework v1.0 - Write & Develop by [Minh Tien] - Email: safeservicejt@gmail.com
 * You will create & define route here. Route will check then load controller which you create.
 *
 *
 *
 */


//Route::get('', 'welcome');

Route::get('', function () {
    echo 'fixed';
});

Route::pattern('id', '\d+');
Route::get('ac/{id}/at', 'welcome@ab');

Route::get('ac', 'welcome');

Route::pattern('all', '.*?');
Route::get('{all}', 'welcome');






?>