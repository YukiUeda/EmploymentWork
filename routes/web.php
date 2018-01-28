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
    //先生ログイン画面
    Route::get ('login',    'teacher\LoginController@showLoginForm')->name('teacher.login');
    Route::post('login',    'teacher\LoginController@login');
    //先生アカウント作成画面
    Route::get ('create',   'teacher\TeacherCreateController@index');
    Route::post('create',   'teacher\TeacherCreateController@create');
});

/*
|--------------------------------------------------------------------------
| Teacher ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'teacher', 'middleware' => 'auth:teacher_account'], function() {
    //ログアウト
    Route::get('logout',   'teacher\LoginController@logout')->name('teacher.logout');
    Route::post('logout',   'teacher\LoginController@logout')->name('teacher.logout');
    //TOPページ
    Route::get ('top',    'teacher\HomeController@index');
    //TOPページのカレンダー情報の取得
    Route::get('/calender','teacher\HomeController@calender');
    Route::post('/calender','teacher\HomeController@calender');
    //カリキュラム一覧
    Route::get ('curriculum','teacher\CurriculumController@index');
    //カリキュラム詳細画面
    Route::get('/curriculum/{id}','teacher\CurriculumController@detail');
    //カリキュラム追加画面
    Route::get('/curriculum/{id}/add','teacher\CurriculumController@getAdd');
    //カリキュラム追加処理
    Route::post('/curriculum/{id}/add','teacher\CurriculumController@postAdd');
    //商品のページ表示
    Route::get('/click/{id}','teacher\CurriculumController@productClick');
});

/*
|--------------------------------------------------------------------------
| school 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'school'], function() {
    //loginにリダイレクト
    Route::get('/',         function () { return redirect('/school/login'); });
    //ログイン画面
    Route::get('login',     'school\LoginController@showLoginForm')->name('school.login');
    //ログイン処理
    Route::post('login',    'school\LoginController@login');
    //学校アカウント作成
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
    //クラスの時間割設定
    Route::get('class/weekday','school\WeekdayScheduleController@index');
    Route::get('class/weekday/setting','school\WeekdayScheduleController@getSetting');
    Route::post('class/weekday/setting','school\WeekdayScheduleController@postSetting');
    //時間割設定
    Route::get('class/weekday/setting/ajax','school\WeekdayScheduleController@weekdaySetting');
    Route::post('class/weekday/setting/ajax','school\WeekdayScheduleController@weekdaySetting');
    Route::post('class/weekday/save','school\WeekdayScheduleController@postSave');
});


/*
|--------------------------------------------------------------------------
| company 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'company'], function() {
    //会社アカウント作成
    Route::get('create', 'company\CreateController@index');
    Route::post('create', 'company\CreateController@create');
    //ログイン画面
    Route::get('login',     'company\LoginController@showLoginForm')->name('company.login');
    Route::post('login',    'company\LoginController@login');
});

/*
|--------------------------------------------------------------------------
| company ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'company', 'middleware' => 'auth:company_account'], function() {
    //TOP画面
    Route::get('top', 'company\HomeController@index');
    //商品追加
    Route::get('product/create','company\ProductController@index');
    Route::post('product/create','company\ProductController@productCreate');
    //プラグイン商品追加
    Route::get('product/plugin/create','company\ProductController@pluginIndex');
    Route::post('product/plugin/create','company\ProductController@productPluginCreate');
    //商品一覧
    Route::get('product','company\ProductController@product');
    Route::post('product','company\ProductController@product');
    //chartデータ取得
    Route::post('product/chart','company\ProductController@chart');
    //ログアウト
    Route::get('logout',   'company\LoginController@logout')->name('company.logout');
    Route::post('logout',   'company\LoginController@logout')->name('company.logout');
});


/*
|--------------------------------------------------------------------------
| programmer 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'programmer'], function() {
    //プログラマーアカウント作成
    Route::get( 'create',   'programmer\ProgrammerCreateController@index');
    Route::post('create',   'programmer\ProgrammerCreateController@create');
    //ログイン
    Route::get( 'login',    'programmer\LoginController@showLoginForm')->name('programmer.login');
    Route::post('login',    'programmer\LoginController@login');
});

/*
|--------------------------------------------------------------------------
| programmer ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'programmer', 'middleware' => 'auth:programmer_account'], function() {
    //TOP画面
    Route::get( 'top',         'programmer\HomeController@index');
    //商品一覧ページ
    Route::get( 'product',     'programmer\ProductController@curriculum');
    Route::post('product',     'programmer\ProductController@curriculum');
    //カリキュラム設定ページ
    Route::get( 'product/{id}','programmer\ProductController@curriculumSetting');
    Route::post('product/{id}','programmer\ProductController@curriculumSetting');
    //カリキュラム設定
    Route::post('product/{id}/create','programmer\ProductController@curriculumCreate');
    //目標のオートコンプリート
    Route::post('autoComplete','programmer\ProductController@autoComplete');
    Route::get( 'autoComplete','programmer\ProductController@autoComplete');
    //TOPのチャートようajax
    Route::post('chart/ajax',         'programmer\HomeController@ajax');
    //ログアウトページ
    Route::get( 'logout',      'programmer\LoginController@logout')->name('programmer.logout');
    Route::post('logout',      'programmer\LoginController@logout')->name('programmer.logout');
});