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

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//LA Logout
Route::get('logoutBooking', 'Auth\LoginController@logout');

// ** INIT BOOKING ** //

Route::get('/','UserBookingController@loadBooking')->name('index');

// ** AUTHORIZATION ROUTE ** //

Auth::routes();

// ** DASHBOARD ROUTE ** //

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home-login', 'CustomLoginController@index');


// ** AJAX REQUESTS ** //

Route::post('/get_packages', 'UserBookingController@getPackages')->name('packages');
Route::get('/get-packages-by-category', 'UserBookingController@getPackagesByCategory')->name('getPackagesByCategory');
Route::get('/get-packages-by-type', 'UserBookingController@getPackagesByType')->name('getPackagesByType');
Route::get('/get-booking-types', 'UserBookingController@getBookingType')->name('getBookingType');
Route::get('/get-draws', 'UserBookingController@getDraws')->name('getDraws');
Route::get('/get-draw-times', 'UserBookingController@getDrawTimes')->name('getDrawTimes');
Route::get('/get-date-draw', 'UserBookingController@getDateDraw')->name('getDateDraw');
Route::get('/check-user-draw', 'UserBookingController@checkUserDraw')->name('checkUserDraw');
Route::get('/get-package-type', 'UserBookingController@getPackageType')->name('getPackageType');
Route::get('/set-package-type', 'UserBookingController@setPackageType')->name('setPackageType');
Route::post('/set-hour-list', 'UserBookingController@getHoursByDate')->name('getHoursByDate');
Route::post('/remove-hour-list', 'UserBookingController@removeHoursByDate')->name('removeHoursByDate');
Route::post('/get_timing_slots', 'UserBookingController@getTimingSlots')->name('slots');
Route::post('/get_update_slots', 'UserBookingController@getUpdateSlots')->name('updateSlots');
Route::post('/remove_session_addon', 'UserBookingController@removeFromList');
Route::get('/admin-get-packages-by-type', 'UserBookingController@getPackagesByType')->name('AdminGetPackagesByType');
Route::get('/admin-get-select-days', 'AdminGeneralOccupationController@getSelectDays')->name('AdminGetSelectDays');



// Verb		URI						 Paráme	Action	Route Name		Override				public function
// GET		/<entity>				         index	<entity>.index	->name('override')	index()
// GET		/<entity>/create		         	create	<entity>.create	->name('override')	create()
// GET		/<entity>/{entity}		 /{id}   show		<entity>.show     ->name('override')	show($id)
// GET		/<entity>/{entity}/edit	         edit		<entity>.edit     ->name('override')	edit($id)
// POST		/<entity>				 /{id}   store	<entity>.store    ->name('override')	store(Request $request)
// PUT/PATCH	/<entity>/{entity}		 /{id}   update	<entity>.update	->name('override')	update(Request $request, $id)
// DELETE	/<entity>/{entity}		         destroy	<entity>.destroy	->name('override')	destroy($id)

// ** USER ROLE ADMIN ROUTES ** //

Route::group(['middleware'=>'admin'], function(){

    Route::resource('/users','AdminUsersController');
    Route::resource('/categories', 'AdminCategoriesController');
	Route::resource('/groups', 'AdminGroupsController');
    Route::resource('/events', 'AdminEventsController');
    Route::resource('/court', 'AdminCourtController');
    Route::resource('/packages-types', 'AdminPackagesTypesController');
    Route::get('/packages-types-by-category', 'AdminPackagesTypesController@getPackageByCategory');
    Route::resource('/guests', 'AdminGuestsController');
    Route::resource('/blacklist', 'AdminBlacklistController');
    Route::resource('/packages', 'AdminPackagesController');
    Route::resource('/addons', 'AdminAddonsController');
    Route::resource('/addons-parameters', 'AdminAddonParameterController');
    Route::get('/addons-parameters-generate', 'AdminAddonParameterController@generateAddonParameters')->name('generateAddonParameters');
    Route::resource('/settings', 'AdminSettingsController');
    Route::resource('/booking-times', 'AdminBookingTimesController');
    Route::resource('/booking-times-package', 'AdminBookingTimesPackageController');
    Route::get('/booking-times-package-generate', 'AdminBookingTimesPackageController@generateDays')->name('generateDays');
    Route::resource('/bookings', 'AdminBookingsController');
    Route::resource('/invoice', 'AdminInvoicesController');
    Route::resource('/cancel-requests', 'CancelRequestController');
    Route::post('/cancel-booking/{id}', 'AdminBookingsController@cancel')->name('cancelBooking');
    Route::patch('/updateBooking/{id}', 'AdminBookingsController@update_booking_time')->name('updateBookingTime');
    Route::resource('/general-occupation','AdminGeneralOccupationController');
    Route::get('/booking-category-calendar', 'UserBookingController@getBookingCategoryCalendar')->name('getBookingCategoryCalendar');

   

    //database update controller

    Route::get('/update-database', 'DatabaseUpdateController@update');
    Route::get('/unpaid-invoices', 'OfflinePaymentController@index')->name('unpaidInvoices');

    Route::get('/draws', 'AdminDrawsController@index')->name('adminDraws');

});

// ** USER ROLE CUSTOMER ROUTES ** //

Route::group(['middleware'=>'customer'], function(){

    Route::get('/customer/bookings', 'UserBookingController@index')->name('customerBookings');
    Route::get('/customer/booking/{id}', 'UserBookingController@show')->name('showBooking');
    Route::get('/customer/draws', 'CustomerDrawsController@index')->name('customerDraws');
    Route::get('/customer/draw/{id}', 'CustomerDrawsController@show')->name('showDraw');
    Route::get('/customer/invoices', 'CustomerInvoiceController@index')->name('customerInvoices');
    Route::get('/customer/invoice/{id}', 'CustomerInvoiceController@show')->name('showInvoice');
    Route::get('/customer/profile', 'CustomerProfileController@index')->name('customerProfile');
    Route::patch('/customer/{id}', 'CustomerProfileController@update')->name('customerUpdate');
    Route::post('/cancel-request', 'CancelRequestController@store')->name('cancelRequest');
    Route::get('/update-booking/{id}', 'UserBookingController@update')->name('updateBooking');
    Route::patch('/booking/{id}', 'UserBookingController@update_booking')->name('postUpdateBooking');
});

// ** COMMON ROUTES FOR AUTHENTICATED USERS ** //

Route::group(['middleware'=>'authenticated'], function() {

    // ** BOOKING FORM ROUTES ** //

    Route::post('/postStep1', 'UserBookingController@postStep1')->name('postStep1');
    Route::post('/setStep2', 'UserBookingController@setStep2')->name('setStep2');
	
    Route::get('/select-booking-players', 'UserBookingController@loadStepPlayer')->name('loadStepPlayer');
    Route::post('/postStepPlayer', 'UserBookingController@postStepPlayer')->name('postStepPlayer');
	
    Route::get('/select-booking-time', 'UserBookingController@loadStep2')->name('loadStep2');
    Route::post('/postStep2', 'UserBookingController@postStep2')->name('postStep2');
    Route::get('/select-extra-services', 'UserBookingController@loadStep3')->name('loadStep3');
    Route::post('/postStep3', 'UserBookingController@postStep3')->name('postStep3');
    Route::get('/finalize-booking', 'UserBookingController@loadFinalStep')->name('loadFinalStep');
    Route::get('/extra-service-participants', 'UserBookingController@getExtraServiceParticipants')->name('getExtraServiceParticipants');
    Route::post('/extra-service-set-participant', 'UserBookingController@setParticipant')->name('setParticipant');
    Route::get('/check-user-package-parameters', 'UserBookingController@checkUserPackageParameters')->name('checkUserPackageParameters');
    Route::resource('/package-types-exception', 'AdminPackageTypeExceptionController');


    //PAYMENT GATEWAYS

    Route::post('/payWithStripe', 'StripeController@payWithStripe')->name('payWithStripe');
    Route::get('/payWithPaypal', 'PaypalController@payWithPaypal')->name('payWithPaypal');
    Route::get('/pay-after-service', 'OfflinePaymentController@payOffline')->name('payOffline');
    Route::get('/paymentSuccessful', 'PaypalController@paymentSuccessful')->name('paymentSuccessful');
    Route::get('/paymentFailed', 'PaypalController@paymentFailed')->name('paymentFailed');

    // ** BOOKING COMPLETE OR FAILED ROUTES ** //

    Route::get('/thank-you', 'UserBookingController@thankYou')->name('thankYou');
    Route::get('/payment-failed', 'UserBookingController@paymentFailed')->name('paymentFailed');

    // ** AUXILIARY ROUTES  ** //

    Route::resource('/session_addons','SessionAddonsController');
    Route::get('/check-booking-addons','SessionAddonsController@checkBookingAddons');
    Route::get('/remove-adddon-by-participant','SessionAddonsController@removeAddonByParticipant');
    Route::get('/total-session-addons','SessionAddonsController@getTotal');
    Route::get('/account-disabled', function (){
        return view('errors.accountDisabled');
    });

    // ** PASSWORD CHANGE ROUTES ** //

    Route::get('/password/update', 'UserPasswordController@index')->name('changePassword');
    Route::patch('/password/update/{id}', 'UserPasswordController@update')->name('postChangePassword');

	Route::get('/password/register', 'UserPasswordController@registerpassword');
	Route::post('/password/register', 'UserPasswordController@store')->name('postRegisterPassword');
	
});