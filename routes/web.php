<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;


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
    return view('welcome');
});


Auth::routes();

Route::middleware('auth')->group(function () {

    // Resourceful routes for CRUD operations
    Route::resource('student', StudentController::class);
    Route::post('delete-student', [StudentController::class,'destroy']);

    // Route for importing student data
    Route::post('student_import', [StudentController::class, 'import'])->name('student.import');

    // Route for exporting student data
    Route::get('student_export', [StudentController::class, 'get_student_data'])->name('student.export');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});












