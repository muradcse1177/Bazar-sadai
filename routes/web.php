<?php

use Illuminate\Support\Facades\Artisan;
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
Route::group(['middleware' => ['adminUser']], function () {
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
//Naming1
    Route::get('naming1', 'backend\AddressController@naming1');
    Route::post('insertNaming1', 'backend\AddressController@insertNaming1');
    Route::post('getNaming1List', 'backend\AddressController@getNaming1List');
    Route::post('deleteNaming1', 'backend\AddressController@deleteNaming1');
//Naming2
    Route::get('naming2', 'backend\AddressController@naming2');
    Route::get('getAllNaming1', 'backend\AddressController@getAllNaming1');
    Route::post('insertNaming2', 'backend\AddressController@insertNaming2');
    Route::post('getNaming2List', 'backend\AddressController@getNaming2List');
    Route::post('deleteNaming2', 'backend\AddressController@deleteNaming2');
//Naming3
    Route::get('naming3', 'backend\AddressController@naming3');
    Route::post('insertNaming3', 'backend\AddressController@insertNaming3');
    Route::get('getNaming2ListAll', 'backend\AddressController@getNaming2ListAll');
    Route::post('getNaming3List', 'backend\AddressController@getNaming3List');
    Route::post('deleteNaming3', 'backend\AddressController@deleteNaming3');
//Naming4
    Route::get('naming4', 'backend\AddressController@naming4');
    Route::get('getNaming3ListAll', 'backend\AddressController@getNaming3ListAll');
    Route::post('insertNaming4', 'backend\AddressController@insertNaming4');
    Route::post('getNaming4List', 'backend\AddressController@getNaming4List');
    Route::post('deleteNaming4', 'backend\AddressController@deleteNaming4');
//Naming5
    Route::get('naming5', 'backend\AddressController@naming5');
    Route::get('getNaming4ListAll', 'backend\AddressController@getNaming4ListAll');
    Route::post('insertNaming5', 'backend\AddressController@insertNaming5');
    Route::post('getNaming5List', 'backend\AddressController@getNaming5List');
    Route::post('deleteNaming5', 'backend\AddressController@deleteNaming5');
//User
    Route::get('user_type', 'backend\UserController@selectUser_type');
    Route::post('insertUserType', 'backend\UserController@insertUserType');
    Route::get('user', 'backend\UserController@selectUser');
    Route::post('selectUserFromUserPanel', 'backend\UserController@selectUserFromUserPanel');
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
    Route::get('dashboard ', 'backend\UserController@dashboard');
//Product & Service
    Route::get('mainSlide', 'backend\ProductController@mainSlide');
    Route::post('insertMainSlide', 'backend\ProductController@insertMainSlide');
    Route::post('getMainSlideById', 'backend\ProductController@getMainSlideById');
    Route::post('deleteSlideList', 'backend\ProductController@deleteSlideList');
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
    Route::get('productSearchFromAdmin', 'backend\ProductController@productSearchFromAdmin');
    Route::get('medicineSearchFromAdmin', 'backend\ProductController@medicineSearchFromAdmin');
    Route::get('getAllCategory', 'backend\ProductController@getAllCategory');
    Route::get('getSubCategoryListAll', 'backend\ProductController@getSubCategoryListAll');
    Route::post('insertProducts', 'backend\ProductController@insertProducts');
    Route::post('getProductList', 'backend\ProductController@getProductList');
    Route::post('deleteProduct', 'backend\ProductController@deleteProduct');
    Route::get('delivery_charge', 'backend\ProductController@delivery_charge');
    Route::post('getDeliveryCharge', 'backend\ProductController@getDeliveryCharge');
    Route::post('insertDeliveryCharge', 'backend\ProductController@insertDeliveryCharge');
    Route::get('allMedicineList', 'backend\ProductController@allMedicineList');
    Route::get('medicineSearchFromAdmin', 'backend\ProductController@medicineSearchFromAdmin');
    Route::post('getProductSalesOrderListByDate', 'backend\ReportController@getProductSalesOrderListByDate');
//Report
    Route::get('salesReport', 'backend\ReportController@salesReport');
    Route::get('animalSalesReport', 'backend\ReportController@animalSalesReport');
    Route::get('productur', 'backend\ReportController@productur');
    Route::post('approvalChange', 'backend\ReportController@approvalChange');
    Route::post('getSellerProductsByIdAdmin', 'backend\SellerController@getSellerProductsByIdAdmin');
    Route::post('deleteSellerUploadProduct', 'backend\SellerController@deleteSellerUploadProduct');
    Route::post('getAnimalSalesOrderListByDate', 'backend\ReportController@getAnimalSalesOrderListByDate');
    Route::get('ticketSalesReport', 'backend\ReportController@ticketSalesReport');
    Route::post('getTicketSalesOrderListByDate', 'backend\ReportController@getTicketSalesOrderListByDate');
    Route::get('doctorAppointmentReport', 'backend\ReportController@doctorAppointmentReport');
    Route::post('getDrAppOrderListByDate', 'backend\ReportController@getDrAppOrderListByDate');
    Route::get('therapyAppointmentReport', 'backend\ReportController@therapyAppointmentReport');
    Route::post('getTherapyAppOrderListByDate', 'backend\ReportController@getTherapyAppOrderListByDate');
    Route::get('diagnosticAppointmentReport', 'backend\ReportController@diagnosticAppointmentReport');
    Route::post('getDiagAppOrderListByDate', 'backend\ReportController@getDiagAppOrderListByDate');
    Route::get('medicineOrderReportAdmin', 'backend\PharmacyController@medicineOrderReportAdmin');
    Route::get('donationReportBackend', 'backend\ReportController@donationReportBackend');
    Route::post('donationListByDate', 'backend\ReportController@donationListByDate');
    Route::get('transportReportAdmin', 'backend\ReportController@transportReportAdmin');
    Route::post('transportListByDate', 'backend\ReportController@transportListByDate');
    Route::get('courierReport', 'backend\ReportController@courierReport');
    Route::post('courierListByDate', 'backend\ReportController@courierListByDate');
    Route::get('cookingReport', 'backend\ReportController@cookingReport');
    Route::post('cookingReportListByDate', 'backend\ReportController@cookingReportListByDate');
    Route::get('clothWashingReport', 'backend\ReportController@clothWashingReport');
    Route::post('getClothWashingById', 'backend\ReportController@getClothWashingById');
    Route::post('clothWashingReportListByDate', 'backend\ReportController@clothWashingReportListByDate');
    Route::get('roomCleaningReport', 'backend\ReportController@roomCleaningReport');
    Route::post('cleaningReportListByDate', 'backend\ReportController@cleaningReportListByDate');
    Route::get('helpingHandReport', 'backend\ReportController@helpingHandReport');
    Route::post('helpingHandReportListByDate', 'backend\ReportController@helpingHandReportListByDate');
    Route::get('guardReport', 'backend\ReportController@guardReport');
    Route::post('guardReportListByDate', 'backend\ReportController@guardReportListByDate');
    Route::get('variousServicingReport', 'backend\ReportController@variousServicingReport');
    Route::get('laundryReport', 'backend\ReportController@laundryReport');
    Route::post('getLaundryWashingById', 'backend\ReportController@getLaundryWashingById');
    Route::post('laundryReportListByDate', 'backend\ReportController@laundryReportListByDate');
    Route::get('parlorReport', 'backend\ReportController@parlorReport');
    Route::post('parlorReportListByDate', 'backend\ReportController@parlorReportListByDate');
    Route::get('dealerProductAdmin', 'backend\DealerController@dealerProductAdmin');
    Route::get('getAllDealerAdmin', 'backend\DealerController@getAllDealerAdmin');
    Route::post('searchDealerProductsAdmin', 'backend\DealerController@searchDealerProductsAdmin');
    Route::post('changeCourierStatusAdmin', 'backend\CourierController@changeCourierStatus');
    Route::post('changeCourierMessageAdmin', 'backend\CourierController@changeCourierMessage');
    Route::get('getCourierMessageAdmin', 'backend\CourierController@getCourierMessageAdmin');
    Route::get('toursNTravelsReport', 'backend\ReportController@toursNTravelsReport');
    Route::post('toursNTravelsReportListByDate', 'backend\ReportController@toursNTravelsReportListByDate');
//Accounting
    Route::get('accounting', 'backend\ReportController@accounting');
    Route::post('insertAccounting', 'backend\ReportController@insertAccounting');
    Route::post('getAccountingReportByDate', 'backend\ReportController@getAccountingReportByDate');
    Route::post('getAccountingListById', 'backend\ReportController@getAccountingListById');

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
    Route::get('transportCost', 'backend\TransportController@transportCost');
    Route::post('insertTransportCost', 'backend\TransportController@insertTransportCost');
    Route::post('getTransportCostList', 'backend\TransportController@getTransportCostList');
    Route::post('deleteTransportCost', 'backend\TransportController@deleteTransportCost');

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
    Route::get('medicalCampBack', 'backend\MedicalServiceController@medicalCampBack');
    Route::post('insertMedicalCamp', 'backend\MedicalServiceController@insertMedicalCamp');
    Route::post('getMedicalCampList', 'backend\MedicalServiceController@getMedicalCampList');
    Route::post('deleteMedicalCamp', 'backend\MedicalServiceController@deleteMedicalCamp');
//Pharmacy
    Route::get('medicineCompanyEmail', 'backend\PharmacyController@medicineCompanyEmail');
    //Route::get('getAllMedicineCompany', 'backend\PharmacyController@getAllMedicineCompany');
    Route::post('insertMedicineCompanyEmail', 'backend\PharmacyController@insertMedicineCompanyEmail');
    Route::post('getMedicineCompanyEmailById', 'backend\PharmacyController@getMedicineCompanyEmailById');
    Route::post('deleteMedicineCompanyEmail', 'backend\PharmacyController@deleteMedicineCompanyEmail');
    Route::post('getAdminMedicineOrderById', 'backend\PharmacyController@getAdminMedicineOrderById');
    Route::post('getOrderListByDateAdmin', 'backend\PharmacyController@getOrderListByDateAdmin');

//Home Asistance Services
    //Cooking
    Route::get('cookingPage', 'backend\HomeAssistantController@cookingPage');
    Route::post('insertCooking', 'backend\HomeAssistantController@insertCooking');
    Route::post('getCookingList', 'backend\HomeAssistantController@getCookingList');
    Route::post('deleteCooking', 'backend\HomeAssistantController@deleteCooking');

    //Parlour
    Route::get('parlorService', 'backend\HomeAssistantController@parlorService');
    Route::get('getAllParlorType', 'backend\HomeAssistantController@getAllParlorType');
    Route::post('insertParlourService', 'backend\HomeAssistantController@insertParlourService');
    Route::post('getParlorServiceById', 'backend\HomeAssistantController@getParlorServiceById');
    Route::post('deleteParlorService', 'backend\HomeAssistantController@deleteParlorService');
    //ClothWashing
    Route::get('clothWashing', 'backend\HomeAssistantController@clothWashing');
    Route::post('insertCloth', 'backend\HomeAssistantController@insertCloth');
    Route::post('getClothById', 'backend\HomeAssistantController@getClothById');
    Route::post('deleteCloth', 'backend\HomeAssistantController@deleteCloth');
    Route::post('roomCleaning', 'backend\HomeAssistantController@roomCleaning');
    //Room Cleaning
    Route::get('roomCleaning', 'backend\HomeAssistantController@roomCleaning');
    Route::post('insertRoomCleaning', 'backend\HomeAssistantController@insertRoomCleaning');
    Route::post('getRoomCleaningById', 'backend\HomeAssistantController@getRoomCleaningById');
    Route::post('deleteRoomCleaning', 'backend\HomeAssistantController@deleteRoomCleaning');
    //Child care & Helping Hand
    Route::get('childCaring', 'backend\HomeAssistantController@childCaring');
    Route::post('insertChildCaring', 'backend\HomeAssistantController@insertChildCaring');
    Route::post('getChildCaringById', 'backend\HomeAssistantController@getChildCaringById');
    Route::post('deleteChildCaring', 'backend\HomeAssistantController@deleteChildCaring');
    //GuardList
    Route::get('guardSetting', 'backend\HomeAssistantController@guardSetting');
    Route::post('insertGuardSetting', 'backend\HomeAssistantController@insertGuardSetting');
    Route::post('getGuardSettingById', 'backend\HomeAssistantController@getGuardSettingById');
    Route::post('deleteGuardSetting', 'backend\HomeAssistantController@deleteGuardSetting');
    //Various Servicing
    Route::get('variousServicing', 'backend\HomeAssistantController@variousServicing');
    Route::post('insertVariousServicing', 'backend\HomeAssistantController@insertVariousServicing');
    Route::post('getVariousServiceById', 'backend\HomeAssistantController@getVariousServiceById');
    Route::post('deleteVariousService', 'backend\HomeAssistantController@deleteVariousService');
    //Laundry
    Route::get('laundryService', 'backend\HomeAssistantController@laundryService');
    Route::post('insertLaundry', 'backend\HomeAssistantController@insertLaundry');
    Route::post('getLaundryById', 'backend\HomeAssistantController@getLaundryById');
    Route::post('deleteLaundry', 'backend\HomeAssistantController@deleteLaundry');
    //courier
    Route::get('courierType', 'backend\TransportController@courierType');
    Route::post('insertCourierType', 'backend\TransportController@insertCourierType');
    Route::post('getCourierTypeList', 'backend\TransportController@getCourierTypeList');
    Route::post('deleteCourierType', 'backend\TransportController@deleteCourierType');
    Route::get('courierSettings', 'backend\TransportController@courierSettings');
    Route::get('getAllCourierType', 'backend\TransportController@getAllCourierType');
    Route::get('getAllNaming1Country', 'backend\TransportController@getAllNaming1Country');
    Route::post('insertCourierSettings', 'backend\TransportController@insertCourierSettings');
    Route::post('getCourierSettingList', 'backend\TransportController@getCourierSettingList');
    Route::post('deleteCourierSetting', 'backend\TransportController@deleteCourierSetting');
    // Tours & Travels
    Route::get('bookingMainAddress', 'backend\ToursController@bookingMainAddress');
    Route::post('insertMainAddress', 'backend\ToursController@insertMainAddress');
    Route::post('getTourAddressListById', 'backend\ToursController@getTourAddressListById');
    Route::post('deleteTourAddress', 'backend\ToursController@deleteTourAddress');
    Route::get('bookingTourAll1', 'backend\ToursController@bookingTourAll1');
    Route::get('getMainPlaceListAll', 'backend\ToursController@getMainPlaceListAll');
    Route::post('insertTourBooking1', 'backend\ToursController@insertTourBooking1');
    Route::post('getTourMainListById', 'backend\ToursController@getTourMainListById');
    Route::post('deleteTourMainList', 'backend\ToursController@deleteTourMainList');
    Route::get('bookingTourAll2', 'backend\ToursController@bookingTourAll2');
    Route::post('bookingTourAll2', 'backend\ToursController@bookingTourAll2');
    Route::get('getAllToursNameList', 'backend\ToursController@getAllToursNameList');
    Route::post('insertTourBooking2', 'backend\ToursController@insertTourBooking2');
    Route::post('getTourBooking2ListById', 'backend\ToursController@getTourBooking2ListById');
    Route::post('deleteTourBookingList', 'backend\ToursController@deleteTourBookingList');
});
Route::group(['middleware' => ['buyer']], function () {
    Route::get('profile', 'frontend\AuthController@profile');
    Route::post('getUserListByIdProfile', 'backend\UserController@getUserListByID');
    Route::get('myProductOrder', 'backend\UserController@myProductOrder');
    Route::get('myVariousProductOrderUser', 'backend\UserController@myVariousProductOrderUser');
    Route::get('myAnimalOrder', 'backend\UserController@myAnimalOrder');
    Route::get('myTicketOrder', 'backend\UserController@myTicketOrder');
    Route::get('myDrAppointment', 'backend\UserController@myDrAppointment');
    Route::get('myTherapyAppointment', 'backend\UserController@myTherapyAppointment');
    Route::get('myDiagnosticAppointment', 'backend\UserController@myDiagnosticAppointment');
    Route::get('myTransportOrder', 'backend\UserController@myTransportOrder');
    Route::get('myCookingOrder', 'backend\UserController@myCookingOrder');
    Route::get('myClothWashingOrder', 'backend\UserController@myClothWashingOrder');
    Route::post('getClothWashingByIdUser', 'backend\UserController@getClothWashingByIdUser');
    Route::get('myRoomCleaningOrder', 'backend\UserController@myRoomCleaningOrder');
    Route::get('myHelpingHandOrder', 'backend\UserController@myHelpingHandOrder');
    Route::get('myGuardOrder', 'backend\UserController@myGuardOrder');
    Route::get('myProductServicingOrder', 'backend\UserController@myProductServicingOrder');
    Route::get('myLaundryOrder', 'backend\UserController@myLaundryOrder');
    Route::post('getLaundryWashingByIdUser', 'backend\UserController@getLaundryWashingByIdUser');
    Route::get('myParlorOrder', 'backend\UserController@myParlorOrder');
    Route::get('myCourierOrder', 'backend\UserController@myCourierOrder');
    Route::get('getCourierMessageBuyer', 'backend\CourierController@getCourierMessageAdmin');
    Route::get('myToursNTravels', 'backend\UserController@myToursNTravelsOrder');
});
Route::group(['middleware' => ['deliveryMan']], function () {
    Route::get('deliveryProfile', 'backend\UserController@deliveryProfile');
});
Route::group(['middleware' => ['seller']], function () {
    Route::get('sellerForm', 'backend\SellerController@sellerForm');
    Route::post('getSellerProductsById', 'backend\SellerController@getSellerProductsById');
    Route::post('deleteSellerProduct', 'backend\SellerController@deleteSellerProduct');
    Route::get('mySaleProduct', 'backend\SellerController@mySaleProduct');
});
Route::post('insertSellerProduct', 'backend\SellerController@insertSellerProduct');
Route::group(['middleware' => ['dealer']], function () {
    Route::get('dealerProfile', 'backend\DealerController@dealerProfile');
    Route::post('changeProductPrice', 'backend\DealerController@changeProductPrice');
    Route::post('getProductListDealer', 'backend\DealerController@getProductListDealer');
    Route::post('getProductListDealer', 'backend\DealerController@getProductListDealer');
    Route::get('productSearchFromDealer', 'backend\DealerController@productSearchFromDealer');
    Route::get('mySaleProductDealer', 'backend\DealerController@mySaleProductDealer');
    Route::post('getDealerProductSalesOrderListByDate', 'backend\DealerController@getDealerProductSalesOrderListByDate');

});
Route::group(['middleware' => ['rider']], function () {
    Route::get('riderServiceArea', 'backend\RiderController@riderServiceArea');
    Route::get('myRiding', 'backend\RiderController@myRiding');
    Route::post('myRidingListByDate', 'backend\RiderController@myRidingListByDate');
    Route::post('insertRiderServiceArea', 'backend\RiderController@insertRiderServiceArea');
    Route::post('setRiderDistance', 'backend\RiderController@setRiderDistance');
});
Route::group(['middleware' => ['doctor']], function () {
    Route::get('doctorServiceArea', 'backend\DoctorController@doctorServiceArea');
    Route::post('insertDoctorServiceArea', 'backend\DoctorController@insertDoctorServiceArea');
    Route::get('myPatientList', 'backend\DoctorController@myPatientList');
    Route::post('myPatientListByDate', 'backend\DoctorController@myPatientListByDate');
    Route::get('changeLocalDoctorStatus', 'backend\DoctorController@changeLocalDoctorStatus');
});

Route::group(['middleware' => ['cooker']], function () {
    Route::get('cookerProfile', 'backend\CookerController@cookerProfile');
});
Route::group(['middleware' => ['clothCleaner']], function () {
    Route::get('clothCleanerProfile', 'backend\ClothCleanerController@clothCleanerProfile');
    Route::post('getClothWashingByIdOwn', 'backend\ClothCleanerController@getClothWashingByIdOwn');
});
Route::group(['middleware' => ['roomCleaner']], function () {
    Route::get('roomCleanerProfile', 'backend\RoomCleanerController@roomCleanerProfile');
});
Route::group(['middleware' => ['tankCleaner']], function () {
    Route::get('tankCleanerProfile', 'backend\TankCleanerController@tankCleanerProfile');
});
Route::group(['middleware' => ['helpingHand']], function () {
    Route::get('helpingHandProfile', 'backend\HelpingHandController@helpingHandProfile');
});
Route::group(['middleware' => ['guard']], function () {
    Route::get('guardProfile', 'backend\GuardController@guardProfile');
});
Route::group(['middleware' => ['stove']], function () {
    Route::get('stoveProfile', 'backend\StoveController@stoveProfile');
});
Route::group(['middleware' => ['electronics']], function () {
    Route::get('electronicsProfile', 'backend\ElectronicsController@electronicsProfile');
});
Route::group(['middleware' => ['sanitary']], function () {
    Route::get('sanitaryProfile', 'backend\SanitaryController@sanitaryProfile');
});
Route::group(['middleware' => ['ac']], function () {
    Route::get('acProfile', 'backend\AcController@acProfile');
});
Route::group(['middleware' => ['parlor']], function () {
    Route::get('parlorProfile', 'backend\ParlorController@parlorProfile');
});
Route::group(['middleware' => ['laundry']], function () {
    Route::get('laundryProfile', 'backend\LaundryController@laundryProfile');
    Route::post('getLaundryWashingByIdOwn', 'backend\LaundryController@getLaundryWashingByIdOwn');
});
Route::group(['middleware' => ['courier']], function () {
    Route::get('courierProfile', 'backend\CourierController@courierProfile');
    Route::post('changeCourierStatus', 'backend\CourierController@changeCourierStatus');
    Route::post('changeCourierMessage', 'backend\CourierController@changeCourierMessage');
    Route::get('getCourierMessage', 'backend\CourierController@getCourierMessageAdmin');
});
Route::group(['middleware' => ['tnt']], function () {
    Route::get('tntProfile', 'backend\ToursController@tntProfile');
    Route::get('bookingTourAllAgent1', 'backend\ToursController@bookingTourAllAgent1');
    Route::get('getMainPlaceListAllAgent', 'backend\ToursController@getMainPlaceListAllAgent');
    Route::post('insertTourBooking1Agent', 'backend\ToursController@insertTourBooking1Agent');
    Route::post('getTourMainListByIdAgent', 'backend\ToursController@getTourMainListByIdAgent');
    Route::post('deleteTourMainListAgent', 'backend\ToursController@deleteTourMainListAgent');
    Route::get('bookingTourAllAgent2', 'backend\ToursController@bookingTourAllAgent2');
    Route::get('getAllToursNameListAgent', 'backend\ToursController@getAllToursNameListAgent');
    Route::post('insertTourBooking2Agent', 'backend\ToursController@insertTourBooking2Agent');
    Route::post('getTourBooking2ListByIdAgent', 'backend\ToursController@getTourBooking2ListByIdAgent');
    Route::post('deleteTourBookingListAgent', 'backend\ToursController@deleteTourBookingListAgent');

});
    Route::get('/clear-cache', function() {
        $exitCode = Artisan::call('cache:clear');
        // return what you want
    });
    //Signup
    Route::get('signup', function () {
        return view('frontend.signup');
    });
    if(Cookie::get('buyer') != null){
        Route::get('/', 'frontend\FrontController@homepageManager');
    }
    elseif(Cookie::get('admin') != null){
        Route::get('/', 'backend\UserController@dashboard');
    }
    elseif(Cookie::get('pharmacy') != null){
        Route::get('/', 'backend\PharmacyController@myMedicineSale');
    }
    elseif(Cookie::get('pharmacy') != null){
        Route::get('/', 'backend\PharmacyController@myMedicineSale');
    }
    elseif(Cookie::get('delivery') != null){
        Route::get('/', 'backend\UserController@deliveryProfile');
    }
    elseif(Cookie::get('seller') != null){
        Route::get('/', 'backend\SellerController@sellerForm');
    }
    elseif(Cookie::get('dealer') != null){
        Route::get('/', 'backend\DealerController@mySaleProductDealer');
    }
    elseif(Cookie::get('rider') != null){
        Route::get('/', 'backend\RiderController@riderServiceArea');
    }
    elseif(Cookie::get('doctor') != null){
        Route::get('/', 'backend\DoctorController@doctorServiceArea');
    }
    elseif(Cookie::get('cooker') != null){
        Route::get('/', 'backend\CookerController@cookerProfile');
    }
    elseif(Cookie::get('clothCleaner') != null){
        Route::get('/', 'backend\ClothCleanerController@clothCleanerProfile');
    }
    elseif(Cookie::get('roomCleaner') != null){
        Route::get('/', 'backend\RoomCleanerController@roomCleanerProfile');
    }
    elseif(Cookie::get('tankCleaner') != null){
        Route::get('/', 'backend\TankCleanerController@tankCleanerProfile');
    }
    elseif(Cookie::get('helpingHand') != null){
        Route::get('/', 'backend\HelpingHandController@helpingHandProfile');
    }
    elseif(Cookie::get('guard') != null){
        Route::get('/', 'backend\GuardController@guardProfile');
    }
    elseif(Cookie::get('stove') != null){
        Route::get('/', 'backend\StoveController@stoveProfile');
    }
    elseif(Cookie::get('electronics') != null){
        Route::get('/', 'backend\ElectronicsController@electronicsProfile');
    }
    elseif(Cookie::get('sanitary') != null){
        Route::get('/', 'backend\SanitaryController@sanitaryProfile');
    }
    elseif(Cookie::get('ac') != null){
        Route::get('/', 'backend\AcController@acProfile');
    }
    elseif(Cookie::get('parlor') != null){
        Route::get('/', 'backend\ParlorController@parlorProfile');
    }
    elseif(Cookie::get('laundry') != null){
        Route::get('/', 'backend\LaundryController@laundryProfile');
    }
    elseif(Cookie::get('courier') != null){
        Route::get('/', 'backend\CourierController@courierProfile');
    }
    elseif(Cookie::get('tnt') != null){
        Route::get('/', 'backend\ToursController@tntProfile');
    }
    else{
        Route::get('/', 'frontend\FrontController@homepageManager');
    }
    Route::get('login', function () {
        return view('frontend.login');
    });
    //Forgot Password
    Route::get('forgotPasswordLink', 'frontend\AuthController@forgotPasswordLink');
    Route::post('verifyEmail', 'frontend\AuthController@verifyEmail');
    Route::post('verifyForgetCode', 'frontend\AuthController@verifyForgetCode');
    Route::post('passwordUpdate', 'frontend\AuthController@passwordUpdate');


    Route::post('getUserList', 'backend\UserController@getUserList');
    Route::post('insertUser', 'backend\UserController@insertUser');
    Route::get('changeWorkingStatusProvider', 'backend\UserController@changeWorkingStatusProvider');
    Route::get('cart_view', 'frontend\FrontController@cart_view');

    Route::get('homepageManager', 'frontend\FrontController@homepageManager');
    Route::get('forHumanity', 'frontend\FrontController@forHumanity');
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
    Route::post('getProductMiqty', 'frontend\FrontController@getProductMiqty');
    Route::get('cart_view', 'frontend\FrontController@cart_view');
    Route::post('product/cart_add', 'frontend\FrontController@cart_add');
    Route::post('product/cart_fetch', 'frontend\FrontController@cart_fetch');
    Route::post('product/cart_details', 'frontend\FrontController@cart_details');
    Route::post('product/cart_delete', 'frontend\FrontController@cart_delete');
    Route::post('product/cart_delete_donate', 'frontend\FrontController@cart_delete_donate');
    Route::post('product/donate', 'frontend\FrontController@donate');
    Route::post('product/donateQuantityChange', 'frontend\FrontController@donateQuantityChange');
    Route::get('sales', 'frontend\FrontController@sales');
    Route::post('transaction', 'frontend\AuthController@transaction');
    Route::post('insertContactUs', 'backend\UserController@insertContactUs');
    Route::get('buySale/{id}', 'frontend\FrontController@buySale');
    Route::get('buySaleAnimal/{id}', 'frontend\FrontController@buySaleAnimal');
    Route::get('videoView', 'frontend\FrontController@videoView');
    Route::get('getAllSaleCategory', 'frontend\FrontController@getAllSaleCategory');
    Route::post('insertSaleProduct', 'frontend\FrontController@insertSaleProduct');
    Route::post('getSaleProductsDetails', 'frontend\FrontController@getSaleProductsDetails');
    Route::get('animalSaleView/{id}', 'frontend\FrontController@animalSaleView');
    Route::get('productSaleView/{id}', 'frontend\FrontController@productSaleView');
    Route::get('animalSales/{id}', 'frontend\FrontController@animalSales');
    Route::get('productSales', 'frontend\FrontController@productSales');
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
    Route::get('insertTransport', 'frontend\TransportController@insertTransport');
    Route::get('getTransportPrice', 'frontend\TransportController@getTransportPrice');
    Route::get('searchMedicine', 'frontend\FrontController@searchMedicine');
    Route::get('searchMedicineByLetter/{letter}', 'frontend\FrontController@searchMedicineByLetter');
    Route::get('serviceSubCategoryMedical/{id}', 'frontend\FrontController@serviceSubCategoryMedical');
    Route::get('bondhonBazar', 'frontend\FrontController@bondhonBazar');
    Route::get('doctorAppointmentForm', 'frontend\MedicalServiceController@doctorAppointmentForm');
    Route::get('getDepartmentListAllFromDap', 'frontend\MedicalServiceController@getDepartmentListAllFromDap');
    Route::get('getAllMedDepartmentFront', 'backend\MedicalServiceController@getAllMedDepartment');
    Route::post('searchDoctorListFront', 'frontend\MedicalServiceController@searchDoctorListFront');
    Route::get('doctorProfileFront/{id}', 'frontend\MedicalServiceController@doctorProfileFront');
    Route::get('insertAppointment', 'frontend\MedicalServiceController@insertAppointment');
    Route::get('therapyServiceForm', 'frontend\MedicalServiceController@therapyServiceForm');
    Route::get('getAllTherapyServiceListFront', 'backend\MedicalServiceController@getAllTherapyServiceList');
    Route::post('searchTherapyListFront', 'frontend\MedicalServiceController@searchTherapyListFront');
    Route::get('therapyAppointmentForm/{id}', 'frontend\MedicalServiceController@therapyAppointmentForm');
    Route::get('insertTherapyAppointment', 'frontend\MedicalServiceController@insertTherapyAppointment');
    Route::get('diagnosticBookingForm', 'frontend\MedicalServiceController@diagnosticBookingForm');
    Route::get('getAllDiagnosticTest', 'backend\MedicalServiceController@getAllDiagnosticTest');
    Route::post('searchDiagnosticListFront', 'frontend\MedicalServiceController@searchDiagnosticListFront');
    Route::get('diagnosticAppointmentForm/{id}', 'frontend\MedicalServiceController@diagnosticAppointmentForm');
    Route::get('insertDiagnosticAppointment', 'frontend\MedicalServiceController@insertDiagnosticAppointment');
    Route::get('changeWorkingStatus', 'frontend\FrontController@changeWorkingStatus');
    Route::get('getAllMedDept ', 'backend\UserController@getAllMedDept');
    Route::get('getHospitalListAll ', 'backend\UserController@getHospitalListAll');
    Route::get('getMealTypeAll ', 'backend\UserController@getMealTypeAll');
    Route::get('serviceSubCategoryHomeAssistant/{id}', 'frontend\HomeAssistantController@serviceSubCategoryHomeAssistant');
    Route::get('cookingPageFront', 'frontend\HomeAssistantController@cookingPageFront');
    Route::get('getAllCookingType', 'frontend\HomeAssistantController@getAllCookingType');
    Route::get('getMealTypeFront', 'frontend\HomeAssistantController@getMealTypeFront');
    Route::get('getMealPersonFront', 'frontend\HomeAssistantController@getMealPersonFront');
    Route::get('getMealTimeFront', 'frontend\HomeAssistantController@getMealTimeFront');
    Route::get('getMealPriceFront', 'frontend\HomeAssistantController@getMealPriceFront');
    Route::post('cookingBookingFront', 'frontend\HomeAssistantController@cookingBookingFront');
    Route::get('clothWashingPage', 'frontend\HomeAssistantController@clothWashingPage');
    Route::get('getAllClothTypeFront', 'frontend\HomeAssistantController@getAllClothTypeFront');
    Route::post('clothWashingBookingFront', 'frontend\HomeAssistantController@clothWashingBookingFront');
    Route::get('getClothPriceByIdFront', 'frontend\HomeAssistantController@getClothPriceByIdFront');
    Route::get('cleaningPage', 'frontend\HomeAssistantController@cleaningPage');
    Route::get('getAllCleaningTypeFront', 'frontend\HomeAssistantController@getAllCleaningTypeFront');
    Route::get('getCleaningSizeFront', 'frontend\HomeAssistantController@getCleaningSizeFront');
    Route::get('getCleaningPriceFront', 'frontend\HomeAssistantController@getCleaningPriceFront');
    Route::post('cleaningBookingFront', 'frontend\HomeAssistantController@cleaningBookingFront');
    Route::get('helpingHandPage', 'frontend\HomeAssistantController@helpingHandPage');
    Route::get('getAllHelpingHandTypeFront', 'frontend\HomeAssistantController@getAllHelpingHandTypeFront');
    Route::get('getHelpingTimeFront', 'frontend\HomeAssistantController@getHelpingTimeFront');
    Route::get('getHelpingPriceFront', 'frontend\HomeAssistantController@getHelpingPriceFront');
    Route::post('helpingHandBookingFront', 'frontend\HomeAssistantController@helpingHandBookingFront');
    Route::get('guardPage', 'frontend\HomeAssistantController@guardPage');
    Route::get('getAllGuardTypeFront', 'frontend\HomeAssistantController@getAllGuardTypeFront');
    Route::get('getGuardTimeFront', 'frontend\HomeAssistantController@getGuardTimeFront');
    Route::get('getGuardPriceFront', 'frontend\HomeAssistantController@getGuardPriceFront');
    Route::post('guardBookingFront', 'frontend\HomeAssistantController@guardBookingFront');
    Route::get('productServicingPage', 'frontend\HomeAssistantController@productServicingPage');
    Route::get('getAllProductServiceTypeFront', 'frontend\HomeAssistantController@getAllProductServiceTypeFront');
    Route::get('getProductServiceNameTimeFront', 'frontend\HomeAssistantController@getProductServiceNameTimeFront');
    Route::get('getProductServicePriceFront', 'frontend\HomeAssistantController@getProductServicePriceFront');
    Route::post('productServicingBookingFront', 'frontend\HomeAssistantController@productServicingBookingFront');
    Route::get('parlorServicingPage', 'frontend\HomeAssistantController@parlorServicingPage');
    Route::get('getAllParlorTypeFront', 'frontend\HomeAssistantController@getAllParlorTypeFront');
    Route::get('getParlorServiceNameFront', 'frontend\HomeAssistantController@getParlorServiceNameFront');
    Route::get('getParlorServicePriceFront', 'frontend\HomeAssistantController@getParlorServicePriceFront');
    Route::post('parlorServiceBookingFront', 'frontend\HomeAssistantController@parlorServiceBookingFront');
    Route::get('serviceArea', 'frontend\TransportController@serviceArea');
    Route::post('insertServiceArea', 'frontend\TransportController@insertServiceArea');
    Route::get('getAddressGroupMotor', 'frontend\TransportController@getAddressGroupMotor');
    Route::post('insertMotorcycleRide', 'frontend\TransportController@insertMotorcycleRide');
    Route::get('getAddressGroupPrivate', 'frontend\TransportController@getAddressGroupPrivate');
    Route::post('insertPrivateRide', 'frontend\TransportController@insertPrivateRide');
    Route::get('medicalCampFront', 'frontend\MedicalServiceController@medicalCampFront');
    Route::get('localDoctor', 'frontend\MedicalServiceController@localDoctorAppointment');
    Route::post('searchLocalDoctorListFront', 'frontend\MedicalServiceController@searchLocalDoctorListFront');
    Route::get('localDoctorProfileFront/{id}', 'frontend\MedicalServiceController@localDoctorProfileFront');
    Route::get('insertLocalAppointment', 'frontend\MedicalServiceController@insertLocalAppointment');

    Route::get('getAllNaming1Front', 'backend\AddressController@getAllNaming1');
    Route::get('getNaming2ListAllFront', 'backend\AddressController@getNaming2ListAll');
    Route::get('getNaming3ListAllFront', 'backend\AddressController@getNaming3ListAll');
    Route::get('getNaming4ListAllFront', 'backend\AddressController@getNaming4ListAll');
    Route::get('getNaming5ListAllFront', 'backend\AddressController@getNaming5ListFront');

    Route::get('courier', 'frontend\TransportController@courier');
    Route::get('serviceAreaCourier', 'frontend\TransportController@serviceAreaCourier');
    Route::post('insertServiceAreaCourier', 'frontend\TransportController@insertServiceAreaCourier');
    Route::get('getAllCourierTypeFront', 'backend\TransportController@getAllCourierType');
    Route::get('getAllCourierWeight', 'frontend\TransportController@getAllCourierWeight');
    Route::get('getAllNaming1CountryFront', 'backend\TransportController@getAllNaming1Country');
    Route::get('getAllCourierCost', 'frontend\TransportController@getAllCourierCost');
    Route::get('getAllCourierCostBd', 'frontend\TransportController@getAllCourierCostBd');
    Route::post('insertCourierBooking', 'frontend\TransportController@insertCourierBooking');

    Route::get('laundryServicePage', 'frontend\HomeAssistantController@laundryServicePage');
    Route::get('getLaundryPriceByIdFront', 'frontend\HomeAssistantController@getLaundryPriceByIdFront');
    Route::post('laundryBookingFront', 'frontend\HomeAssistantController@laundryBookingFront');

    Route::get('serviceSubCategoryToursNTravel/{id}', 'frontend\ToursController@serviceSubCategoryToursNTravel');
    Route::get('getAllToursListFront', 'frontend\ToursController@getAllToursListFront');
    Route::get('getMainPlaceListAllFront', 'backend\ToursController@getMainPlaceListAll');
    Route::post('searchTourNTravels', 'frontend\ToursController@searchTourNTravels');
    Route::get('bookingHotel', 'frontend\ToursController@bookingHotel');
    Route::get('bookingHNT', 'frontend\ToursController@bookingHNT');
    Route::get('getHNTPrice', 'frontend\ToursController@getHNTPrice');
    Route::get('bookingTourPackage', 'frontend\ToursController@bookingTourPackage');
    Route::get('bookingPageTNT', 'frontend\ToursController@bookingPageTNT');
    Route::get('getAnimalSearchByValue', 'frontend\FrontController@getAnimalSearchByValue');
    Route::post('searchAnimal', 'frontend\FrontController@searchAnimal');

//Payment Gateway
    Route::post('getPaymentCartView', 'frontend\PaymentController@getPaymentCartView');
    Route::get('paymentFromVariousMarket', 'frontend\PaymentController@paymentFromVariousMarket');
    Route::post('insertTicketPayment', 'frontend\PaymentController@insertTicketPayment');
    Route::post('insertDrAppointmentPayment', 'frontend\PaymentController@insertDrAppointmentPayment');
    Route::post('insertTherapyAppointmentPayment', 'frontend\PaymentController@insertTherapyAppointmentPayment');
    Route::post('insertDiagnosticAppointmentPayment', 'frontend\PaymentController@insertDiagnosticAppointmentPayment');
    Route::post('insertLocalAppointmentPayment', 'frontend\PaymentController@insertLocalAppointmentPayment');
    Route::get('insertCookingPaymentInfo', 'frontend\HomeAssistantController@insertCookingPaymentInfo');
    Route::get('insertClothWashingPaymentInfo', 'frontend\HomeAssistantController@insertClothWashingPaymentInfo');
    Route::get('insertRoomCleaningPaymentInfo', 'frontend\HomeAssistantController@insertRoomCleaningPaymentInfo');
    Route::get('insertHelpingHandPaymentInfo', 'frontend\HomeAssistantController@insertHelpingHandPaymentInfo');
    Route::get('insertGuardPaymentInfo', 'frontend\HomeAssistantController@insertGuardPaymentInfo');
    Route::get('insertProductServicingPaymentInfo', 'frontend\HomeAssistantController@insertProductServicingPaymentInfo');
    Route::get('insertParlorPaymentInfo', 'frontend\HomeAssistantController@insertParlorPaymentInfo');
    Route::get('insertLaundryPaymentInfo', 'frontend\HomeAssistantController@insertLaundryPaymentInfo');
    Route::get('insertCourierPaymentInfo', 'frontend\TransportController@insertCourierPaymentInfo');
    Route::post('insertBookingHNTPayment', 'frontend\PaymentController@insertBookingHNTPayment');
    Route::get('insertBookingHNTOnOnline', 'frontend\ToursController@insertBookingHNTOnOnline');
    Route::get('insertBookingHNTOnCash', 'frontend\ToursController@insertBookingHNTOnCash');
    Route::post('insertTourPackagePayment', 'frontend\PaymentController@insertTourPackagePayment');
    Route::get('insertTourPackagePayOnline', 'frontend\ToursController@insertTourPackagePayOnline');

    //my_acc_personal
    Route::get('m_acc', 'backend\UserController@m_acc');
    Route::get('getAllCompany', 'backend\UserController@getAllCompany');
    Route::get('getAllProject', 'backend\UserController@getAllProject');
    Route::post('insertM_acc', 'backend\UserController@insertM_acc');
    Route::post('getM_accReportByDate', 'backend\UserController@getM_accReportByDate');
    Route::post('getM_accListById', 'backend\UserController@getM_accListById');
