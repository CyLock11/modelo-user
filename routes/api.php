<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/update_username', [UserController::class, 'update_username'])->name('user.update_username');
Route::post('/user/update_email', [UserController::class, 'update_email'])->name('user.update_email');
Route::post('/user/update_password', [UserController::class, 'update_password'])->name('user.update_password');
Route::get('/user/get', [UserController::class, 'get'])->name('user.get');
Route::get('/user/login', [UserController::class, 'login'])->name('user.login');
Route::delete('/user/delete', [UserController::class, 'delete'])->name('user.delete');