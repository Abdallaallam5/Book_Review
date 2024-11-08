<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/detail/{id}',[HomeController::class,'detail'])->name('detail');
Route::post('/savereview',[HomeController::class,'savereview'])->name('savereview');



Route::group(['prefix'=>'account'],function(){
    Route::group(['middleware'=>'guest'],function(){
        Route::get('register',[AccountController::class,'register'])->name('register');
        Route::Post('register',[AccountController::class,'proccessregister'])->name('do_register');
        Route::get('login',[AccountController::class,'login'])->name('login');
        Route::Post('login',[AccountController::class,'proccesslogin'])->name('proccesslogin');

    });
    Route::group(['middleware'=>'auth'],function(){
        Route::get('/profile',[AccountController::class,'profile'])->name('profile');
        Route::get('/logout',[AccountController::class,'logout'])->name('logout');
        Route::post('/profile',[AccountController::class,'updateprofile'])->name('updateprofile');


        Route::group(['middleware'=>'check_admin'],function(){
            Route::get('/books',[BookController::class,'index'])->name('books');
            Route::get('/books/create',[BookController::class,'create'])->name('add.book');
            Route::post('/books/store',[BookController::class,'store'])->name('store.book');
            Route::get('/books/edit/{id}',[BookController::class,'edit'])->name('edit.book');
            Route::post('/books/edit/{id}',[BookController::class,'update'])->name('update.book');
            Route::delete('/books',[BookController::class,'destroy'])->name('delete.book');
    
    
            Route::get('/review',[ReviewController::class,'index'])->name('reviews');
            Route::get('/edit/review/{id}',[ReviewController::class,'edit'])->name('edit.reviews');
            Route::post('edit/review/{id}',[ReviewController::class,'updatereview'])->name('update.reviews');
            Route::post('deleted/review',[ReviewController::class,'destroy'])->name('deleted.review');
    
    
            Route::get('show/review',[ReviewController::class,'myreview'])->name('my.review');
            Route::get('edit/myreview/{id}',[AccountController::class,'editreview'])->name('edit.my_review');
            Route::post('edit/myreview/{id}',[AccountController::class,'updatemyreview'])->name('update.my_review');
            Route::post('deleted/myreview',[AccountController::class,'deletereview'])->name('deleted.my.review'); 
    

        });
        
    });
});
