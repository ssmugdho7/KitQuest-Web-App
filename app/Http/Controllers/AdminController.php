<?php

namespace App\Http\Controllers;
use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Mail\OTPMail;
use App\Models\Admin;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller
{
   
    function AdminLoginPage(){
        return view('pages.auth.login-page');
    }

    function AdminRegistrationPage(){
        return view('pages.auth.registration-page');
    }
    function AdminSendOtpPage(){
        return view('pages.auth.send-otp-page');
    }
    function AdminVerifyOTPPage(){
        return view('pages.auth.verify-otp-page');
    }

    function AdminResetPasswordPage(){
        return view('pages.auth.reset-pass-page');
    }

    function AdminProfilePage(){
        return view('pages.dashboard.profile-page');
    }


    public function AdminLogin(Request $request): JsonResponse
    {
        try {
            $count = Admin::where('email', '=', $request->input('email'))
                ->where('password', '=', $request->input('password'))
                ->select('id')->first();
    
            if ($count !== null) {
                // User Login -> JWT Token Issue
                $token = JWTToken::CreateToken($request->input('email'), $count->id);
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Admin Login Successful',
                ], 200)->cookie('admin_token', $token, time() + 60 * 24 * 30)
                  ->header('location', '/dashboard'); // Redirect header
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Unauthorized'
                ], 200);
            }
    
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Admin Login Failed'
            ], 200);
        }
    }


 
   

    





    // function AdminRegistration(Request $request){
    //     try {
    //         Admin::create([
    //             'firstName' => $request->input('firstName'),
    //             'lastName' => $request->input('lastName'),
    //             'email' => $request->input('email'),
    //             'mobile' => $request->input('mobile'),
    //             'password' => $request->input('password'),
    //         ]);
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'User Registration Successfully'
    //         ],200);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => 'User Registration Failed'
    //         ],200);

    //     }
    // }

    // function AdminLogin(Request $request){
    //    $count=Admin::where('email','=',$request->input('email'))
    //         ->where('password','=',$request->input('password'))
    //         ->select('id')->first();

    //    if($count!==null){
    //        // User Login-> JWT Token Issue
    //        $token=JWTToken::CreateToken($request->input('email'),$count->id);
    //        return response()->json([
    //            'status' => 'success',
    //            'message' => 'User Login Successful',
    //        ],200)->cookie('token',$token,time()+60*24*30);
    //    }
    //    else{
    //        return response()->json([
    //            'status' => 'failed',
    //            'message' => 'unauthorized'
    //        ],200);

    //    }

    // }

    // function AdminSendOTPCode(Request $request){

    //     $email=$request->input('email');
    //     $otp=rand(1000,9999);
    //     $count=Admin::where('email','=',$email)->count();

    //     if($count==1){
    //         // OTP Email Address
    //         Mail::to($email)->send(new OTPMail($otp));
    //         // OTO Code Table Update
    //         Admin::where('email','=',$email)->update(['otp'=>$otp]);

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => '4 Digit OTP Code has been send to your email !'
    //         ],200);
    //     }
    //     else{
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => 'unauthorized'
    //         ]);
    //     }
    // }

    // function AdminVerifyOTP(Request $request){
    //     $email=$request->input('email');
    //     $otp=$request->input('otp');
    //     $count=Admin::where('email','=',$email)
    //         ->where('otp','=',$otp)->count();

    //     if($count==1){
    //         // Database OTP Update
    //         Admin::where('email','=',$email)->update(['otp'=>'0']);

    //         // Pass Reset Token Issue
    //         $token=JWTToken::CreateTokenForSetPassword($request->input('email'));
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'OTP Verification Successful',
    //         ],200)->cookie('token',$token,60*24*30);

    //     }
    //     else{
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => 'unauthorized'
    //         ],200);
    //     }
    // }

    // function AdminResetPassword(Request $request){
    //     try{
    //         $email=$request->header('email');
    //         $password=$request->input('password');
    //         Admin::where('email','=',$email)->update(['password'=>$password]);
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Request Successful',
    //         ],200);

    //     }catch (Exception $exception){
    //         return response()->json([
    //             'status' => 'fail',
    //             'message' => 'Something Went Wrong',
    //         ],200);
    //     }
    // }

    // function AdminLogout(){
    //     return redirect('/')->cookie('token','',-1);
    // }


    // function AdminProfile(Request $request){
    //     $email=$request->header('email');
    //     $user=Admin::where('email','=',$email)->first();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Request Successful',
    //         'data' => $user
    //     ],200);
    // }

    // function AdminUpdateProfile(Request $request){
    //     try{
    //         $email=$request->header('email');
    //         $firstName=$request->input('firstName');
    //         $lastName=$request->input('lastName');
    //         $mobile=$request->input('mobile');
    //         $password=$request->input('password');
    //         Admin::where('email','=',$email)->update([
    //             'firstName'=>$firstName,
    //             'lastName'=>$lastName,
    //             'mobile'=>$mobile,
    //             'password'=>$password
    //         ]);
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Request Successful',
    //         ],200);

    //     }catch (Exception $exception){
    //         return response()->json([
    //             'status' => 'fail',
    //             'message' => 'Something Went Wrong',
    //         ],200);
    //     }
    // }
}
