<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Customer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfileController extends Controller
{
    public function ProfilePage(){
        return view('pages.user.profile-page');
    }

    public function CreateProfile(Request $request): JsonResponse
    {
        $user_id=$request->header('id');
        $request->merge(['user_id' =>$user_id]);
        $data= Customer::updateOrCreate(
            ['user_id' => $user_id],
            $request->input()
        );
        return ResponseHelper::Out('success',$data,200);
    }


    public function ReadProfile(Request $request): JsonResponse
    {
        $user_id=$request->header('id');
        $data=Customer::where('user_id',$user_id)->with('user')->first();
        return ResponseHelper::Out('success',$data,200);
    }
}
