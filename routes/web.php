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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/',function() {
    return redirect('/placeposts');
});

Auth::routes();

//Route::get('/home', 'HomeController@index');


//Route::group(['middleware' => 'auth'], function() {
//    Route::resource('placeposts','PlacepostsController');
//});
// placepostsController에 construct에 auth middleware를 걸어두었다 -> show 메서드는 제외시키기위해
// AttachmentsController도 마찬가지로 show메서드 제외 아무나 다 보기 위해서
Route::resource('placeposts','PlacepostsController');
Route::resource('attachments', 'AttachmentsController', ['only' => ['store', 'destroy']]);
Route::get('server-images/{id}', ['as' => 'server-images', 'uses' => 'AttachmentsController@getServerImages']);

Route::get('getUserPlace', [
    'as'=>'getUserPlace',
    'uses' => 'PlacepostsController@getUserPlace'
]);

//Route::get('test', function () {
//    $placeloaction = App\Placepost::select('lat','lng', 'title')->where('user_id', '1')->get();
//    foreach ($placeloaction as $item) {
//        $item->title = '<div>'.$item->title.'</div>';
//    }
//
//    return response()->json([
//        'positions' => $placeloaction
//    ]);
//});

Route::get('test', function() {
    $placepost = App\Placepost::find(50)->attachments()->first()->url;
    return response()->json([
        'a' => $placepost
    ]);
});