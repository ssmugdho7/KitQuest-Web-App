<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminTokenVerificationMiddleware;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;





//User & Admin Home-Page Route 
Route::get('/',[HomeController::class,'HomePage']);


//User Auth Pages-Routes 
Route::get('/user/loginPage',[UserController::class,'UserLoginPage']);
Route::get('/user/verifyPage',[UserController::class,'UserVerifyPage']);
//Logout doesn't need page,so no page route


// User Auth Web-API Routes 
Route::get("/UserLogin/{UserEmail}", [UserController::class, 'UserLogin']);
Route::get('/VerifyLogin/{UserEmail}/{OTP}', [UserController::class, 'VerifyLogin']);
Route::get('/logout',[UserController::class,'UserLogout']);   


//User Pages-Routes           
Route::get('/user/detailsPage',[ProductController::class,'ProductDetailsPage']);
Route::get('/user/cartPage',[ProductController::class,'CartListPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user/wishListPage',[ProductController::class,'WishListPage'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/user/policyPage',[PolicyController::class,'PolicyPage']);

Route::get('/user/profilePage',[ProfileController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user/ProductByCategoryPage',[ProductController::class,'ProductByCategoryPage']);



                                      //User Web-API Routes 

//CategoryList Web-API Routes 
Route::get('/userCategoryList',[CategoryController::class,'UserCategoryList']);   //***//get the category lists only
 
// Product List Web-API Routes
Route::get('/ListProductByCategory/{id}', [ProductController::class, 'ListProductByCategory']);   //get the products from category
Route::get('/ListProductByRemark/{remark}', [ProductController::class, 'ListProductByRemark']);
// Slider Web-API Routes
Route::get('/ListProductSlider', [ProductController::class, 'ListProductSlider']);
// Product Details Web-API Routes
Route::get('/ProductDetailsById/{id}', [ProductController::class, 'ProductDetailsById']);
Route::get('/ListReviewByProduct/{product_id}', [ProductController::class, 'ListReviewByProduct']);
//policy Web-API Routes
Route::get("/PolicyByType/{type}",[PolicyController::class,'PolicyByType']);






// User Profile Web-API Routes 
Route::post('/CreateProfile', [ProfileController::class, 'CreateProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/ReadProfile', [ProfileController::class, 'ReadProfile'])->middleware([TokenVerificationMiddleware::class]);


// User Product Review Web-API Routes 
Route::post('/CreateProductReview', [ProductController::class, 'CreateProductReview'])->middleware([TokenVerificationMiddleware::class]);



// User Product Wish Web-API Routes 
Route::get('/ProductWishList', [ProductController::class, 'ProductWishList'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/CreateWishList/{product_id}', [ProductController::class, 'CreateWishList'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/RemoveWishList/{product_id}', [ProductController::class, 'RemoveWishList'])->middleware([TokenVerificationMiddleware::class]);



// User Product Cart Web-API Routes 
Route::post('/CreateCartList', [ProductController::class, 'CreateCartList'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/CartList', [ProductController::class, 'CartList'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/DeleteCartList/{product_id}', [ProductController::class, 'DeleteCartList'])->middleware([TokenVerificationMiddleware::class]);



 
// User Invoice and payment Web-API Routes 
Route::post("/InvoiceCreate",[InvoiceController::class,'InvoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/InvoiceList",[InvoiceController::class,'InvoiceList'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/InvoiceProductList/{invoice_id}",[InvoiceController::class,'InvoiceProductList'])->middleware([TokenVerificationMiddleware::class]);






















// Admin Auth Pages-Routes for admin
Route::get('/adminLogin',[AdminController::class,'AdminLoginPage']);
// Route::get('/adminRegistration',[AdminController::class,'AdminRegistrationPage']);
// Route::get('/adminSendOtp',[AdminController::class,'AdminSendOtpPage']);
// Route::get('/adminVerifyOtp',[AdminController::class,'AdminVerifyOTPPage']);
// Route::get('/adminResetPassword',[AdminController::class,'AdminResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);



// Admin Auth Web-API Routes 
// Route::post('/user-registration',[AdminController::class,'AdminRegistration']);
Route::post('/admin-login',[AdminController::class,'AdminLogin']);
// Route::post('/send-otp',[AdminController::class,'AdminSendOTPCode']);
// Route::post('/verify-otp',[AdminController::class,'AdminVerifyOTP']);
// Route::post('/reset-password',[AdminController::class,'AdminResetPassword'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/logout',[AdminController::class,'AdminLogout']);   //logout

Route::get('/admin-profile',[AdminController::class,'AdminProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/admin-profile-update',[AdminController::class,'AdminUpdateProfile'])->middleware([TokenVerificationMiddleware::class]);           

// Admin Page-Routes
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([AdminTokenVerificationMiddleware::class]);      
Route::get('/adminProfile',[AdminController::class,'AdminProfilePage'])->middleware([AdminTokenVerificationMiddleware::class]);   
Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([AdminTokenVerificationMiddleware::class]);   
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([AdminTokenVerificationMiddleware::class]);   
Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware([AdminTokenVerificationMiddleware::class]);   
Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([AdminTokenVerificationMiddleware::class]);   
// Route::get('/salePage',[InvoiceController::class,'SalePage']);
Route::get('/reportPage',[ReportController::class,'ReportPage'])->middleware([AdminTokenVerificationMiddleware::class]);   


                            //Admin Web-API Routes

// Admin Category Web-API Routes
Route::post("/create-category",[CategoryController::class,'CategoryCreate']);
Route::get("/list-category",[CategoryController::class,'CategoryList']);
Route::post("/delete-category",[CategoryController::class,'CategoryDelete']);
Route::post("/update-category",[CategoryController::class,'CategoryUpdate']);
Route::post("/category-by-id",[CategoryController::class,'CategoryByID']);


// Admin Customer Web-API Routes
Route::post("/create-customer",[CustomerController::class,'CustomerCreate']);
Route::get("/list-customer",[CustomerController::class,'CustomerList']);
Route::post("/delete-customer",[CustomerController::class,'CustomerDelete']);
Route::post("/update-customer",[CustomerController::class,'CustomerUpdate']);
Route::post("/customer-by-id",[CustomerController::class,'CustomerByID']);


//  Admin Product Wen-API Routes
Route::post("/create-product",[ProductController::class,'CreateProduct']);
Route::post("/delete-product",[ProductController::class,'DeleteProduct']);
Route::post("/product-update",[ProductController::class,'UpdateProduct']);
Route::get("/list-product",[ProductController::class,'ProductList']);
Route::post("/product-by-id",[ProductController::class,'ProductByID']);

Route::post('/product-by-Id', [ProductController::class, 'getProductById']);

// Admin Invoice Web-API Routes
Route::post("/invoice-create",[InvoiceController::class,'invoiceCreate']);
Route::get("/invoice-select",[InvoiceController::class,'invoiceSelect']);
Route::post("/invoice-details",[InvoiceController::class,'InvoiceDetails']);
Route::post("/invoice-delete",[InvoiceController::class,'invoiceDelete']);

Route::get("/invoice-display", [InvoiceController::class,'invoiceDispayToAdmin']);
Route::post("/invoice-update", [InvoiceController::class,'updateInvoiceFromAdmin']);


// Admin SUMMARY & Report WEB-API Routes
Route::get("/summary",[DashboardController::class,'Summary']);
Route::get("/sales-report/{FormDate}/{ToDate}",[ReportController::class,'SalesReport']);

//


