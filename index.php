<?php

//Load codeme core
require('codeme_start.php');


/* Codeme PHP Framework v1.0 - Write & Develop by [Minh Tien] - Email: safeservicejt@gmail.com
 * You will create & define route here. Route will check then load controller which you create.
 *
 *
 *
 */

Route::pattern('id','\d+');
Route::get('{id}','welcome@number');

Route::pattern('id','\d+');
Route::get('ac/{id}','welcome@number');


?>