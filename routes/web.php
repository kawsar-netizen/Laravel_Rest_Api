<?php

use Illuminate\Support\Facades\Route;

use App\Person;

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

// service container binding 
app()->bind('getName',Person::class);

Route::get('/', function () {

        $name = app()->make('getName');
        $name ->setName("Sizar",35);
        echo $name->getName();
        die();

    return view('welcome');
});
