<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/','Auth\LoginController@showLoginForm');
Route::get('/under-maintenance','HomeController@maintenance');
Route::get('/terms-and-conditions','HomeController@tnc');
Route::post('/user',array('as' => 'user.store','uses' => 'UserController@store'));

//Route::get('/test','TestController@index');

Route::group(['middleware' => 'guest'], function () {
	Route::get('/resend-activation','UserController@resendActivation');
	Route::post('/resend-activation',array('as' => 'user.resend-activation','uses' => 'UserController@postResendActivation'));
	Route::get('/activate-account/{token}','UserController@activateAccount');

	Route::get('/auth/{provider}', 'SocialLoginController@providerRedirect');
    Route::get('/auth/{provider}/callback', 'SocialLoginController@providerRedirectCallback');

	Route::get('/verify-purchase', 'AccountController@verifyPurchase');
	Route::post('/verify-purchase', 'AccountController@postVerifyPurchase');
	Route::resource('/install', 'AccountController',['only' => ['index', 'store']]);
	Route::get('/update','AccountController@updateApp');
	Route::post('/update',array('as' => 'update-app','uses' => 'AccountController@postUpdateApp'));
});

Auth::routes();

Route::group(['middleware' => ['auth','web','account']],function(){
	Route::get('/verify-security','UserController@verifySecurity');
	Route::post('/verify-security',array('as' => 'user.verify-security','uses' => 'UserController@postVerifySecurity'));
});

Route::group(['middleware' => ['auth','web','account','two_factor_auth','lock_screen','maintenance_mode']], function () {

	Route::get('/oauth/authorize',function(){
		return view('authorize');
	});

	Route::get('/release-license','AccountController@releaseLicense');
	Route::get('/check-update','AccountController@checkUpdate');
	Route::get('/home', 'HomeController@index');
	Route::post('/template/content','TemplateController@content',['middleware' => ['permission:enable_email_template']]);
	
	Route::get('/set-language/{locale}','LanguageController@setLanguage',['middleware' => ['permission:change-language']]);

	Route::group(['middleware' => ['permission:manage-email-log']], function () {
		Route::model('email','\App\Email');
		Route::post('/email/lists','EmailController@lists');
		Route::resource('/email', 'EmailController',['only' => ['index','show']]); 
	});

	Route::group(['middleware' => ['permission:manage-configuration']], function() {
		Route::get('/configuration', 'ConfigurationController@index');
		Route::post('/configuration',array('as' => 'configuration.store','uses' => 'ConfigurationController@store'));
		Route::post('/configuration-logo',array('as' => 'configuration.logo','uses' => 'ConfigurationController@logo'));
		Route::post('/configuration-mail',array('as' => 'configuration.mail','uses' => 'ConfigurationController@mail'));
		Route::post('/configuration-sms',array('as' => 'configuration.sms','uses' => 'ConfigurationController@sms'));
	});

	Route::group(['middleware' => ['permission:manage-template']], function() {
		Route::model('template','\App\Template');
		Route::post('/template/lists','TemplateController@lists');
		Route::resource('/template', 'TemplateController'); 
	});

	Route::group(['middleware' => ['permission:manage-message']], function() {
		Route::get('/message', 'MessageController@index'); 
		Route::post('/load-message','MessageController@load');
		Route::post('/message/{type}/lists','MessageController@lists');
		Route::get('/message/forward/{token}','MessageController@forward');
		Route::post('/message', ['as' => 'message.store', 'uses' => 'MessageController@store']);
		Route::post('/message-reply/{id}', ['as' => 'message.reply', 'uses' => 'MessageController@reply']);
		Route::post('/message-forward/{token}', ['as' => 'message.post-forward', 'uses' => 'MessageController@postForward']);
		Route::get('/message/{token}/download','MessageController@download');
		Route::post('/message/starred','MessageController@starred');
		Route::get('/message/{token}', array('as' => 'message.view', 'uses' => 'MessageController@view'));
		Route::delete('/message/{id}/trash', array('as' => 'message.trash', 'uses' => 'MessageController@trash'));
		Route::post('/message/restore', array('as' => 'message.restore', 'uses' => 'MessageController@restore'));
		Route::delete('/message/{id}/delete', array('as' => 'message.destroy', 'uses' => 'MessageController@destroy'));
	});

	Route::group(['middleware' => ['permission:manage-todo']], function() {
		Route::model('todo','\App\Todo');
		Route::resource('/todo', 'TodoController'); 
	});

	Route::group(['middleware' => ['permission:manage-language']], function() {
		Route::post('/language/lists','LanguageController@lists');
		Route::resource('/language', 'LanguageController'); 
		Route::post('/language/addWords',array('as'=>'language.add-words','uses'=>'LanguageController@addWords'));
		Route::patch('/language/plugin/{locale}',array('as'=>'language.plugin','uses'=>'LanguageController@plugin'));
		Route::patch('/language/updateTranslation/{id}', ['as' => 'language.update-translation','uses' => 'LanguageController@updateTranslation']);
	});

	Route::group(['middleware' => ['permission:manage-backup']], function() {
		Route::model('backup','\App\Backup');
		Route::post('/backup/lists','BackupController@lists');
		Route::resource('/backup', 'BackupController',['only' => ['index','show','store','destroy']]); 
	});

	Route::group(['middleware' => ['permission:manage-ip-filter']], function() {
		Route::model('ip_filter','\App\IpFilter');
		Route::post('/ip-filter/lists','IpFilterController@lists');
		Route::resource('/ip-filter', 'IpFilterController'); 
	});

	Route::group(['middleware' => ['permission:manage-custom-field']], function() {
		Route::model('custom_field','\App\CustomField');
		Route::post('/custom-field/lists','CustomFieldController@lists');
		Route::resource('/custom-field', 'CustomFieldController'); 
	});

	Route::group(['middleware' => ['permission:manage-role']], function() {
		Route::model('role','\App\Role');
		Route::post('/role/lists','RoleController@lists');
		Route::resource('/role', 'RoleController'); 
	});
		
	Route::group(['middleware' => ['permission:manage-permission']], function() {
		Route::model('permission','\App\Permission');
		Route::post('/permission/lists','PermissionController@lists');
		Route::resource('/permission', 'PermissionController'); 
		Route::get('/save-permission','PermissionController@permission');
		Route::post('/save-permission',array('as' => 'permission.save-permission','uses' => 'PermissionController@savePermission'));
	});
	
	Route::model('chat','\App\Chat');
	Route::resource('/chat', 'ChatController',['only' => 'store']); 
	Route::post('/fetch-chat','ChatController@index');

	Route::get('/lock','HomeController@lock');
	Route::post('/lock',array('as' => 'unlock','uses' => 'HomeController@unlock'));

	Route::group(['middleware' => ['feature_available:enable_activity_log']],function() {
		Route::get('/activity-log','HomeController@activityLog');
		Route::post('/activity-log/lists','HomeController@activityLogList');
	});

	/*----------
	| Entities routing
	*/

	//Country
    Route::model('country','\App\Country');
    Route::post('/country/lists', 'CountryController@lists');
    Route::resource('country', 'CountryController');
    Route::post('/country',array('as' => 'country.store','uses' => 'CountryController@create'));

	//Company
	Route::model('company','\App\Company');
    Route::patch('/company/update/{id}',array('as' => 'company.update', 'uses' => 'CompanyController@update'));
	Route::post('/company/lists','CompanyController@lists');
	Route::resource('company', 'CompanyController');
    Route::post('/company', array('as' => 'company.create','uses' => 'CompanyController@create'));

    //Location
	Route::model('location','\App\Location');
    Route::patch('/location/update/{id}',array('as' => 'location.update', 'uses' => 'LocationController@update'));
	Route::post('/location/lists','LocationController@lists');
	Route::resource('location', 'LocationController');
    Route::post('/location/create', 'LocationController@create');

    //Department
	Route::model('department','\App\Location');
    Route::patch('/department/update/{id}',array('as' => 'department.update', 'uses' => 'DepartmentController@update'));
	Route::post('/department/lists','DepartmentController@lists');
	Route::resource('department', 'DepartmentController');
    Route::post('/department', array('as' => 'department.create','uses' => 'DepartmentController@create'));


	Route::model('user','\App\User');
	Route::post('/user/lists','UserController@lists');
	Route::resource('/user', 'UserController',['except' => ['store','edit']]); 
	Route::post('/user/profile-update/{id}',array('as' => 'user.profile-update','uses' => 'UserController@profileUpdate'));
	Route::post('/user/social-update/{id}',array('as' => 'user.social-update','uses' => 'UserController@socialUpdate'));
	Route::post('/user/custom-field-update/{id}',array('as' => 'user.custom-field-update','uses' => 'UserController@customFieldUpdate'));
	Route::post('/user/avatar/{id}',array('as' => 'user.avatar','uses' => 'UserController@avatar'));
	Route::post('/change-user-status','UserController@changeStatus');
	Route::post('/force-change-user-password/{user_id}',array('as' => 'user.force-change-password','uses' => 'UserController@forceChangePassword'));
	Route::get('/change-password', 'UserController@changePassword');
	Route::post('/change-password',array('as'=>'change-password','uses' =>'UserController@doChangePassword'));
	Route::post('/user/email/{id}',array('as' => 'user.email', 'uses' => 'UserController@email'));
});