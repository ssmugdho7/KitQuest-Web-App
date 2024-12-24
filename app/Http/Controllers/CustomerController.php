<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Helper\ResponseHelper;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{

    function CustomerPage():View{
        return view('pages.dashboard.customer-page');
    }

    function CustomerCreate(Request $request){
        $user_id=$request->header('id');
        return Customer::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
            'user_id'=>$user_id
        ]);
    }


    function CustomerList(Request $request){
    // Fetch customers along with their associated user's email
    $customers = Customer::with('user:id,email')->get([ "id",'name', 'mobile', 'user_id']);

    // Map the data to include email from the User model
    $customers = $customers->map(function ($customer) {
        return [
            'id' => $customer->id,
            'name' => $customer->name,
            'mobile' => $customer->mobile,
            'email' => $customer->user->email ?? null, // Check if user exists
        ];
    });

    return response()->json($customers);

    }


    function CustomerDelete(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->where('user_id',$user_id)->delete();
    }


    function CustomerByID(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->where('user_id',$user_id)->first();
    }


     function CustomerUpdate(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->where('user_id',$user_id)->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
        ]);
    }



}
