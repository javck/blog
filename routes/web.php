<?php

use Illuminate\Support\Facades\Route;

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
    flash('Welcome Aboard!')->overlay();
    flash()->overlay('Welcome Aboard!','我的標題');
    flash('可關閉的訊息')->overlay();
    return view('welcome');
});

Route::get('/showurl',function(){
    return route('users.code',['code'=>'alert("hi")']);
    return url('/users/alert("hi")');
});

// <a href="{{ route('myindex') }}">回到首頁</a>

Route::get('/users/{code?}',function($code = 'hello'){
    return "vincent/{$code}";
})->name('users.code');



Route::group(['prefix' => 'blogs','middleware'=>[]], function() {
    Route::post('/', 'BlogController@store')->middleware('auth');
    Route::get('/', 'BlogController@index')->middleware('auth');
    Route::get('/{blog}', 'BlogController@show');
});

// Route::get('/facebook',function(){
//     $i = 8;
//     if($i > 10){
//         return redirect(url('/showurl'));
//     }else{
//         return redirect('http://google.com.tw');
//     }

// });

// Route::redirect('/', 'http://google.com.tw');

Route::get('/home','HomeController@index');
Route::resource('photos','PhotoController');
Route::resource('songs','SongController');
Route::resource('cgies','CgyController');
Route::resource('tags','TagController');





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


// Route::get('/test',function(){
//     $a = 1;
//     $b = caucul(??);
//     //echo($a == $b);
//     echo ($a === $b);

// });

Route::get('/about','HomeController@about');

Route::get('/songs/{id}',function($id){
    $song = \App\Song::findOrFail($id);
    dd($song->sell_at);
});

//Route::get('/songstore','SongController@store');
Route::get('/songupdate/{song}', 'SongController@update');
Route::get('/songdestroy/{song}','SongController@destroy');
Route::get('/addsong/{cgy_id}/{song_id}','CgyController@addSong');
Route::get('/addtag/{cgy}/{tag}','CgyController@addTag')->name('tags.add');
Route::get('/removetag/{cgy}/{tag}', 'CgyController@removeTag');
Route::get('/synctag/{cgy}', 'CgyController@syncTag');
Route::get('/showfirsttag/{cgy}', 'CgyController@showFirstTag');
Route::get('/songs/modifycgy/{song}','SongController@modifyCgy');
Route::get('/songs/modify/{song}', 'SongController@modify');
Route::get('/songs/testa/{song}','SongController@testAccessor');
Route::get('/songs/testm/{song}','SongController@testMutator');
Route::get('/songs/testc/{song}', 'SongController@testCast');
Route::get('/songs/testf/{song}', 'SongController@testFormat');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('savesession','HomeController@savesession');

Route::get('getsession','HomeController@getsession');

Route::get('pushsession', 'HomeController@pushsession');

Route::get('hassession', 'HomeController@hassession');

Route::get('delsession', 'HomeController@deletesession');

Route::get('flashsession', 'HomeController@flashsession');

// Route::get('/authuser',function(){
//     dd(Auth::id());
// });

Route::get('/authuser', 'HomeController@authuser');
Route::get('/authlogin','HomeController@authlogin');
Route::get('/authlogout', 'HomeController@authlogout');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('policy',function(){
    return view('policy');
});
