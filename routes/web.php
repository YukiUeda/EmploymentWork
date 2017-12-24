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

Auth::routes();

/*
|--------------------------------------------------------------------------
| Teacher 認証不要
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'teacher'], function() {
    Route::get ('login',    'teacher\LoginController@showLoginForm')->name('teacher.login');
    Route::post('login',    'teacher\LoginController@login');
    Route::get ('create',   'teacher\TeacherCreateController@index');
    Route::post('create',   'teacher\TeacherCreateController@create');
});

/*
|--------------------------------------------------------------------------
| Teacher ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'teacher', 'middleware' => 'auth:teacher_account'], function() {
    Route::get ('top',    'teacher\HomeController@index');
});

/*
|--------------------------------------------------------------------------
| school 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'school'], function() {
    Route::get('/',         function () { return redirect('/school/login'); });
    Route::get('login',     'school\LoginController@showLoginForm')->name('school.login');
    Route::post('login',    'school\LoginController@login');
    Route::get('create', 'school\SchoolCreateController@index');
    Route::post('create', 'school\SchoolCreateController@create');
});

/*
|--------------------------------------------------------------------------
| school ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => '/school', 'middleware' => 'auth:school'], function() {
    //TOP画面
    Route::get('top', 'school\IndexController@index');
    Route::post('top', 'school\IndexController@index');
    //教職員のアカウント作成時のコード
    Route::get("create/code", 'school\SchoolCreateController@createCode');
    //ログアウト
    Route::get('logout',   'school\LoginController@logout')->name('school.logout');
    Route::post('logout',   'school\LoginController@logout')->name('school.logout');
    //学校の各時限ごとの時間設定
    Route::get('classworkTimer', 'school\TimeCreateController@index');
    Route::post('classworkTimer', 'school\TimeCreateController@create');
    //クラスの設定
    Route::get('class/grade', 'school\ClassController@index');
    Route::post('class/setting', 'school\ClassController@grade');
    //クラスの設定
    Route::get('class/setting','school\ClassController@getSetting');
    Route::post('class/check', 'school\ClassController@postSetting');
    //目標設定 学年 科目選択
    Route::get('objective/choice','school\ObjectiveController@index');
    Route::post('objective/choice','school\ObjectiveController@index');
    Route::post('objective/setting','school\ObjectiveController@choice');
    //autocompleat,ajax用
    Route::post('objective/ajax','school\ObjectiveController@ajax');
    //目標設定
    Route::get('objective/setting','school\ObjectiveController@getSetting');
    Route::get('objective/check','school\ObjectiveController@postetting');
    Route::post('objective/check','school\ObjectiveController@postetting');

});


/*
|--------------------------------------------------------------------------
| company 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'company'], function() {
    Route::get('create', 'company\CreateController@index');
    Route::post('create', 'company\CreateController@create');
    Route::get('login',     'company\LoginController@showLoginForm')->name('company.login');
    Route::post('login',    'company\LoginController@login');
});

/*
|--------------------------------------------------------------------------
| company ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'company', 'middleware' => 'auth:company_account'], function() {
    Route::get('top', 'company\HomeController@index');
    Route::get('productCreate','company\ProductController@index');
    Route::post('productCreate','company\ProductController@productCreate');
    Route::get('logout',   'company\LoginController@logout')->name('company.logout');
    Route::post('logout',   'company\LoginController@logout')->name('company.logout');
});


/*
|--------------------------------------------------------------------------
| programmer 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'programmer'], function() {
    Route::get('create','programmer\ProgrammerCreateController@index');
    Route::post('create', 'programmer\ProgrammerCreateController@create');
    Route::get('login',     'programmer\LoginController@showLoginForm')->name('programmer.login');
    Route::post('login',    'programmer\LoginController@login');
});

/*
|--------------------------------------------------------------------------
| programmer ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'programmer', 'middleware' => 'auth:programmer_account'], function() {
    Route::get('top','programmer\HomeController@index');
    Route::get('product','programmer\ProductController@curriculum');
    Route::post('product/ajax','programmer\ProductController@list');
    Route::get('product/ajax','programmer\ProductController@list');
    Route::get('logout',   'programmer\LoginController@logout')->name('programmer.logout');
    Route::post('logout',   'programmer\LoginController@logout')->name('programmer.logout');
});