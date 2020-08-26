<?php

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
Route::group(['middleware' => ['pharmacyAuth']], function () {
    //Pharmacy
    //Route::post('/', 'backend\PharmacyController@myMedicineSale');
    Route::get('medicineSelfManagement', 'backend\PharmacyController@medicineSelfManagement');
    Route::get('searchMedicineBackend', 'backend\PharmacyController@searchMedicineBackend');
    Route::get('medicineSelfName', 'backend\PharmacyController@medicineSelfName');
    Route::post('insertMedicineSelf', 'backend\PharmacyController@insertMedicineSelf');
    Route::post('medicineSelfById', 'backend\PharmacyController@medicineSelfById');
    Route::post('deleteMedicineSelf', 'backend\PharmacyController@deleteMedicineSelf');
    Route::get('getAllMedicineSelf', 'backend\PharmacyController@getAllMedicineSelf');
    Route::get('getAllMedicineSelfa', 'backend\PharmacyController@getAllMedicineSelfa');
    Route::get('insertMedicineIntoSelf', 'backend\PharmacyController@insertMedicineIntoSelf');
    Route::get('searchMedicineByLetterBackend/{letter}', 'backend\PharmacyController@searchMedicineByLetterBackend');
    Route::get('myMedicineSelf', 'backend\PharmacyController@myMedicineSelf');
    Route::get('selectSelfById', 'backend\PharmacyController@selectSelfById');
    Route::get('medicineOrderManagement', 'backend\PharmacyController@medicineOrderManagement');
    Route::get('getAllMedicineCompany', 'backend\PharmacyController@getAllMedicineCompany');
    Route::get('selectMedicineByCompany', 'backend\PharmacyController@selectMedicineByCompany');
    Route::post('insertMedicineOrder', 'backend\PharmacyController@insertMedicineOrder');
    Route::get('myMedicineOrder', 'backend\PharmacyController@myMedicineOrder');
    Route::post('getMyMedicineOrderById', 'backend\PharmacyController@getMyMedicineOrderById');
    Route::post('getOrderListByDate', 'backend\PharmacyController@getOrderListByDate');
    Route::get('myMedicineSale', 'backend\PharmacyController@myMedicineSale');
    Route::post('insertMedicineSale', 'backend\PharmacyController@insertMedicineSale');
    Route::get('getAllMedicineBySelf', 'backend\PharmacyController@getAllMedicineBySelf');
    Route::get('myMedicineSalesReport', 'backend\PharmacyController@myMedicineSalesReport');
    Route::post('getSaleReportByDate', 'backend\PharmacyController@getSaleReportByDate');
});

Route::group(['middleware' => ['userAuth']], function () {

    if(Cookie::get('backRole') != null) {

//Division
            Route::get('/division', 'backend\AddressController@selectDivision');
            Route::post('/insertDivision', 'backend\AddressController@insertDivision');
            Route::post('getDivisionList', 'backend\AddressController@getDivisionList');
            Route::post('deleteDivision', 'backend\AddressController@deletetDivision');
//District
            Route::get('district', 'backend\AddressController@selectDistrict');
            Route::post('/insertDistrict', 'backend\AddressController@insertDistrict');
            Route::post('getDistrictList', 'backend\AddressController@getDistrictList');
            Route::post('deleteDistrict', 'backend\AddressController@deleteDistrict');
//Upzilla
            Route::get('upazilla', 'backend\AddressController@selectUpzilla');
            Route::post('insertUpazilla', 'backend\AddressController@insertUpazilla');
            Route::post('getUpazillaList', 'backend\AddressController@getUpazillaList');
            Route::post('deleteUpazilla', 'backend\AddressController@deleteUpazilla');
//union
            Route::get('union', 'backend\AddressController@selectUnion');
            Route::get('getUpazillaListAll', 'backend\AddressController@getUpazillaListAll');
            Route::post('insertUnion', 'backend\AddressController@insertUnion');
            Route::post('getUnionList', 'backend\AddressController@getUnionList');
            Route::post('deleteUnion', 'backend\AddressController@deleteUnion');
//Ward
            Route::get('ward', 'backend\AddressController@selectWard');
            Route::post('insertWard', 'backend\AddressController@insertWard');
            Route::post('getWardList', 'backend\AddressController@getWardList');
            Route::post('deleteWard', 'backend\AddressController@deleteWard');
//City
            Route::get('city', 'backend\AddressController@selectCity');
            Route::post('insertCity', 'backend\AddressController@insertCity');
            Route::post('getCityList', 'backend\AddressController@getCityList');
            Route::post('deleteCity', 'backend\AddressController@deleteCity');
//City-Corporation
            Route::get('city_corporation', 'backend\AddressController@selectCity_corporation');
            Route::post('getCityCorporationList', 'backend\AddressController@getCityCorporationList');
            Route::post('insertCitycorporation', 'backend\AddressController@insertCitycorporation');
            Route::post('deleteCityCorporation', 'backend\AddressController@deleteCityCorporation');
//Thana
            Route::get('thana', 'backend\AddressController@selectThana');
            Route::get('getCityCorporationListAll', 'backend\AddressController@getCityCorporationListAll');
            Route::post('insertThana', 'backend\AddressController@insertThana');
            Route::post('getThanaList', 'backend\AddressController@getThanaList');
            Route::post('deleteThana', 'backend\AddressController@deleteThana');
//City Ward
            Route::get('c_ward', 'backend\AddressController@selectC_ward');
            Route::post('insertC_Ward', 'backend\AddressController@insertC_Ward');
            Route::post('getC_WardList', 'backend\AddressController@getC_WardList');
            Route::post('deleteC_ward', 'backend\AddressController@deleteC_ward');
//User
            Route::get('user_type', 'backend\UserController@selectUser_type');
            Route::post('insertUserType', 'backend\UserController@insertUserType');
            Route::get('user', 'backend\UserController@selectUser');
            Route::get('getAllUserType', 'backend\UserController@getAllUserType');
            Route::post('insertUser', 'backend\UserController@insertUser');
            Route::post('getUserListByID', 'backend\UserController@getUserListByID');
            Route::post('deleteUser', 'backend\UserController@deleteUser');
            Route::get('about_us', 'backend\UserController@about_us');
            Route::post('insertAboutUs', 'backend\UserController@insertAboutUs');
            Route::post('getAboutUS', 'backend\UserController@getAboutUS');
            Route::get('contact_us ', 'backend\UserController@contact_us');
            Route::post('getContactUs ', 'backend\UserController@getContactUs');
            Route::get('getAllMedDept ', 'backend\UserController@getAllMedDept');
            Route::get('getHospitalListAll ', 'backend\UserController@getHospitalListAll');

//Login
            Route::get('dashboard', function () {
                return view('backend.dashboard');
            });
//Product & Service
            Route::get('category', 'backend\ProductController@selectCategory');
            Route::post('insertCategory', 'backend\ProductController@insertCategory');
            Route::post('getCategoryList', 'backend\ProductController@getCategoryList');
            Route::post('deleteCategory', 'backend\ProductController@deleteCategory');
            Route::get('subcategory', 'backend\ProductController@selectSubCategory');
            Route::get('getCategoryListAll', 'backend\ProductController@getCategoryListAll');
            Route::post('insertSubcategory', 'backend\ProductController@insertSubcategory');
            Route::post('getSubCategoryList', 'backend\ProductController@getSubCategoryList');
            Route::post('deleteSubCategory', 'backend\ProductController@deleteSubCategory');
            Route::get('product', 'backend\ProductController@selectProduct');
            Route::get('getAllCategory', 'backend\ProductController@getAllCategory');
            Route::get('getSubCategoryListAll', 'backend\ProductController@getSubCategoryListAll');
            Route::post('insertProducts', 'backend\ProductController@insertProducts');
            Route::post('getProductList', 'backend\ProductController@getProductList');
            Route::post('deleteProduct', 'backend\ProductController@deleteProduct');
            Route::get('delivery_charge', 'backend\ProductController@delivery_charge');
            Route::post('getDeliveryCharge', 'backend\ProductController@getDeliveryCharge');
            Route::post('insertDeliveryCharge', 'backend\ProductController@insertDeliveryCharge');
            Route::get('dealerProductManagement', 'backend\ProductController@dealerProductManagement');
            Route::post('changeProductPrice', 'backend\ProductController@changeProductPrice');
            Route::get('compareDealerProduct', 'backend\ProductController@compareDealerProduct');
            Route::get('allMedicineList', 'backend\ProductController@allMedicineList');
//Report
            Route::get('salesReport', 'backend\ReportController@salesReport');
            Route::get('animalSalesReport', 'backend\ReportController@animalSalesReport');
            Route::get('ticketSalesReport', 'backend\ReportController@ticketSalesReport');

            Route::get('login', function () {
                return view('backend.dashboard');
            });
            Route::get('/', function () {
                return view('backend.dashboard');
            });
//Transport Services
            Route::get('ticketRoute', 'backend\TransportController@ticketRoute');
            Route::get('getAllTransportList', 'backend\TransportController@getAllTransportList');
            Route::get('getTransportTypeList', 'backend\TransportController@getTransportTypeList');
            Route::post('insertTicketRoute', 'backend\TransportController@insertTicketRoute');
            Route::get('coachPage', 'backend\TransportController@coachPage');
            Route::post('insertCoach', 'backend\TransportController@insertCoach');
            Route::post('getCoachList', 'backend\TransportController@getCoachList');
            Route::post('deleteCoach', 'backend\TransportController@deleteCoach');
            Route::get('getCoachListById', 'backend\TransportController@getCoachListById');
            Route::post('getTicketRouteList', 'backend\TransportController@getTicketRouteList');
            Route::post('deleteTransportsTickets', 'backend\TransportController@deleteTransportsTickets');

//Medical Services
            Route::get('departmentList', 'backend\MedicalServiceController@departmentList');
            Route::post('insertMedDepartment', 'backend\MedicalServiceController@insertMedDepartment');
            Route::post('departmentLists', 'backend\MedicalServiceController@departmentLists');
            Route::post('deleteMedDepartment', 'backend\MedicalServiceController@deleteMedDepartment');
            Route::get('hospitalList', 'backend\MedicalServiceController@hospitalList');
            Route::get('getAllMedDepartment', 'backend\MedicalServiceController@getAllMedDepartment');
            Route::post('insertHospital', 'backend\MedicalServiceController@insertHospital');
            Route::post('hospitalListsById', 'backend\MedicalServiceController@hospitalListsById');
            Route::post('deleteHospital', 'backend\MedicalServiceController@deleteHospital');
            Route::get('doctorList', 'backend\MedicalServiceController@doctorList');
            Route::get('getHospitalListAll', 'backend\MedicalServiceController@getHospitalListAll');
            Route::get('privateChamberList', 'backend\MedicalServiceController@privateChamberList');
            Route::get('getDoctorListAll', 'backend\MedicalServiceController@getDoctorListAll');
            Route::post('insertPrivateChamber', 'backend\MedicalServiceController@insertPrivateChamber');
            Route::post('chamberListsById', 'backend\MedicalServiceController@chamberListsById');
            Route::post('deleteChamber', 'backend\MedicalServiceController@deleteChamber');
            Route::get('therapyServiceList', 'backend\MedicalServiceController@therapyServiceList');
            Route::post('insertTherapyService', 'backend\MedicalServiceController@insertTherapyService');
            Route::post('therapyListsById', 'backend\MedicalServiceController@therapyListsById');
            Route::post('deleteTherapyService', 'backend\MedicalServiceController@deleteTherapyService');
            Route::get('therapyCenterList', 'backend\MedicalServiceController@therapyCenterList');
            Route::post('insertTherapyCenter', 'backend\MedicalServiceController@insertTherapyCenter');
            Route::get('getAllTherapyServiceList', 'backend\MedicalServiceController@getAllTherapyServiceList');
            Route::post('therapyCenterListsById', 'backend\MedicalServiceController@therapyCenterListsById');
            Route::post('deleteTherapyCenter', 'backend\MedicalServiceController@deleteTherapyCenter');
            Route::get('therapyFees', 'backend\MedicalServiceController@therapyFees');
            Route::get('getTherapyCenterById', 'backend\MedicalServiceController@getTherapyCenterById');
            Route::post('insertTherapyFees', 'backend\MedicalServiceController@insertTherapyFees');
            Route::post('therapyFeesListsById', 'backend\MedicalServiceController@therapyFeesListsById');
            Route::post('deleteTherapyFees', 'backend\MedicalServiceController@deleteTherapyFees');
            Route::get('diagnosticTestList', 'backend\MedicalServiceController@diagnosticTestList');
            Route::post('insertDiagnosticTest', 'backend\MedicalServiceController@insertDiagnosticTest');
            Route::post('diagnosticListById', 'backend\MedicalServiceController@diagnosticListById');
            Route::post('deleteDiagnosticTest', 'backend\MedicalServiceController@deleteDiagnosticTest');
            Route::get('getAllDiagnosticTest', 'backend\MedicalServiceController@getAllDiagnosticTest');
            Route::get('diagnosticCenterList', 'backend\MedicalServiceController@diagnosticCenterList');
            Route::post('insertDiagnosticCenter', 'backend\MedicalServiceController@insertDiagnosticCenter');
            Route::post('diagnosticCenterListsById', 'backend\MedicalServiceController@diagnosticCenterListsById');
            Route::get('diagnosticFees', 'backend\MedicalServiceController@diagnosticFees');
            Route::get('getDiagnosticCenterById', 'backend\MedicalServiceController@getDiagnosticCenterById');
            Route::post('insertDiagnosticFees', 'backend\MedicalServiceController@insertDiagnosticFees');
            Route::post('diagnosticFeesListsById', 'backend\MedicalServiceController@diagnosticFeesListsById');
            Route::post('deleteDiagnosticFees', 'backend\MedicalServiceController@deleteDiagnosticFees');
            Route::get('doctorAppointmentReport', 'backend\MedicalServiceController@doctorAppointmentReport');
            Route::get('therapyAppointmentReport', 'backend\MedicalServiceController@therapyAppointmentReport');
            Route::get('diagnosticAppointmentReport', 'backend\MedicalServiceController@diagnosticAppointmentReport');
 //Pharmacy
            Route::get('medicineCompanyEmail', 'backend\PharmacyController@medicineCompanyEmail');
            Route::get('getAllMedicineCompany', 'backend\PharmacyController@getAllMedicineCompany');
            Route::post('insertMedicineCompanyEmail', 'backend\PharmacyController@insertMedicineCompanyEmail');
            Route::post('getMedicineCompanyEmailById', 'backend\PharmacyController@getMedicineCompanyEmailById');
            Route::post('deleteMedicineCompanyEmail', 'backend\PharmacyController@deleteMedicineCompanyEmail');

//Home Asistance Services
            Route::get('cookingPage', 'backend\HomeAssistantController@cookingPage');
            Route::post('insertCooking', 'backend\HomeAssistantController@insertCooking');
            Route::post('getCookingList', 'backend\HomeAssistantController@getCookingList');
            Route::post('deleteCooking', 'backend\HomeAssistantController@deleteCooking');
        }
});
//Login
    if(Cookie::get('frontRole') != null) {
        Route::get('login', 'frontend\AuthController@profile');
        Route::get('/', 'frontend\FrontController@homepageManager');
        Route::get('profile', 'frontend\AuthController@profile');
        Route::post('getUserList', 'backend\UserController@getUserList');
        Route::post('insertUser', 'backend\UserController@insertUser');
        Route::get('cart_view', 'frontend\FrontController@cart_view');
    }
    if(Cookie::get('frontRole') == null && Cookie::get('backRole') != null) {
        Route::get('login', function () {
            return view('frontend.login');
        });
    }
    if(Cookie::get('frontRole') == null && Cookie::get('backRole') == null) {
        Route::get('login', function () {
            return view('frontend.login');
        });
        Route::get('/', 'frontend\FrontController@homepageManager');
    }
//Signup
    Route::get('signup', function () {
        return view('frontend.signup');
    });
    Route::get('getAllUserTypeSignUp' , 'frontend\AuthController@getAllUserTypeSignUp');
    Route::post('insertNewUser' , 'frontend\AuthController@insertNewUser');
    Route::get('getAllDivision' , 'backend\AddressController@getAllDivision');
    Route::get('getDistrictListAll' , 'backend\AddressController@getDistrictListAll');
    Route::get('getUpazillaListAll' , 'backend\AddressController@getUpazillaListAll');
    Route::get('getUnionListAll' , 'backend\AddressController@getUnionListAll');
    Route::get('getWardListAll' , 'backend\UserController@getWardListAll');
    Route::get('getCityListAll' , 'backend\AddressController@getCityListAll');
    Route::get('getCityCorporationListAll' , 'backend\AddressController@getCityCorporationListAll');
    Route::get('getThanaListAll' , 'backend\AddressController@getThanaListAll');
    Route::get('getC_wardListAll' , 'backend\UserController@getC_wardListAll');
    Route::post('verifyUser' , 'frontend\AuthController@verifyUsers');
//FrontRoute
    Route::get('homepage' , 'frontend\FrontController@homepageManager');
    Route::get('logout' , 'frontend\AuthController@logout');
    Route::get('product/{id}', 'frontend\FrontController@getProductByCatId');
    Route::post('product/getProductMiqty', 'frontend\FrontController@getProductMiqty');
    Route::get('cart_view', 'frontend\FrontController@cart_view');
    Route::post('product/cart_add', 'frontend\FrontController@cart_add');
    Route::post('product/cart_fetch', 'frontend\FrontController@cart_fetch');
    Route::post('product/cart_details', 'frontend\FrontController@cart_details');
    Route::post('product/cart_delete', 'frontend\FrontController@cart_delete');
    Route::post('product/cart_delete', 'frontend\FrontController@cart_delete');
    Route::get('sales/{id}', 'frontend\FrontController@sales');
    Route::post('transaction', 'frontend\AuthController@transaction');
    Route::post('insertContactUs', 'backend\UserController@insertContactUs');
    Route::get('buySale/{id}', 'frontend\FrontController@buySale');
    Route::get('getAllSaleCategory', 'frontend\FrontController@getAllSaleCategory');
    Route::post('insertSaleProduct', 'frontend\FrontController@insertSaleProduct');
    Route::post('getSaleProductsDetails', 'frontend\FrontController@getSaleProductsDetails');
    Route::get('animalSaleView/{id}', 'frontend\FrontController@animalSaleView');
    Route::get('animalSales/{id}', 'frontend\FrontController@animalSales');
    Route::get('searchProduct', 'frontend\FrontController@searchProduct');
    Route::post('deliveryAddress', 'frontend\FrontController@deliveryAddress');
    Route::get('serviceCategory', 'frontend\FrontController@serviceCategory');
    Route::get('service_sub_category/{id}', 'frontend\FrontController@service_sub_category');
    Route::get('transportService', 'frontend\TransportController@transportService');
    Route::get('getAllFromAddressById', 'frontend\TransportController@getAllFromAddressById');
    Route::get('getAllToAddress', 'frontend\TransportController@getAllToAddress');
    Route::get('getAllTransport', 'frontend\TransportController@getAllTransport');
    Route::get('getAllTransportType', 'frontend\TransportController@getAllTransportType');
    Route::get('getAllTransportTime', 'frontend\TransportController@getAllTransportTime');
    Route::post('insertTransport', 'frontend\TransportController@insertTransport');
    Route::get('getTransportPrice', 'frontend\TransportController@getTransportPrice');
    Route::get('searchMedicine', 'frontend\FrontController@searchMedicine');
    Route::get('searchMedicineByLetter/{letter}', 'frontend\FrontController@searchMedicineByLetter');
    //Route::get('price', 'frontend\TransportController@price');
    Route::get('serviceSubCategoryMedical/{id}', 'frontend\FrontController@serviceSubCategoryMedical');
    Route::get('doctorAppointmentForm', 'frontend\MedicalServiceController@doctorAppointmentForm');
    Route::get('getDepartmentListAllFromDap', 'frontend\MedicalServiceController@getDepartmentListAllFromDap');
    Route::get('getAllMedDepartmentFront', 'backend\MedicalServiceController@getAllMedDepartment');
    Route::post('searchDoctorListFront', 'frontend\MedicalServiceController@searchDoctorListFront');
    Route::get('doctorProfileFront/{id}', 'frontend\MedicalServiceController@doctorProfileFront');
    Route::post('insertAppointment', 'frontend\MedicalServiceController@insertAppointment');
    Route::get('therapyServiceForm', 'frontend\MedicalServiceController@therapyServiceForm');
    Route::get('getAllTherapyServiceListFront', 'backend\MedicalServiceController@getAllTherapyServiceList');
    Route::post('searchTherapyListFront', 'frontend\MedicalServiceController@searchTherapyListFront');
    Route::get('therapyAppointmentForm/{id}', 'frontend\MedicalServiceController@therapyAppointmentForm');
    Route::post('insertTherapyAppointment', 'frontend\MedicalServiceController@insertTherapyAppointment');
    Route::get('diagnosticBookingForm', 'frontend\MedicalServiceController@diagnosticBookingForm');
    Route::get('getAllDiagnosticTest', 'backend\MedicalServiceController@getAllDiagnosticTest');
    Route::post('searchDiagnosticListFront', 'frontend\MedicalServiceController@searchDiagnosticListFront');
    Route::get('diagnosticAppointmentForm/{id}', 'frontend\MedicalServiceController@diagnosticAppointmentForm');
    Route::post('insertDiagnosticAppointment', 'frontend\MedicalServiceController@insertDiagnosticAppointment');
    Route::get('changeWorkingStatus', 'frontend\FrontController@changeWorkingStatus');
    Route::get('getAllMedDept ', 'backend\UserController@getAllMedDept');
    Route::get('getHospitalListAll ', 'backend\UserController@getHospitalListAll');
