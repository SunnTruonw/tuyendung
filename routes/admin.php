<?php

use Illuminate\Support\Facades\Route;

Route::get('admin/login', "Auth\AdminLoginController@showLoginForm")->name("admin.login");
Route::post('admin/logout', "Auth\AdminLoginController@logout")->name("admin.logout");
Route::post('admin/login', "Auth\AdminLoginController@login")->name("admin.login.submit");

Route::get('admin/password/confirm', 'Auth\AdminConfirmPasswordController@showConfirmForm')->name('admin.password.confirm');
Route::get('admin/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {
    // Route::get('/', function () {
    //     return view("admin.master.main");
    // });

    Route::get('/', "AdminHomeController@index")->name("admin.index");

    // Route::get('login', "AdminController@getLoginAdmin")->name("admin.getLoginAdmin");
    // Route::post('login', "AdminController@postLoginAdmin")->name("admin.postLoginAdmin");

    Route::group(['prefix' => 'ajax'], function () {
    });
    Route::get('/load-order/{table}/{id}', "AdminHomeController@loadOrderVeryModel")->name("admin.loadOrderVeryModel");
    Route::group(['prefix' => 'categoryproduct'], function () {
        Route::get('/', "AdminCategoryProductController@index")->name("admin.categoryproduct.index");
        Route::get('/create', "AdminCategoryProductController@create")->name("admin.categoryproduct.create");
        Route::post('/store', "AdminCategoryProductController@store")->name("admin.categoryproduct.store");
        Route::get('/edit/{id}', "AdminCategoryProductController@edit")->name("admin.categoryproduct.edit");
        Route::post('/update/{id}', "AdminCategoryProductController@update")->name("admin.categoryproduct.update");
        Route::get('/destroy/{id}', "AdminCategoryProductController@destroy")->name("admin.categoryproduct.destroy");
        Route::post('/export/excel/database', "AdminCategoryProductController@excelExportDatabase")->name("admin.categoryproduct.export.excel.database");
        Route::post('/import/excel/database', "AdminCategoryProductController@excelImportDatabase")->name("admin.categoryproduct.import.excel.database");
    });
    Route::group(['prefix' => 'categorypost'], function () {
        Route::get('/', "AdminCategoryPostController@index")->name("admin.categorypost.index")->middleware('can:category-post-list');
        Route::get('/create', "AdminCategoryPostController@create")->name("admin.categorypost.create")->middleware('can:category-post-add');
        Route::post('/store', "AdminCategoryPostController@store")->name("admin.categorypost.store")->middleware('can:category-post-add');
        Route::get('/edit/{id}', "AdminCategoryPostController@edit")->name("admin.categorypost.edit")->middleware('can:category-post-edit');
        Route::post('/update/{id}', "AdminCategoryPostController@update")->name("admin.categorypost.update")->middleware('can:category-post-edit');
        Route::get('/destroy/{id}', "AdminCategoryPostController@destroy")->name("admin.categorypost.destroy")->middleware('can:category-post-delete');
        Route::post('/export/excel/database', "AdminCategoryPostController@excelExportDatabase")->name("admin.categorypost.export.excel.database");
        Route::post('/import/excel/database', "AdminCategoryPostController@excelImportDatabase")->name("admin.categorypost.import.excel.database");
    });
    Route::group(['prefix' => 'menu'], function () {
        Route::get('/', "AdminMenuController@index")->name("admin.menu.index")->middleware('can:menu-list');
        Route::get('/create', "AdminMenuController@create")->name("admin.menu.create")->middleware('can:menu-add');
        Route::post('/store', "AdminMenuController@store")->name("admin.menu.store")->middleware('can:menu-add');
        Route::get('/edit/{id}', "AdminMenuController@edit")->name("admin.menu.edit")->middleware('can:menu-edit');
        Route::post('/update/{id}', "AdminMenuController@update")->name("admin.menu.update")->middleware('can:menu-edit');
        Route::get('/destroy/{id}', "AdminMenuController@destroy")->name("admin.menu.destroy")->middleware('can:menu-delete');
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', "AdminProductController@index")->name("admin.product.index");
        Route::get('/create', "AdminProductController@create")->name("admin.product.create");
        Route::post('/store', "AdminProductController@store")->name("admin.product.store");
        Route::get('/edit/{id}', "AdminProductController@edit")->name("admin.product.edit");
        Route::get('/detail/{id}', "AdminProductController@detail")->name("admin.product.detail");
        Route::post('/update/{id}', "AdminProductController@update")->name("admin.product.update");
        Route::get('/destroy/{id}', "AdminProductController@destroy")->name("admin.product.destroy");
        Route::get('/update-active/{id}', "AdminProductController@loadActive")->name("admin.product.load.active");
        Route::get('/update-ban-chay/{id}', "AdminProductController@loadBanchay")->name("admin.product.load.banchay");
        Route::get('/update-hot/{id}', "AdminProductController@loadHot")->name("admin.product.load.hot");

        Route::get('load-option-product', "AdminProductController@loadOptionProduct")->name("admin.product.loadOptionProduct");
        Route::get('/delete-option-product/{id}', "AdminProductController@destroyOptionProduct")->name("admin.product.destroyOptionProduct");

        Route::get('/delete-image/{id}', "AdminProductController@destroyProductImage")->name("admin.product.destroy-image");

        Route::get('load-product-service/{id}', "AdminProductController@loadProductService")->name("admin.product.loadProductService");

        Route::post('product-service', "AdminProductController@storeProductService")->name("admin.ajax.product-service.store");

        Route::post('/export/excel/database', "AdminProductController@excelExportDatabase")->name("admin.product.export.excel.database");
        Route::post('/import/excel/database', "AdminProductController@excelImportDatabase")->name("admin.product.import.excel.database");

        Route::get('load-attributes', 'AdminProductController@loadAttributes')->name('admin.load.attributes');
    });
    Route::group(['prefix' => 'post'], function () {
        Route::get('/', "AdminPostController@index")->name("admin.post.index")->middleware('can:post-list');
        Route::get('/create', "AdminPostController@create")->name("admin.post.create")->middleware('can:post-add');
        Route::post('/store', "AdminPostController@store")->name("admin.post.store")->middleware('can:post-add');
        Route::get('/edit/{id}', "AdminPostController@edit")->name("admin.post.edit")->middleware('can:post-edit');
        Route::post('/update/{id}', "AdminPostController@update")->name("admin.post.update")->middleware('can:post-edit');
        Route::get('/destroy/{id}', "AdminPostController@destroy")->name("admin.post.destroy")->middleware('can:post-delete');
        Route::get('/update-active/{id}', "AdminPostController@loadActive")->name("admin.post.load.active")->middleware('can:post-edit');
        Route::get('/update-hot/{id}', "AdminPostController@loadHot")->name("admin.post.load.hot")->middleware('can:post-edit');


        Route::post('/export/excel/database', "AdminPostController@excelExportDatabase")->name("admin.post.export.excel.database");
        Route::post('/import/excel/database', "AdminPostController@excelImportDatabase")->name("admin.post.import.excel.database");
    });
    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', "AdminSliderController@index")->name("admin.slider.index")->middleware('can:slider-list');
        Route::get('/create', "AdminSliderController@create")->name("admin.slider.create")->middleware('can:slider-add');
        Route::post('/store', "AdminSliderController@store")->name("admin.slider.store")->middleware('can:slider-add');
        Route::get('/edit/{id}', "AdminSliderController@edit")->name("admin.slider.edit")->middleware('can:slider-edit');
        Route::post('/update/{id}', "AdminSliderController@update")->name("admin.slider.update")->middleware('can:slider-edit');
        Route::get('/destroy/{id}', "AdminSliderController@destroy")->name("admin.slider.destroy")->middleware('can:slider-delete');
        Route::get('/update-active/{id}', "AdminSliderController@loadActive")->name("admin.slider.load.active")->middleware('can:slider-edit');
    });
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', "AdminSettingController@index")->name("admin.setting.index")->middleware('can:setting-list');
        Route::get('/create', "AdminSettingController@create")->name("admin.setting.create")->middleware('can:setting-add');
        Route::post('/store', "AdminSettingController@store")->name("admin.setting.store")->middleware('can:setting-add');
        Route::get('/edit/{id}', "AdminSettingController@edit")->name("admin.setting.edit")->middleware('can:setting-edit');
        Route::post('/update/{id}', "AdminSettingController@update")->name("admin.setting.update")->middleware('can:setting-edit');
        Route::get('/destroy/{id}', "AdminSettingController@destroy")->name("admin.setting.destroy")->middleware('can:setting-delete');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', "AdminUserController@index")->name("admin.user.index")->middleware('can:admin-user-list');
        Route::get('/create', "AdminUserController@create")->name("admin.user.create")->middleware('can:admin-user-add');
        Route::post('/store', "AdminUserController@store")->name("admin.user.store")->middleware('can:admin-user-add');
        Route::get('/edit/{id}', "AdminUserController@edit")->name("admin.user.edit")->middleware('can:admin-user-edit');
        Route::post('/update/{id}', "AdminUserController@update")->name("admin.user.update")->middleware('can:admin-user-edit');
        Route::get('/destroy/{id}', "AdminUserController@destroy")->name("admin.user.destroy")->middleware('can:admin-user-delete');
    });

    Route::group(['prefix' => 'attribute'], function () {
        Route::get('/', "AdminAttributeController@index")->name("admin.attribute.index");
        Route::get('/create', "AdminAttributeController@create")->name("admin.attribute.create");
        Route::post('/store', "AdminAttributeController@store")->name("admin.attribute.store");
        Route::get('/edit/{id}', "AdminAttributeController@edit")->name("admin.attribute.edit");
        Route::post('/update/{id}', "AdminAttributeController@update")->name("admin.attribute.update");
        Route::get('/destroy/{id}', "AdminAttributeController@destroy")->name("admin.attribute.destroy");

        Route::get('load-child-attribute', "AdminAttributeController@loadChildAttribute")->name("admin.attribute.loadChildAttribute");
        Route::get('/delete-option-attribute/{id}', "AdminAttributeController@destroyOptionAttribute")->name("admin.attribute.destroyOptionAttribute");
    });

    Route::group(['prefix' => 'user-frontend'], function () {
        Route::get('/', "AdminUserFrontendController@index")->name("admin.user_frontend.index")->middleware('can:admin-user_frontend-list');
        //  Route::get('/list-no-active', "AdminUserFrontendController@listNoActive")->name("admin.user_frontend.listNoActive")->middleware('can:admin-user_frontend-list');
        Route::get('/detail/{id}', "AdminUserFrontendController@detail")->name("admin.user_frontend.detail")->middleware('can:admin-user_frontend-list');
        Route::get('/count-buy/{id}', "AdminUserFrontendController@countBuy")->name("admin.user_frontend.countBuy")->middleware('can:admin-user_frontend-list');
        Route::get('/history/{id}', "AdminUserFrontendController@history")->name("admin.user_frontend.history")->middleware('can:admin-user_frontend-list');
        Route::get('/point-list', "AdminUserFrontendController@listPoint")->name("admin.user_frontend.listPoint")->middleware('can:admin-user_frontend-list');
        Route::get('/point-list-up', "AdminUserFrontendController@listPointUp")->name("admin.user_frontend.listPointUp")->middleware('can:admin-user_frontend-list');
        Route::get('/create', "AdminUserFrontendController@create")->name("admin.user_frontend.create")->middleware('can:admin-user_frontend-add');
        Route::post('/store', "AdminUserFrontendController@store")->name("admin.user_frontend.store")->middleware('can:admin-user_frontend-add');
        Route::get('/update-active/{id}', "AdminUserFrontendController@loadActive")->name("admin.user_frontend.load.active")->middleware('can:admin-user_frontend-active');
        Route::get('/update-active-key/{id}', "AdminUserFrontendController@loadActiveKey")->name("admin.user_frontend.load.active-key")->middleware('can:admin-user_frontend-active');
        Route::get('/load-detail/{id}', "AdminUserFrontendController@loadUserDetail")->name("admin.user_frontend.loadUserDetail")->middleware('can:admin-user_frontend-list');
        Route::get('/transfer-point/{id}', "AdminUserFrontendController@transferPoint")->name("admin.user_frontend.transferPoint")->middleware('can:admin-user_frontend-transfer-point');
        Route::get('/transfer-point-between', "AdminUserFrontendController@transferPointBetweenXY")->name("admin.user_frontend.transferPointBetweenXY")->middleware('can:admin-user_frontend-transfer-point');
        Route::get('/transfer-point-random', "AdminUserFrontendController@transferPointRandom")->name("admin.user_frontend.transferPointRandom")->middleware('can:admin-user_frontend-transfer-point');
        Route::get('/edit/{id}', "AdminUserFrontendController@edit")->name("admin.user_frontend.edit")->middleware('can:admin-user_frontend-edit');
        Route::post('/update/{id}', "AdminUserFrontendController@update")->name("admin.user_frontend.update")->middleware('can:admin-user_frontend-edit');
        Route::get('/destroy/{id}', "AdminUserFrontendController@destroy")->name("admin.user_frontend.destroy")->middleware('can:admin-user_frontend-delete');

        // quản lý review
        Route::get('/review', "AdminUserFrontendController@listReview")->name("admin.listReview")->middleware('can:review-list');
        Route::get('/review/{id}', "AdminUserFrontendController@listReviewId")->name("admin.listReviewId")->middleware('can:review-list');
        Route::get('/update-review-active/{id}', "AdminUserFrontendController@loadActiveReview")->name("admin.loadActiveReview")->middleware('can:review-duyet');


        Route::get('/destroy-review/{id}', "AdminUserFrontendController@destroyReview")->name("admin.destroyReview")->middleware('can:review-delete');
        Route::get('/update-review-status/{id}', "AdminUserFrontendController@loadStatusReview")->name("admin.loadStatusReview")->middleware('can:review-status');
        Route::get('/list-book', "AdminUserFrontendController@listBook")->name("admin.listBook")->middleware('can:review-status');
        Route::get('/list-book/{id}', "AdminUserFrontendController@listBookId")->name("admin.listBookId")->middleware('can:review-status');
    });
    Route::group(['prefix' => 'pay'], function () {
        Route::get('/', "AdminPayController@index")->name("admin.pay.index")->middleware('can:pay-list');
        Route::get('/update-draw-point', "AdminPayController@updateDrawPoint")->name("admin.pay.updateDrawPoint")->middleware('can:pay-update-draw-point');
        Route::get('/update-draw-point-all', "AdminPayController@updateDrawPointAll")->name("admin.pay.updateDrawPointAll")->middleware('can:pay-update-draw-point');
        Route::post('/export/excel/database', "AdminPayController@excelExportDatabase")->name("admin.pay.export.excel.database")->middleware('can:pay-export-excel');
    });


    Route::group(['prefix' => 'role'], function () {
        Route::get('/', "AdminRoleController@index")->name("admin.role.index")->middleware('can:role-list');
        Route::get('/create', "AdminRoleController@create")->name("admin.role.create")->middleware('can:role-add');
        Route::post('/store', "AdminRoleController@store")->name("admin.role.store")->middleware('can:role-add');
        Route::get('/edit/{id}', "AdminRoleController@edit")->name("admin.role.edit")->middleware('can:role-edit');
        Route::post('/update/{id}', "AdminRoleController@update")->name("admin.role.update")->middleware('can:role-edit');
        Route::get('/destroy/{id}', "AdminRoleController@destroy")->name("admin.role.destroy")->middleware('can:role-delete');
    });
    Route::group(['prefix' => 'permission'], function () {
        Route::get('/', "AdminPermissionController@index")->name("admin.permission.index")->middleware('can:permission-list');
        Route::get('/create', "AdminPermissionController@create")->name("admin.permission.create")->middleware('can:permission-add');
        Route::post('/store', "AdminPermissionController@store")->name("admin.permission.store")->middleware('can:permission-add');
        Route::get('/edit/{id}', "AdminPermissionController@edit")->name("admin.permission.edit")->middleware('can:permission-edit');
        Route::post('/update/{id}', "AdminPermissionController@update")->name("admin.permission.update")->middleware('can:permission-edit');
        Route::get('/destroy/{id}', "AdminPermissionController@destroy")->name("admin.permission.destroy")->middleware('can:permission-delete');
    });

    Route::group(['prefix' => 'transaction'], function () {
        Route::get('status-next/{id}', "AdminTransactionController@loadNextStepStatus")->name("admin.transaction.loadNextStepStatus")->middleware('can:transaction-status');
        Route::get('/', "AdminTransactionController@index")->name("admin.transaction.index")->middleware('can:transaction-list');
        Route::get('/show/{id}', "AdminTransactionController@show")->name("admin.transaction.show")->middleware('can:transaction-list');
        Route::get('/destroy/{id}', "AdminTransactionController@destroy")->name("admin.transaction.destroy")->middleware('can:transaction-delete');
        Route::get('/update-thanhtoan/{id}', "AdminTransactionController@loadThanhtoan")->name("admin.product.load.thanhtoan")->middleware('can:transaction-list');
        Route::get('/transaction-detail/{id}', "AdminTransactionController@loadTransactionDetail")->name("admin.transaction.detail")->middleware('can:transaction-list');
        Route::get('/transaction-detail/export/pdf/{id}', "AdminTransactionController@exportPdfTransactionDetail")->name("admin.transaction.detail.export.pdf");

        Route::get('/edit-status/{id}', 'AdminTransactionController@editStatus')->name('admin.editStatus');
        Route::post('/update-status/{id}', 'AdminTransactionController@updateStatus')->name('admin.updateStatus');
    });
    Route::group(['prefix' => 'contact'], function () {
        Route::get('status-next/{id}', "AdminContactController@loadNextStepStatus")->name("admin.contact.loadNextStepStatus");
        Route::get('/', "AdminContactController@index")->name("admin.contact.index");
        Route::get('/show/{id}', "AdminContactController@show")->name("admin.contact.show");
        Route::get('/destroy/{id}', "AdminContactController@destroy")->name("admin.contact.destroy");
        Route::get('/contact-detail/{id}', "AdminContactController@loadContactDetail")->name("admin.contact.detail");
    });

    Route::group(['prefix' => 'bank'], function () {
        Route::get('/', "AdminBankController@index")->name("admin.bank.index")->middleware('can:bank-list');
        Route::get('/create', "AdminBankController@create")->name("admin.bank.create")->middleware('can:bank-add');
        Route::post('/store', "AdminBankController@store")->name("admin.bank.store")->middleware('can:bank-add');
        Route::get('/edit/{id}', "AdminBankController@edit")->name("admin.bank.edit")->middleware('can:bank-edit');
        Route::post('/update/{id}', "AdminBankController@update")->name("admin.bank.update")->middleware('can:bank-edit');
        Route::get('/destroy/{id}', "AdminBankController@destroy")->name("admin.bank.destroy")->middleware('can:bank-delete');
    });
    Route::group(['prefix' => 'store'], function () {
        Route::get('/', "AdminStoreController@index")->name("admin.store.index")->middleware('can:store-list');
        Route::get('/create', "AdminStoreController@create")->name("admin.store.create")->middleware('can:store-input');
        Route::post('/store', "AdminStoreController@store")->name("admin.store.store")->middleware('can:store-input');
        Route::get('/edit/{id}', "AdminStoreController@edit")->name("admin.store.edit")->middleware('can:store-edit');
        Route::post('/update/{id}', "AdminStoreController@update")->name("admin.store.update")->middleware('can:store-edit');
        Route::get('/destroy/{id}', "AdminStoreController@destroy")->name("admin.store.destroy")->middleware('can:store-delete');
    });

    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', "AdminSupplierController@index")->name("admin.supplier.index")->middleware('can:product-list');
        Route::get('/create', "AdminSupplierController@create")->name("admin.supplier.create")->middleware('can:product-add');
        Route::post('/store', "AdminSupplierController@store")->name("admin.supplier.store")->middleware('can:product-add');
        Route::get('/edit/{id}', "AdminSupplierController@edit")->name("admin.supplier.edit")->middleware('can:product-edit');
        Route::post('/update/{id}', "AdminSupplierController@update")->name("admin.supplier.update")->middleware('can:product-edit');
        Route::get('/destroy/{id}', "AdminSupplierController@destroy")->name("admin.supplier.destroy")->middleware('can:product-delete');
        Route::get('/update-active/{id}', "AdminSupplierController@loadActive")->name("admin.supplier.load.active")->middleware('can:product-edit');
    });


    Route::group(['prefix' => 'comment-product'], function () {
        Route::get('/', "AdminProductCommentController@index")->name("admin.product.comment.index")->middleware('can:comment-product-list');
        Route::get('/destroy/{id}', "AdminProductCommentController@destroy")->name("admin.product.comment.destroy")->middleware('can:comment-product-delete');
        // duyệt bình luận
        Route::get('/update-active-comment/{id}', "AdminProductCommentController@loadActiveComment")->name("admin.product.loadActiveComment")->middleware('can:comment-product-active');
    });
    Route::group(['prefix' => 'comment-review'], function () {
        Route::get('/', "AdminReviewCommentController@index")->name("admin.review.comment.index")->middleware('can:comment-review-list');
        Route::get('/destroy/{id}', "AdminReviewCommentController@destroy")->name("admin.review.comment.destroy")->middleware('can:comment-review-delete');
        // duyệt bình luận
        Route::get('/update-active-comment/{id}', "AdminReviewCommentController@loadActiveComment")->name("admin.review.loadActiveComment")->middleware('can:comment-review-active');
    });
});
Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/preview/{id}', "ReviewController@preview")->name("admin.review.preview")->middleware('can:review-duyet');
});
