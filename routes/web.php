<?php

use App\Http\Controllers\PostController;
use App\Models\Post;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
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
    return view('welcome');
});
Route::resource('posts', PostController::class);

Route::get('/sitemap', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/home'))
        ->add(Url::create('/about'))
        ->add(Url::create('/contact'));
    Post::all()->each(function (Post $post) use ($sitemap) {
        $sitemap->add(Url::create("/posts/{$post->slug}"));
    });
    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap create successfully';
});
