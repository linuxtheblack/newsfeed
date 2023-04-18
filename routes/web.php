<?php

use App\Http\Resources\articleResource;
use App\NewsFetcher;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $news = new NewsFetcher();

    // use articleResource to format the data and return it as a json response
    return $news->fetch()->map(fn($article) => new articleResource($article));
});
