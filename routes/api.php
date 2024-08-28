<?php

use App\Http\Controllers\V1\AuthorsController;
use App\Http\Controllers\V1\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
$router->get('/', function () use ($router) {
    if (getenv('APP_NAME') === null) {
        return $router->app->version();
    } else {
        return 'Welcome to ' . getenv('APP_NAME') . ' ' . getenv('APP_ENV');
    }
});

$router->group(['prefix' => 'v1', 'namespace' => 'V1'], function () use ($router) {

    $router->get('/authors', [AuthorsController::class, 'index']);
    $router->get('/authors/{id}', [AuthorsController::class, 'show']);
    $router->post('/authors', [AuthorsController::class, 'store']);
    $router->put('/authors', [AuthorsController::class, 'update']);
    $router->delete('/authors/{id}', [AuthorsController::class, 'delete']);
    $router->get('/authors/{id}/{flag}', [AuthorsController::class, 'show']);
    
    $router->post('/books', [BooksController::class, 'store']);
    $router->get('/books', [BooksController::class, 'index']);
    $router->get('/books/{id}', [BooksController::class, 'show']);
    $router->put('/books', [BooksController::class, 'update']);
    $router->delete('/books/{id}', [BooksController::class, 'delete']);
});
