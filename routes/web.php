<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');

    foreach ($tables as $table){
        if($table->Tables_in_homestead != 'migrations'){
            //echo $table;
            print_r($table->Tables_in_homestead);
        }
    }
});
