<?php

use App\PushDevices;
use App\Rate;
use App\WebPush;
use App\WebPushMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::get('countries','Api\GeneralController@countries');
Route::get('terms-conditions', 'Api\GeneralController@termsConditions');
Route::get('refund-policy', 'Api\GeneralController@refundPolicy');
Route::get('privacy-policy', 'Api\GeneralController@privacyPolicy');
Route::get('login-help', 'Api\GeneralController@LoginHelp');
Route::get('faq', 'Api\GeneralController@faq');

Route::prefix('user')->namespace('Api\User')->group(function () {
    Route::post('login', 'AuthController@login');
    
    Route::post('register','AuthController@register')->name('register');
    Route::post('register-verified-otp', 'AuthController@registerationCodeValidation')->name('register.index')->middleware('guest');
    Route::post('register-resent-otp', 'AuthController@registerationResentCodeValidation')->name('register.index')->middleware('guest');

    Route::post('send-changepassword-otp', 'AuthController@sendOtpChangePassword');
    Route::post('code-validation', 'AuthController@codeValidation');
    Route::post('change-password', 'AuthController@changePassword');
    Route::post('contactus', 'ContactUsController@store');




    Route::get('get-parent-categories', 'CategoryController@getParentCategory');
    Route::post('get-sub-category', 'CategoryController@getSubCategories');

    Route::get('get-slideshows', 'SlideshowController@getSlideShows');

    Route::get('get-workshops', 'WorkshopController@getWorkShops');
    Route::get('get-highlight-workshops', 'WorkshopController@getHighlightWorkShops');
    Route::post('get-single-workshop', 'WorkshopController@getSingleWorkShop');

    Route::post('category/{category_id}/freelancers', 'FreelancerController@getFreelancers');  //optional   price_filter=> Asc or Dget
    Route::post('get-single-freelancer', 'FreelancerController@getSingleFreelancer'); // id  =>  freelancer id
    Route::post('get-freelancer-services', 'FreelancerController@getFreelancerServices'); // id  =>  freelancer id
    Route::post('get-highlight-services', 'FreelancerController@getHighlightServices');   // id  =>  freelancer id
    Route::post('get-single-service', 'FreelancerController@getSingleService');   // freelancer_id, service_id

    Route::post('search', 'SearchController@search');

});

Route::get('push-message-token/{token}', function ($token) {
    PushDevices::firstOrCreate(['token' => $token, 'device' => 'web']);

    return response('DONE', 200);
});

Route::middleware(['auth:api'])->prefix('user')->namespace('Api\User')->group(function () {
    Route::post('logout','AuthController@logoutApi');
    Route::get('notification', 'NotificationController@index');
    Route::get('status', 'NotificationController@status');

    Route::post('profile', 'AuthController@updateProfile');
    Route::post('sendOTPToUser', 'AuthController@sendOTPToUser');


    Route::get('get-profile-details', 'AuthController@getDetails');

    Route::get('bill/{id}', 'BillController@show');



    
    Route::get('freelancer/{id}/address', 'UserAddressController@getFreelancerAddress');

    Route::get('get-messages', 'MessagesController@getMessages');
    Route::post('get-freelancer-messages', 'MessagesController@getFreelancerMessages');
    Route::post('store-message', 'MessagesController@storeMessages');
    Route::get('block-message/{id}', 'MessagesController@blockUser');
    Route::get('report-message/{id}', 'MessagesController@reportUser');
    Route::get('clear-chat/{id}', 'MessagesController@clearChat');
    Route::get('delete-chat/{id}', 'MessagesController@deleteInbox');
    Route::get('read-chat/{id}', 'MessagesController@readChat');
    Route::get('unread-chat/{id}', 'MessagesController@unreadChat');

    Route::resource('bookmarks', 'BookmarkController', ['only' => [
        'index', 'store' , 'destroy' , 'update'
    ]]);


    Route::post('freelancer/{id}/rate', [\App\Http\Controllers\Api\User\FreelancerRateController::class, 'store'])->name('rate.add');

    Route::resource('addresses', 'UserAddressController', ['only' => [
        'index', 'store' , 'destroy' , 'update', 'show'
    ],  'as' => 'user.address']);

    Route::post('quotation', 'UserQuotationController@store');
    Route::get('quotation/{id}', 'UserQuotationController@show');

    //Route::post('service-book', 'BookingController@bookUserService');
    Route::post('service/add-cart', 'BookingV2Controller@bookOneService');
    Route::post('service/make-order', 'BookingV2Controller@bookUserService');
    Route::get('order/{id}/service', 'BookingController@getServiceOrder');
    Route::get('order/{id}/service/cancel', 'BookingController@cancel');
    Route::get('order/{id}/service/reschedule/{slotId}', 'BookingController@rescheduleService');


    Route::post('slots', 'MeetingController@getSlots');
    Route::post('calendar', 'FreelancerController@getCalendar');
    Route::get('waiting', 'BookingController@waitingList');

    Route::post('meetings', 'MeetingController@store');
    Route::get('meeting/{id}/cancel', 'MeetingController@cancel');
    Route::get('meeting/{id}/reschedule/{slotId}', 'MeetingController@reschedule');



    Route::get('my-deals', 'DealsController@myDeals');
    Route::get('orders', 'DealsController@orders');

    Route::post('workshop-book', 'BookingController@workshopBook');
    Route::get('order/{id}/workshop', 'BookingController@getWorkshopOrder');
    Route::get('order/{id}/workshop/cancel', 'BookingController@cancelWorkshopOrder');


});

Route::get('get-setting', 'Api\Freelancer\ContactUsController@getSetting');
Route::prefix('freelancer')->namespace('Api\Freelancer')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('send-forgotPassword-otp', 'AuthController@sendForgotPasswordOTP');
    Route::post('change-forgotPassword', 'AuthController@changeForgotPassword');
    //Route::post('register','AuthController@register')->name('register-f');
    Route::post('contactus', 'ContactUsController@store');
    

});

Route::middleware(['auth:api_freelancer' , 'isFreelancerHasActivePackage'])->prefix('freelancer')->namespace('Api\Freelancer')->group(function () {
    Route::post('logout','AuthController@logoutApi');
    Route::apiResource('service', 'ServiceController');
    Route::apiResource('calendar', 'calendarController');
    Route::any('calendar/status', 'calendarController@getDaysStatus');
    Route::post('calendarV2', 'calendarController@storeV2');
    Route::apiResource('address', 'AddressController');
    Route::get('get-messages', 'MessagesController@getMessages');
    Route::post('get-user-messages', 'MessagesController@getUserMessages');
    Route::post('store-message', 'MessagesController@storeMessages');
    Route::get('block-message/{id}', 'MessagesController@blockUser');
    Route::get('report-message/{id}', 'MessagesController@reportUser');
    Route::get('clear-chat/{id}', 'MessagesController@clearChat');
    Route::get('delete-chat/{id}', 'MessagesController@deleteInbox');
    Route::get('read-chat/{id}', 'MessagesController@readChat');
    Route::get('unread-chat/{id}', 'MessagesController@unreadChat');
    Route::apiResource('category', 'CategoryController',['only' => ['index' ,'store']]);
    Route::get('get-parent-categories', 'CategoryController@getParentCategory');
    Route::post('get-sub-category', 'CategoryController@getSubCategories');
    Route::get('notification', 'NotificationController@index');
    Route::get('status', 'NotificationController@status');
    Route::apiResource('workshop', 'WorkshopController');
    Route::PUT('profile', 'ProfileController@update');
    Route::get('profile', 'ProfileController@profile');
    Route::post('sendOTP', 'ProfileController@sendOTPToUser');
    Route::get('subscription', 'ProfileController@subscription');
    Route::apiResource('quotation', 'QuotationController');
    Route::apiResource('highlight', 'HighlightsController');
    Route::apiResource('bill', 'BillController');
    Route::get('areas', 'AddressController@getAreas');
    Route::post('areas', 'AddressController@areas');
    Route::post('events', 'DealsController@calendar');
    Route::get('orders', 'DealsController@orders');
    Route::post('earn', 'DealsController@earn');
    Route::delete('meeting/{id}', 'DealsController@cancelMeeting');
    Route::PUT('meeting/{id}', 'DealsController@rescheduleMeeting');
    Route::delete('order/{id}/service', 'DealsController@cancelService');
    Route::delete('order/{id}/service/not-available', 'DealsController@notavailable');
    Route::PUT('order/{id}/service', 'DealsController@rescheduleService');
});

