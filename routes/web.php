<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CourseController;
// routes/web.php
use App\Http\Controllers\BaserowCrudController;

Route::middleware(['auth'])->group(function () {
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::get('/lessons/{id}', [CourseController::class, 'lesson']);
    Route::post('/tasks/{id}/complete', [CourseController::class, 'completeTask']);
});

Route::post('lessons/{lesson}/complete', [App\Http\Controllers\LessonController::class, 'completeLesson'])->name('lessons.complete');
Route::post('quizzes/{quiz}/submit', [App\Http\Controllers\QuizController::class, 'submit'])->name('quizzes.submit');

Route::post('/courses/{id}/pay', [\App\Http\Controllers\PaymentController::class, 'submit'])->name('courses.pay');


// Route::get('/explore', [CourseController::class, 'explore'])->name('welcome');
Route::get('/', [CourseController::class, 'explore'])->name('explore');

// Route::get('/explore', function () {
//     return view('explore');
// });

Route::get('/', [CourseController::class, 'explore'])->name('explore');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', [CourseController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




Route::prefix('crud/{table}')
    ->middleware('auth')
    ->group(function() {
        Route::get('/',        [BaserowCrudController::class, 'index'])->name('crud.index');
        Route::get('create',   [BaserowCrudController::class, 'create'])->name('crud.create');
        Route::post('/',       [BaserowCrudController::class, 'store'])->name('crud.store');
        Route::get('{id}',     [BaserowCrudController::class, 'show'])->name('crud.show');
        Route::get('{id}/edit',[BaserowCrudController::class, 'edit'])->name('crud.edit');
        Route::patch('{id}',   [BaserowCrudController::class, 'update'])->name('crud.update');
        Route::delete('{id}',  [BaserowCrudController::class, 'destroy'])->name('crud.destroy');
});
