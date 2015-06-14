<?php

// Load 'before_system_start' plugins
System::before_system_start();

// Load sytem settings

Route::get('api', 'controlApi');

Route::get('admincp', 'controlAdmincp');

Route::get('usercp', 'controlUsercp');

Route::get('', 'controlFrontEnd');

System::after_system_start();

?>