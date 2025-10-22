<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EngginerController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\testController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\CallingController;

use App\Http\Controllers\WorkController;

use App\Http\Controllers\LocationController;
use App\Http\Controllers\GeoapifyController;

Route::get('/geoapify', function () {
    return view('web.geoapify');
});

Route::post('/get-geoapify-location', [GeoapifyController::class, 'getCoordinates']);


Route::post('/send-email-otp', [OtpController::class, 'sendEmailOtp'])->name('send.email.otp');
Route::post('/verify-email-otp', [OtpController::class, 'verifyEmailOtp'])->name('verify.email.otp');



Route::get('/locations', [LocationController::class, 'index']);
Route::get('/get-regions/{state_id}', [LocationController::class, 'getRegions']);
Route::get('/get-cities/{region_id}', [LocationController::class, 'getCities']);
// Route::get('/get-regions/{state_id}', [LocationController::class, 'getRegions']);
Route::post('/get-cities-by-regions', [LocationController::class, 'getCitiesByRegions']);


Route::get('/dropdowns', [DropdownController::class, 'index']);
Route::get('/get-subtypes/{id}', [DropdownController::class, 'getSubtypes']);
// Route::get('/get-vendors/{id}', [DropdownController::class, 'getVendors']);
Route::post('/get-vendors', [DropdownController::class, 'getVendors'])->name('get.vendors');

Route::get('/get-sub-vendors/{id}', [DropdownController::class, 'getVendorssubcategories']);

// Route::get('/get-subtypes/{workTypeId}', [ProjectController::class, 'getSubtypes']);
Route::get('/get-vendors-id/{subtypeId}', [DropdownController::class, 'getVendors_id'])->name('get-vendors-id');
// Route::get('/get-sub-vendors/{vendorId}', [ProjectController::class, 'getSubVendors']);

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/test', [AdminController::class, 'test'])->name('test');

Route::get('/project', [ProjectController::class, 'project'])->name('project');
Route::get('/customer_basic_info', [ProjectController::class, 'customer_basic_info'])->name('customer_basic_info');

Route::get('/get-sub-categories', [ProjectController::class, 'getSubCategories']);
Route::get('/get-project-types', [ProjectController::class, 'getProjectTypes']);

// Route::post('/storeproject', [ProjectController::class, 'storeproject'])->name('storeproject');
Route::post('/submit-project', [ProjectController::class, 'storeproject'])->name('project.store');

Route::get('/project-details', [ProjectController::class, 'project_details'])->name('project_details');

Route::post('/project_details_save', [ProjectController::class, 'project_details_save'])->name('project_details_save');

Route::get('/customer_dashboard', [ProjectController::class, 'customer_dashboard'])->name('customer.dashboard');

Route::post('/submit-basicinfo', [ProjectController::class, 'storebasicinfo'])->name('customer.basicinfo.store');




Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/vendor', [VendorController::class, 'vendor'])->name('vendor');
Route::post('/registerServiceProvider', [VendorController::class, 'registerServiceProvider'])->name('registerServiceProvider');
Route::get('/types-of-agency', [VendorController::class, 'types_of_agency'])->name('types_of_agency');

Route::post('/save-agency-services', [VendorController::class, 'save_agency_services'])->name('save.agency.services');
Route::get('/about_business', [VendorController::class, 'about_business'])->name('about_business');
Route::get('/get-services/{agency_id}', [VendorController::class, 'getServices']);
Route::post('/business-store', [VendorController::class, 'business_store'])->name('business.store');
Route::get('/vendor_confiermetion', [VendorController::class, 'vendor_confiermetion'])->name('vendor_confiermetion');
Route::get('/vendor_likes_project', [VendorController::class, 'vendor_likes_project'])->name('vendor_likes_project');
Route::get('/vender/list-of-projects', [VendorController::class, 'showListPage'])->name('projects.list.page');
Route::get('/vendor_dashboard', [VendorController::class, 'vendor_dashboard'])->name('vendor_dashboard');

Route::get('/vender/projects-data', [VendorController::class, 'projectsData']);
Route::get('/vender/like-projects-data', [VendorController::class, 'likeprojectsData']);

Route::post('/proceed-vendor', [ProjectController::class, 'proceedVendor'])->name('proceed.vendor');

// Route::get('/customer/project/{id}', [ProjectController::class, 'viewProject'])->name('customer.project.view');
Route::get('/customer/project/{encryptedId}', [ProjectController::class, 'viewProject'])->name('customer.project.view');

Route::post('/customer/profile/update', [ProjectController::class, 'updateProfile'])
    ->name('customer.profile.update');

Route::post('/business/upload-file', [VendorController::class, 'uploadFile'])->name('business.uploadFile');
Route::get('/project-details-vendor/{id}', [VendorController::class, 'projectshow']);
Route::post('/project-likes', [VendorController::class, 'projectlikes']);
//  Route::post('/engineer/tender-documents', [VendorController::class, 'storeTenderDocuments']);
Route::post('/engineer/tender-documents', [VendorController::class, 'storeTenderDocuments'])
    ->name('engineer.tender.store');
Route::post('/engineer/tender-upload-file', [VendorController::class, 'uploadFiletenderdocuments'])
    ->name('engineer.tender.upload');
Route::get('/admin_dashboard', [AdminController::class, 'admin_dashboard'])->name('admin_dashboard');
Route::get('/contactus', [AdminController::class, 'contactus'])->name('contactus');
Route::post('/contact', [AdminController::class, 'contactus_submit'])->name('contact.submit');
Route::get('/vendor_approve_form', [AdminController::class, 'vender_approve_form'])->name('vender_approve_form');
Route::get('/vender_approve_data', [AdminController::class, 'vender_approve_data'])->name('vender_approve_data');
Route::get('/vender_reject_data', [AdminController::class, 'vender_reject_data'])->name('vender_reject_data');
Route::post('/admin/vendors/{id}/update-status', [VendorController::class, 'updateStatus'])->name('vendor.updateStatus');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/engineer_dashboard', [EngginerController::class, 'engineer_dashboard'])->name('engineer_dashboard');
Route::get('/All-New-Project', [EngginerController::class, 'allprojectdata'])->name('NewProject');

// Route::get('add-millstone', [EngginerController::class, 'addmillstone'])->name('addmillstone');
// Route::post('/engineer/milestones/save', [EngginerController::class, 'storemillstone'])->name('engineer.milestones.store');
// Route::get('/engineer/milestones/{projectId}', [EngginerController::class, 'getMilestones']);
Route::get('add-millstone', [EngginerController::class, 'addmillstone'])->name('addmillstone');
Route::post('/engineer/milestones/save', [EngginerController::class, 'storemillstone'])->name('engineer.milestones.store');
Route::get('/engineer/milestones/{projectId}', [EngginerController::class, 'getMilestones']);

Route::get('/engineer/milestones-list', [EngginerController::class, 'listMilestones'])->name('engineer.milestones.list');

// Route::get('/calling_dashboard', [CallingController::class, 'calling_dashboard'])->name('calling.dashboard');

// Route::get('/vendor-add', [CallingController::class, 'vendoradd'])->name('vendoradd');
// Route::get('/callingvendorlistadd', [CallingController::class, 'callingvendorlistadd'])->name('callingvendorlistadd');


Route::get('/callingvendorlistadd', [CallingController::class, 'index'])->name('callingvendorlistadd');
// Route::post('/vendors', [CallingController::class, 'store'])->name('vendors.store');
// Route::post('/vendors/{id}', [CallingController::class, 'update'])->name('vendors.update');
// Route::put('/vendors/{id}', [CallingController::class, 'update'])->name('vendors.update');

Route::get('/calling_dashboard', [CallingController::class, 'calling_dashboard'])->name('calling.dashboard');

Route::get('/vendor-add', [CallingController::class, 'index'])->name('vendoradd');

Route::post('/vendors', [CallingController::class, 'store'])->name('vendors.store');
Route::put('/vendors/{id}', [CallingController::class, 'update'])->name('vendors.update');



Route::post('/engineer/project/update-call-response', [EngginerController::class, 'updateCallResponse']);
Route::post('/quality', [EngginerController::class, 'quality'])->name('quality');

Route::post('/safety', [EngginerController::class, 'safety'])->name('safety');

Route::post('/hr', [EngginerController::class, 'hr'])->name('hr');
Route::post('/billing', [EngginerController::class, 'billing'])->name('billing');

Route::post('/engineer/project/update-remarks', [EngginerController::class, 'updateRemarks']);
       Route::get('/Add-New-Project-Boq', [EngginerController::class, 'NewProjectBoq'])->name('NewProjectBoq');
Route::post('/engineer/project/upload-boq', [EngginerController::class, 'uploadBOQ']);
//  Route::post('/engineer/project/tender', [EngginerController::class, 'storetender']);

Route::post('/engineer/project/tender', [EngginerController::class, 'storetender'])
    ->name('engineer.project.tender');

Route::get('/Vender-list', [EngginerController::class, 'get_all_vender_list'])->name('get_all_vender_list');

Route::post('/engineer/vendor/update-call-status', [EngginerController::class, 'updateVendorCallStatus'])
     ->name('engineer.vendor.updateCallStatus');

// routes/web.php or routes/api.php
Route::post('/send-email-otp', [OtpController::class, 'sendEmailOtp']);
Route::post('/verify-email-otp', [OtpController::class, 'verifyEmailOtp']);

Route::get('/get-service-areas', [AdminController::class, 'get_service_areas'])->name('get_service_areas');
Route::get('about_us', [AdminController::class, 'about_us'])->name('about_us');
Route::get('Privacy-Policy', [AdminController::class, 'privacy'])->name('privacy.policy');


Route::post('/send-otp', [OTPController::class, 'sendOtp']);
Route::post('/verify-otp', [OTPController::class, 'verifyOtp']);

Route::get('Verified-Partner-Bids', [ProjectController::class, 'Partner_Bids'])->name('Partner_Bids');

Route::get('/work/create', [WorkController::class, 'create'])->name('work.create');
Route::post('/work/store', [WorkController::class, 'store'])->name('work.store');

// Route::get('/get-subtypes/{typeId}', [WorkController::class, 'getSubtypes']);
// Route::get('/get-vendors/{subtypeId}', [WorkController::class, 'getVendors']);
Route::post('/vendor/follow-update', [VendorController::class, 'followUpdate'])->name('vendor.follow.update');


Route::get('/test-email', function () {
    Mail::raw('This is a test email via SendGrid SMTP', function ($message) {
        $message->to('pirplwebapp@gmail.com')
                ->subject('Laravel SendGrid Test');
    });

    return "✅ Test email sent! Check your inbox.";
});


Route::get('/vendor-agreement', [VendorController::class, 'vendor_terms_condition'])->name('vendor.agreement');

Route::get('/customer-agreement', [ProjectController::class, 'customer_agreement'])->name('customer.agreement');


Route::get('/make-hash', function () {
    // $password = "Applesmart@97";
     $password = "Civilworker123@";
    $hash = Hash::make($password);

    return $hash; 
});
// $2y$12$xiAUe2zbuD2cP9gkOtoYcuJsnOg.d0PdtprkuT7nWCbdpxS36/H8y