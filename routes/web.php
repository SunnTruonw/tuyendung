<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
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

Route::get('test', function () {
    // $a = bcrypt('1234567890');
    // echo $a;
    $data=App\Models\District::find(1)->communes()->get();
    $countView=new \App\Helper\CountView();
    $model=new \App\Models\Product();
    $countView->countView($model,'view','product',5);
});

Route::group(
    [
        'prefix' => 'laravel-filemanager'
         ,'middleware' => ['web', 'auth:admin']
    ],
    function () {
        UniSharp\LaravelFilemanager\Lfm::routes();
    }
);
Route::group(['prefix' => 'ajax','namespace'=>'Ajax'], function () {
    Route::group(['prefix' => 'address'], function () {
        Route::get('district', 'AddressController@getDistricts')->name('ajax.address.districts');
        Route::get('communes', 'AddressController@getCommunes')->name('ajax.address.communes');
    });
});

Route::group(['prefix' => 'cart'], function () {
    Route::get('list', 'ShoppingCartController@list')->name('cart.list');
    Route::get('add/{id}', 'ShoppingCartController@add')->name('cart.add');
    Route::get('buy/{id}', 'ShoppingCartController@buy')->name('cart.buy');
    Route::get('remove/{id}', 'ShoppingCartController@remove')->name('cart.remove');
    Route::get('update/{id}', 'ShoppingCartController@update')->name('cart.update');
    Route::get('clear', 'ShoppingCartController@clear')->name('cart.clear');
    Route::post('order', 'ShoppingCartController@postOrder')->name('cart.order.submit');
    Route::get('order/sucess/{id}', 'ShoppingCartController@getOrderSuccess')->name('cart.order.sucess');
});
Auth::routes();

Route::get('/', 'HomeController@index')->name('home.index');

// giới thiệu
Route::group(['prefix' => 'about-us'], function () {
    Route::get('/', 'HomeController@aboutUs')->name('about-us');
});

Route::group(['prefix' => 'product'], function () {
    Route::get('/', 'ProductController@index')->name('product.index');
    Route::get('{id}-{slug}', 'ProductController@detail')->name('product.detail');
    Route::get('/category-product/{id}-{slug}', 'ProductController@productByCategory')->name('product.productByCategory');
});

Route::group(['prefix' => 'profile'], function () {
    Route::get('/', 'ProfileController@index')->name('profile.index');
    Route::get('/history', 'ProfileController@history')->name('profile.history');
    Route::get('/list-rose', 'ProfileController@listRose')->name('profile.listRose');
    Route::get('/list-member', 'ProfileController@listMember')->name('profile.listMember');
    Route::get('/create-member', 'ProfileController@createMember')->name('profile.createMember');
    Route::post('/store-member', 'ProfileController@storeMember')->name('profile.storeMember');
    Route::post('/draw_point', 'ProfileController@drawPoint')->name('profile.drawPoint');

    Route::get('/edit-info', 'ProfileController@editInfo')->name('profile.editInfo');
    Route::post('/update-info/{id}', 'ProfileController@updateInfo')->name('profile.updateInfo');

  //  Route::get('{id}-{slug}', 'ProductController@detail')->name('product.detail');
  //  Route::get('/category-product/{id}-{slug}', 'ProductController@productByCategory')->name('product.productByCategory');
});

Route::group(['prefix' => 'post'], function () {
    Route::get('/', 'PostController@index')->name('post.index');
    Route::get('{id}-{slug}', 'PostController@detail')->name('post.detail');
    Route::get('/category-post/{id}-{slug}', 'PostController@postByCategory')->name('post.postByCategory');
});

Route::group(['prefix' => 'contact'], function () {
    Route::get('/', 'ContactController@index')->name('contact.index');
    Route::post('/store-ajax', 'ContactController@storeAjax')->name('contact.storeAjax');
});

Route::group(['prefix' => 'comment'], function () {
    Route::post('/{type}/{id}', 'CommentController@store')->name('comment.store');
});

Route::group(['prefix' => 'search'], function () {
    Route::get('/', 'HomeController@search')->name('home.search');
});











