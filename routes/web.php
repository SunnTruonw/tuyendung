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
//Artisan::call('storage:link');



Route::group(
    [
        'prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']
    ],
    function () {
        UniSharp\LaravelFilemanager\Lfm::routes();
    }
);
Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
    Route::group(['prefix' => 'address'], function () {
        Route::get('district', 'AddressController@getDistricts')->name('ajax.address.districts');
        Route::get('communes', 'AddressController@getCommunes')->name('ajax.address.communes');
    });
});
//, 'middleware' => ['auth']
Route::group(['prefix' => 'cart'], function () {
    Route::get('list', 'ShoppingCartController@list')->name('cart.list');
    Route::get('add/{id}', 'ShoppingCartController@add')->name('cart.add');
    Route::get('buy/{id}', 'ShoppingCartController@buy')->name('cart.buy');
    Route::get('remove/{id}', 'ShoppingCartController@remove')->name('cart.remove');
    Route::get('update/{id}', 'ShoppingCartController@update')->name('cart.update');
    Route::get('clear', 'ShoppingCartController@clear')->name('cart.clear');
    Route::get('check-login', 'ShoppingCartController@checkLogin')->name('cart.checkLogin');
    Route::post('order', 'ShoppingCartController@postOrder')->name('cart.order.submit')->middleware(['auth']);
    Route::get('order/sucess/{id}', 'ShoppingCartController@getOrderSuccess')->name('cart.order.sucess')->middleware(['auth']);
    Route::get('order/error', 'ShoppingCartController@getOrderError')->name('cart.order.error')->middleware(['auth']);
});

Auth::routes(['verify' => false]);
Route::get('login/{social}', "Auth\LoginController@loginSocial")->name("login.social");
Route::get('login/{social}/redirect', "Auth\LoginController@loginSocialRedirect")->name("login.social.redirect");

Route::group(['prefix' => 'ajax', 'namespace' => 'Auth'], function () {
    Route::get('check-login', 'LoginController@checkLoginAjax')->name('ajax.login.checkLoginAjax');
});



Route::get('register/verify/{code}', 'Auth\RegisterController@verify')->name('register.verify');

Route::get('/', 'HomeController@index')->name('home.index');

// gi&#1073;??i thi&#1073;??u
Route::group(['prefix' => 'gioi-thieu.html'], function () {
    Route::get('/', 'HomeController@aboutUs')->name('about-us');
});





Route::get('/bao-gia.html', 'HomeController@bao_gia')->name('bao-gia');
// gi&#1073;??i thi&#1073;??u

Route::get('/tuyen-dung.html', 'HomeController@tuyen_dung')->name('tuyen-dung');
Route::get('/tuyen-dung/{id}-{slug}', 'PostController@tuyendungDetail')->name('tuyendung_link');


Route::group(['prefix' => 'san-pham'], function () {
    Route::get('/', 'ProductController@index')->name('product.index');
    Route::get('/top-ban-chay', 'ProductController@topBanChay')->name('product.topBanChay');
    Route::get('{slug}.{id}.html', 'ProductController@detail')->name('product.detail'); //->middleware(['auth','checkMoneyViewProduct']);
    Route::get('detail-full/{slug}.{id}.html', 'ProductController@detailFull')->name('product.detailFull')->middleware(['auth']);
});

Route::get('danh-muc/{slug}', 'ProductController@productByCategory')->name('product.productByCategory');
Route::get('product-check-login', 'ProductController@checkLogin')->name('product.checkLogin');


Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('/', 'ProfileController@index')->name('profile.index');
    Route::get('/create-shop', 'ProfileController@createShop')->name('profile.createShop');
    Route::post('/store-shop', 'ProfileController@storeShop')->name('profile.storeShop');
    Route::get('/edit-shop', 'ProfileController@editShop')->name('profile.editShop')->middleware(['isCreateShop']);
    Route::post('/update-shop', 'ProfileController@updateShop')->name('profile.updateShop')->middleware(['isCreateShop']);
    Route::get('/history-buy', 'ProfileController@historyBuy')->name('profile.historyBuy');
    Route::get('/transaction-detail/{id}', "ProfileController@loadTransactionDetail")->name("profile.transaction.detail");

    Route::get('/edit-info', 'ProfileController@editInfo')->name('profile.editInfo');
    Route::post('/update-info', 'ProfileController@updateInfo')->name('profile.updateInfo');//->middleware('profileOwnUser');
    Route::get('/change-password', 'ProfileController@changePassword')->name('profile.changePassword');
    Route::post('/update-password', 'ProfileController@updatePassword')->name('profile.updatePassword');//->middleware('profileOwnUser');

    Route::get('/delete-image/{id}/{idImage}', "ProfileController@destroyProductImage")->name("profile.product.destroy-image")->middleware('profileOwnUser');
    Route::get('/create-product', 'ProfileController@createProduct')->name('profile.createProduct')->middleware(['checkUserActive']);
    Route::post('/store-product', 'ProfileController@storeProduct')->name('profile.storeProduct')->middleware(['checkUserActive']);

    // qu&#1073;&#1108;&#1032;n l&#1043;&#1029; gian h&#1043;?ng
    Route::get('/list-product', 'ProfileController@listProduct')->name('profile.listProduct')->middleware(['checkUserActive']);
    Route::get('/edit-product/{id}', 'ProfileController@editProduct')->name('profile.editProduct')->middleware(['productOwnUser','checkUserActive']);
    Route::post('/update-product/{id}', 'ProfileController@updateProduct')->name('profile.updateProduct')->middleware(['productOwnUser','checkUserActive']);
    Route::post('/update-to-top/{id}', 'ProfileController@updateToTop')->name('profile.updateToTop')->middleware(['checkTypeUserCreateProduct', 'productOwnUser']);
    Route::get('/destroy-product/{id}', 'ProfileController@destroyProduct')->name('profile.destroyProduct')->middleware(['productOwnUser','checkUserActive']);
    Route::get('/update-active/{id}', "ProfileController@loadActive")->name("profile.loadActiveProduct")->middleware(['isCreateShop','productOwnUser','checkUserActive']);
    Route::get('/update-hot/{id}', "ProfileController@loadHot")->name("profile.loadHotProduct")->middleware(['isCreateShop','productOwnUser','checkUserActive']);

    Route::get('/transaction', 'ProfileController@transaction')->name('profile.transaction')->middleware(['isCreateShop']);
    Route::get('/edit-status/{id}', 'ProfileController@editStatus')->name('profile.editStatus')->middleware(['isCreateShop','transactionOwnShop']);
    Route::post('/update-status/{id}', 'ProfileController@updateStatus')->name('profile.updateStatus')->middleware(['isCreateShop','transactionOwnShop']);

    // qu&#1073;&#1108;&#1032;n l&#1043;&#1029; review
    Route::get('/review', "ProfileController@listReview")->name("profile.listReview");
    Route::get('/create-review', "ProfileController@createReview")->name("profile.createReview");
    Route::post('/store-review', "ProfileController@storeReview")->name("profile.storeReview");
    Route::get('/delete-review/{id}', "ProfileController@destroyReview")->name("profile.destroyReview")->middleware(['reviewOwnUser','checkUserActive']);
    Route::get('/book-agree/{code}', "ProfileController@bookAgree")->name("profile.bookAgree")->middleware('auth');
    Route::post('/store-book-agree/{code}', "ProfileController@storeBookAgree")->name("profile.storeBookAgree");
    Route::get('/book-cancel/{code}', "ProfileController@bookCancel")->name("profile.bookCancel");
});




Route::group(['prefix' => 'profile'], function () {
    Route::get('/load-category-child', "ProfileController@loadCategoryChildProduct")->name("profile.loadCategoryChildProduct");
    Route::get('product/{username}.{id}.html', "ProfileController@infoProduct")->name("profile.infoProduct");
    Route::get('review/{username}.{id}.html', "ProfileController@infoReview")->name("profile.infoReview");


});

Route::group(['prefix' => 'tin-tuc'], function () {
    Route::get('/', 'PostController@index')->name('post.index');
    Route::get('{slug}', 'PostController@detail')->name('post.detail');
});
Route::get('danh-muc-tin-tuc/{slug}', 'PostController@postByCategory')->name('post.postByCategory');

// review
Route::group(['prefix' => 'review'], function () {
    Route::get('/', 'ReviewController@index')->name('review.index');
    Route::get('{slug}.{id}.html', 'ReviewController@detail')->name('review.detail');
});

Route::group(['prefix' => 'lien-he.html'], function () {
    Route::get('/', 'ContactController@index')->name('contact.index');
    Route::post('/store-ajax', 'ContactController@storeAjax')->name('contact.storeAjax');
});

// Route::group(['prefix' => 'comment'], function () {
//     Route::post('/{type}/{id}', 'CommentController@store')->name('comment.store');
// });

Route::group(['prefix' => 'search'], function () {
    Route::get('/', 'HomeController@search')->name('home.search');
});


// comment
Route::group(['prefix' => 'review-comment'], function () {
    Route::get('/{slug}/{id}', 'ReviewCommentController@store')->name('review.comment.store');
});
// product comment
Route::group(['prefix' => 'product-comment'], function () {
    Route::get('/{slug}/{id}', 'ProductCommentController@store')->name('product.comment.store');
});
