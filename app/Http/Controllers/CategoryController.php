<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use Illuminate\Http\JsonResponse;
class CategoryController extends Controller
{


        //User

  

    public function UserCategoryList():JsonResponse    //CategoryList Web-API Routes 
    {
        $data= Category::all();
        return  ResponseHelper::Out('success',$data,200);
    }
 
        //User









    function CategoryPage(){
        return view('pages.dashboard.category-page');
    }

    function CategoryList(Request $request){
        //$user_id=$request->header('id');
        return Category::all();
    }

    function CategoryCreate(Request $request){
        // $user_id=$request->header('id');
        return Category::create([
            'name'=>$request->input('name'),
            'img_url'=>$request->input('img_url')
        ]);
    }

    function CategoryDelete(Request $request){
        $category_id=$request->input('id');
      //  $user_id=$request->header('id');
        return Category::where('id',$category_id)->delete();
    }


    function CategoryByID(Request $request){
        $category_id=$request->input('id');
       // $user_id=$request->header('id');
        return Category::where('id',$category_id)->first();
    }



    function CategoryUpdate(Request $request){

        $request->validate([
            'id' => 'required|integer|exists:categories,id',
            'name' => 'required|string',
            'img_url' => 'nullable|string',
        ]);
        
        $category_id=$request->input('id');
       // $user_id=$request->header('id');
        return Category::where('id',$category_id)->update([
            'name'=>$request->input('name'),
            'img_url'=>$request->input('img_url')
        ]);
    }
}
