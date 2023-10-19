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

use App\Mail\SendGrid;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::get('test', 'Front\LandingController@test');

Route::get('uploads/{name?}/{type?}/{file?}' , function($name = null , $type = null , $file = null ) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://picsum.photos/seed/'.$name.'-'. $type . "-" .$file.'/450/210',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    header( "Content-type: image/png" );
    echo $response;
    exit;
});

Route::get('terms-conditions', 'Front\LandingController@termsAndCondotopns')->name('termandconditions');
Route::get('refund-policy', 'Front\LandingController@RefundPolicy')->name('refundpolicy');
Route::get('payment/success', 'Front\PaymentController@success')->name('payment.success');
Route::get('payment/fail', 'Front\PaymentController@fail')->name('payment.fail');
Route::get('api/bill/{uuid}', 'Front\PaymentController@showBill')->name('payment.showBill');

Route::get('/set-locale/{locale}', 'Front\LandingController@setLocale');
Route::get('/', 'Front\LandingController@index');
Route::get('/login', 'Front\LandingController@loginPage')->name('login.index')->middleware('guest');
Route::post('/login', 'Front\LandingController@login')->name('login.store')->middleware('guest');
Route::get('/register', 'Front\LandingController@registerPage')->name('register.index')->middleware('guest');
Route::post('/register', 'Front\LandingController@register')->name('register.store')->middleware('guest');

Route::middleware(['auth:freelancer'])->namespace('Front')->prefix('freelancer')->group(function () {
    Route::get('/', 'LandingController@packages')->name('packages');
    Route::get('/logout', 'LandingController@logOut')->name('logout');
    Route::post('payment', 'PaymentController@formSubmit')->name('payment');

});
//Auth::routes();


Route::post('/gwc/get-country-cities', "WebController@getCountryCities");
Route::post('/gwc/get-country-cities-edit', "WebController@getCountryCitiesEdit");
Route::post('/gwc/get-city-areas', "WebController@getAreas");

Route::namespace('Admin')->prefix('gwc')->group(function () {

//Admin authentication
    Route::get('/', 'AdminAuthController@index');
    Route::get('/javascript:;', function() { return redirect()->back(); } );
    Route::post('/login', 'AdminAuthController@login')->name('adminLogin');
    Route::post('/logout', 'AdminAuthController@logout')->name('adminLogout');

    Route::get('/forgot', 'AdminAuthController@forgot');
    Route::post('/email', 'AdminAuthController@sendResetLinkEmail')->name('gwc.email');
    Route::get('/forgot/{token}', 'AdminAuthController@showResetForm')->name('gwc.reset');
    Route::post('/forgot/{token}', 'AdminAuthController@resetPassword')->name('gwc.token');
//dashboard
    Route::get('/home', 'AdminDashboardController@index')->middleware('admin');
});

//admins
Route::namespace('Admin')->prefix('gwc')->middleware('admin')->group(function () {

    Route::get('workshops/approval', 'WorkShopController@approval');
    Route::get('workshop/approval/{id}/approved', 'WorkShopController@approved')->name('approvedWorkshop');
    Route::get('workshop/approval/{id}/reject', 'WorkShopController@reject')->name('rejectWorkshop');
    
    Route::resource('freelancers/{freelancer_id}/highlights', 'AdminFreelancerHighlightController');
    Route::get('freelancers/{freelancer_id}/highlights/delete/{highlight_id}', 'AdminFreelancerHighlightController@destroy');

    Route::post('/webpush/save', 'webPushController@saveWebPush')->name('savePush');
    Route::post('/webpush/saveEdit/{id}', 'webPushController@saveEditWebPush')->name('saveEdit');
    Route::get('/webpush/delete/{id}', 'webPushController@destroyWebPushs');
    Route::get('/webpush/devicetokens', 'webPushController@devicetokens');
    Route::get('/webpush/devicetokens/delete/{id}', 'webPushController@deletedevicetokens');
    Route::resource('webpush', 'webPushController');
    Route::get('/web_push_token_save', 'webPushController@saveToken');

    //admin User
    Route::resource('admins', 'AdminAdminsController');
    Route::post('/admins/{id}', 'AdminAdminsController@update');
    Route::get('/admins/ajax/{id}', 'AdminAdminsController@updateStatusAjax');
    Route::get('/admins/changepass/{id}', 'AdminAdminsController@edit')->name('changePass');
    Route::post('/admins/changepass/{id}', 'AdminAdminsController@adminChangePass')->name('adminChangePass');
    Route::get('/admins/delete/{id}', 'AdminAdminsController@destroy');
    Route::get('/admins/deleteimage/{id}/{field}', 'AdminAdminsController@deleteImage');


    //categories
    Route::resource('categories', 'CategoryController');
    Route::get('category/delete/{id}', 'CategoryController@destroy');
    Route::get('category/ajax/{id}', 'CategoryController@updateStatusAjax');

    //attributes
    Route::resource('attributes', 'AttributeController');
    Route::get('attributes/delete/{id}', 'AttributeController@destroy');

    //attributeGroup
    Route::resource('attribute-groups', 'AttributeGroupController');
    Route::get('attribute-groups/delete/{id}', 'AttributeGroupController@destroy');

    //users
    Route::resource('users', 'AdminUsersController');
    Route::get('users/delete/{id}', 'AdminUsersController@destroy');
    Route::resource('freelancers', 'FreeLancersController');
    Route::get('freelancers/delete/{id}', 'FreeLancersController@destroy');

    Route::get('freelancers/ajax/{id}', 'FreeLancersController@updateStatusAjax');
    Route::get('freelancers/offline/ajax/{id}', 'FreeLancersController@updateOfflineStatusAjax');

    Route::get('freelancers-approval', 'FreeLancersController@approval');
    Route::get('freelancers-approval/{id}/approved', 'FreeLancersController@approved')->name('approvedFreeLancer');
    Route::get('freelancers-approval/{id}/reject', 'FreeLancersController@reject')->name('rejectFreeLancer');


    Route::get('freelancer/{freelancer_id}/services', 'FreeLancerServicesController@index')->name('services.index');;
    Route::get('freelancer/{freelancer_id}/services/create', 'FreeLancerServicesController@create');
    Route::post('freelancer/{freelancer_id}/services', 'FreeLancerServicesController@store')->name('services.store');
    Route::get('freelancer/{freelancer_id}/services/{service_id}/edit', 'FreeLancerServicesController@edit');
    Route::post('freelancer/{freelancer_id}/services/{service_id}', 'FreeLancerServicesController@update')->name('services.update');
    Route::get('freelancer/{freelancer_id}/services/delete/{service_id}', 'FreeLancerServicesController@destroy')->name('services.destroy');


    Route::get('freelancer/{freelancer_id}/calenders', 'FreeLancerCalenderController@index')->name('calenders.index');;
    Route::get('freelancer/{freelancer_id}/calenders/create', 'FreeLancerCalenderController@create');
    Route::post('freelancer/{freelancer_id}/calenders', 'FreeLancerCalenderController@store')->name('calenders.store');
    Route::get('freelancer/{freelancer_id}/calenders/{service_id}/edit', 'FreeLancerCalenderController@edit');
    Route::post('freelancer/{freelancer_id}/calenders/{service_id}', 'FreeLancerCalenderController@update')->name('calenders.update');
    Route::get('freelancer/{freelancer_id}/calenders/delete/{service_id}', 'FreeLancerCalenderController@destroy')->name('calenders.destroy');


    Route::get('/service-highlight/ajax/{id}', 'FreeLancerServicesController@updateHighlightAjax');
    Route::get('/service-isactive/ajax/{id}', 'FreeLancerServicesController@updateStatusAjax');


    Route::get('freelancers/{id}/quotation', 'FreeLancersController@FreelancerQuotation');
    Route::get('freelancers/{id}/quotation/{quotation_id}', 'FreeLancersController@FreelancerQuotationDetails');
    

    Route::get('freelancers/{id}/payments', 'FreeLancersController@FreelancerPayments');

    Route::get('freelancers/{id}/messages', 'FreeLancersController@FreelancerMessage');
    Route::get('freelancers/{freelancer_id}/user/{user_id}/messages', 'FreeLancersController@userMessages');
    Route::get('freelancer/{freelancer_id}/workshop', 'FreeLancerWorkShopController@index')->name('workshop.index');;
    Route::get('freelancer/{freelancer_id}/workshop/create', 'FreeLancerWorkShopController@create');
    Route::post('freelancer/{freelancer_id}/workshop', 'FreeLancerWorkShopController@store')->name('workshop.store');
    Route::get('freelancer/{freelancer_id}/workshop/{workshop_id}/edit', 'FreeLancerWorkShopController@edit');
    Route::post('freelancer/{freelancer_id}/workshop/{workshop_id}', 'FreeLancerWorkShopController@update')->name('workshop.update');
    Route::get('freelancer/{freelancer_id}/workshop/{workshop_id}', 'FreeLancerWorkShopController@show');
    Route::get('freelancer/{freelancer_id}/workshop/delete/{workshop_id}', 'FreeLancerWorkShopController@destroy')->name('workshop.destroy');
    
    Route::get('workshop/ajax/{id}', 'FreeLancerWorkShopController@changeHighlightStatus')->name('workshop.destroy');
    Route::get('freelancer_workshops/ajax/{id}', 'WorkShopController@changeActiveStatus')->name('workshop.destroy');
    Route::post('filter-freelancer-by-category', 'FreeLancersController@filterByCategory');

    Route::get('workshop-orders', 'AdminOrdersController@workShopOrders');
    Route::get('workshop-orders/{id}/view', 'AdminOrdersController@workShopOrdersDetails');

    Route::get('make-workshop-orders', 'AdminOrdersController@makeWorkShopOrders');

    Route::get('book-details/{type}/{id}' , 'AdminOrdersController@book_details' );

    Route::resource('freelancers/{id}/address', 'AdminFreelancerAddressController');
    Route::get('freelancers/{freelancer_id}/address/delete/{address_id}', 'AdminFreelancerAddressController@destroy')->name('workshop.destroy');

    Route::resource('workshops', 'WorkShopController');
    Route::get('workshops/{id}/view', 'WorkShopController@details');
    Route::get('packages/delete/{id}', 'WorkShopController@destroy');

    Route::get('services', 'ServiceController@index');

    Route::resource('meetings', 'MeetingController');
    Route::get('meetings/delete/{id}', 'MeetingController@destroy');

    Route::get('packages/ajax/{id}', 'PackagesController@updateStatusAjax');
    Route::resource('packages', 'PackagesController');
    Route::get('packages/delete/{id}', 'PackagesController@destroy');

//single pages
    Route::resource('/singlepages', 'AdminSinglePagesController');
    Route::get('/singlepages/ajax/{id}', 'AdminSinglePagesController@updateStatusAjax');
    Route::post('/singlepages/{id}', 'AdminSinglePagesController@update');
    Route::get('/singlepages/deleteimage/{id}/{field}', 'AdminSinglePagesController@deleteImage');
    Route::get('/singlepages/delete/{id}', 'AdminSinglePagesController@destroy');

    Route::get('slideshows/ajax/{id}', 'SlideshowsController@updateStatusAjax');
    Route::resource('slideshows', 'SlideshowsController');

    Route::resource('howitworks', 'HowItWorksController');
    Route::get('howitworks/delete/{id}', 'HowItWorksController@destroy');
    Route::get('slideshows/delete/{id}', 'SlideshowsController@destroy');
    Route::get('/ajax/{id}', 'AdminUsersController@updateStatusAjax');

    Route::get('/newsletter/{id}', 'AdminUsersController@updateNewsletterAjax');
    Route::get('users/changepass/{id}', 'AdminUsersController@edit')->name('changePass');
    Route::post('users/changepass/{id}', 'AdminUsersController@userChangePass')->name('userChangePass');
    Route::get('users/{id}/address', 'AdminUsersController@address')->name('userChangePass');
    Route::get('/deleteimage/{id}/{field}', 'AdminUsersController@deleteImage');
    Route::get('/delete/{id}', 'AdminUsersController@destroy');
    Route::resource('users/{id}/address', 'AdminUsersAddressController');
    Route::get('users/{user_id}/address/delete/{address_id}', 'AdminUsersAddressController@destroy')->name('workshop.destroy');


    //wishlist
    Route::get('users/{id}/wishlist', 'AdminUsersWishListController@index');
    Route::get('users/ajax/{user}', 'AdminUsersController@isActive');
    Route::get('wishlist/ajax/{user}', 'AdminUsersWishListController@addToWishlist');

    Route::resource('freelancer/{id}/meetings', 'AdminFreelancerMeetingController');
    Route::resource('freelancer/{id}/calendar', 'AdminFreelancerCalendarController');
    Route::get('freelancer/{freelancer_id}/meetings/delete/{id}', 'AdminFreelancerMeetingController@destroy');

//    Route::get('users/{user_id}/meeting/delete/{meeting_id}', 'AdminFreelancerController@destroy')->name('meeting.destroy');

    Route::get('users/{id}/orders', 'AdminOrdersController@index');
    Route::get('users/{id}/calenders', 'AdminOrdersController@deals')->name('user.calenders.index');;

    Route::get('users/{id}/messages', 'AdminUserMessagesController@index');
    Route::get('users/{user_id}/freelancer/{freelancer_id}/messages', 'AdminUserMessagesController@userMessages');

    Route::get('message/reported', 'AdminUserMessagesController@reportedMessage');
    Route::get('message/reported/{id}/checked', 'AdminUserMessagesController@reportedMessageChecked');

    Route::get('services/booked', 'BookedController@servicesList');
    Route::get('workshop/booked', 'BookedController@workshopsList');


    //Roles
    Route::resource('/roles', 'AdminRolesController');
    Route::post('/roles/{id}', 'AdminRolesController@update');
    Route::get('/roles/delete/{id}', 'AdminRolesController@destroy');

    //settings
    Route::get('settings', 'AdminSettingsController@index');
    Route::post('/settings', 'AdminSettingsController@update')->name('settings.update');
    Route::get('/settings/deleteimage/{field}', 'AdminSettingsController@deleteImage');

    //logs
    Route::resource('/logs', 'AdminLogsController');
    Route::get('/logs/delete/{id}', 'AdminLogsController@destroy');

    //notify emails
    Route::resource('/notifyemails', 'AdminNotifyEmailsController');
    Route::get('/notifyemails' . '/ajax/{id}', 'AdminNotifyEmailsController@updateStatusAjax');
    Route::post('/notifyemails' . '/{id}', 'AdminNotifyEmailsController@update');
    Route::get('/notifyemails' . '/delete/{id}', 'AdminNotifyEmailsController@destroy');

    //sms settings
    Route::get('sms', 'AdminSmsController@index');
    Route::post('/sms', 'AdminSmsController@update')->name('sms.update');
    
Route::get('download/quotation/download', 'FreeLancersController@FreelancerQuotationDownload')->name('download.quotation');
    //subjects
    Route::resource('/subjects', 'AdminSubjectsController');
    Route::get('/subjects/ajax/{id}', 'AdminSubjectsController@updateStatusAjax');
    Route::post('/subjects/{id}', 'AdminSubjectsController@update');
    Route::get('/subjects/delete/{id}', 'AdminSubjectsController@destroy');

    //contact us messages
    Route::resource('/messages', 'AdminMessagesController');
    Route::get('/messages/view/{id}', 'AdminMessagesController@view');
    Route::get('/messages/delete/{id}', 'AdminMessagesController@destroy');

    //countries
    Route::resource('countries', 'AdminCountriesController');
    Route::get('countries/delete/{id}', 'AdminCountriesController@destroy');

    //cities
    Route::get('/cities/ajax/{id}', 'AdminCitiesController@updateStatusAjax');
    Route::post('/cities/{id}', 'AdminCitiesController@update');
    Route::get('/cities/delete/{id}', 'AdminCitiesController@destroy');
    Route::get('/countries/{id}/cities', 'AdminCitiesController@countryCities');
    Route::resource('{id}/cities', 'AdminCitiesController');
    Route::get('{id}/cities/delete/{city}', 'AdminCitiesController@destroy');

    //Areas
    Route::get('/cities/{id}/areas', 'AdminAreasController@cityAreas');
    Route::get('/areas/ajax/{id}', 'AdminAreasController@updateStatusAjax');
    Route::post('/areas/{id}', 'AdminAreasController@update');
    Route::get('/areas/delete/{id}', 'AdminAreasController@destroy');
    Route::resource('{id}/areas', 'AdminAreasController');
    Route::get('{id}/areas/delete/{city}', 'AdminAreasController@destroy');


    //faq
    Route::get('faqs/ajax/{id}', 'FaqController@updateStatusAjax');
    Route::resource('faqs', 'FaqController');
    Route::get('faqs/delete/{id}', 'FaqController@destroy');
    Route::get('/faqs/deleteimage/{id}/{field}', 'FaqController@deleteImage');

    //orders
    Route::get('/orders', 'AdminOrdersController@indexSubscription');
//    Route::resource('/orders', 'AdminOrdersController');
    Route::resource('/user-payments', 'AdminOrdersController');
    Route::post('/orders/ajax', 'AdminOrdersController@storeValuesInCookies');
    Route::post('/orders/reset-date-range', 'AdminOrdersController@resetDateRange');
    Route::get('/orders/{id}/view', 'AdminOrdersController@view');
    Route::post('/orders/{id}', 'AdminOrdersController@update');
    Route::get('/orders/delete/{id}', 'AdminOrdersController@destroy');
    Route::get('/services-orders', 'AdminOrdersController@servicesOrders');
    Route::get('/services-orders/{id}/details', 'AdminOrdersController@servicesOrdersDetails');

    // transactions
    Route::resource('/transactions', 'AdminTransactionsController');
    Route::post('/transactions/ajax', 'AdminTransactionsController@storeValuesInCookies');
    Route::post('/transactions/reset-date-range', 'AdminTransactionsController@resetDateRange');
    Route::get('/transactions/{id}/view', 'AdminTransactionsController@view');
    Route::post('/transactions/{id}', 'AdminTransactionsController@update');
    Route::get('/transactions/delete/{id}', 'AdminTransactionsController@destroy');
    Route::post('/{id}', 'AdminUsersController@update');


    Route::get('/download/{id}', 'DownloadController@downloadFile')->name('message.download');
    
    Route::get('bills', 'BillController@index')->name('order.bill');

});
//save token


Route::post('/dropzone/image', 'DropzoneController@store')->name('dropzone.images.store');
Route::post('/dropzone/image/delete', 'DropzoneController@destroy')->name('dropzone.image.delete');
Route::post('/dropzone/image/remove', 'DropzoneController@store')->name('dropzone.images.remove');

//////////////////////////////////////////////////WEBSITE//////////////////////////////////////////////////


//Route::get('locale/{locale}', function ($locale) {
//    //Session::put('locale', $locale);
//    App::setLocale($locale);
//    return redirect()->back();
//});


////user authentication
//Route::get('/user/forgot', 'UserAuthController@forgot');
//Route::post('user/email', 'UserAuthController@sendResetLinkEmail')->name('user.email');
//Route::get('user/forgot/{token}', 'UserAuthController@showResetForm')->name('user.reset');
//Route::post('user/forgot/{token}', 'UserAuthController@resetPassword')->name('user.token');
//
//Route::get('/', 'WebController@home');
//
//Route::get('/subscribe/{code}', 'WebController@subscribe');
//
//Route::post('/pay', 'WebController@pay')->name('pay');
//Route::post('/knet-response', 'WebController@knetResponse')->name('knetResponse');
//Route::get('/knet-status', 'WebController@knetStatus')->name('knetStatus');
//
//Route::get('/trackorder', 'WebController@trackOrder');
//Route::post('/trackorder', 'WebController@trackOrder');
//
//Route::get('/about', 'WebController@about')->name('about');
//
//Route::get('/contact', 'WebController@contact')->name('contact');
//Route::post('/contactsubmit', 'WebController@contactSubmit')->name('contactsubmit');
//
//Route::get("/refreshcaptcha", "WebController@refreshCaptcha");

Route::get('ch', 'Front\PaymentController@formSubmit');
