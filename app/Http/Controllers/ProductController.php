<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Customer;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductDetails;
use App\Models\ProductReview;
use App\Models\ProductSlider;
use App\Models\ProductWish;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class ProductController extends Controller
{



    //User 


    public function WishListPage()
    {
        return view('pages.user.wish-list-page');
    }


    public function CartListPage()
    {
        return view('pages.user.cart-list-page');
    }


    public function ProductDetailsPage()
    {
        return view('pages.user.details-page');
    }
   
    public function ProductByCategoryPage()
    {
        return view('pages.user.product-by-category');
    }



    public function ListProductByCategory(Request $request):JsonResponse{            // Product List Web-API Routes
        $data=Product::where('category_id',$request->id)->with('category')->get();
        return ResponseHelper::Out('success',$data,200);
    }

    public function ListProductByRemark(Request $request):JsonResponse{
        $data=Product::where('remark',$request->remark)->with('category')->get();
        return ResponseHelper::Out('success',$data,200);
    }


    public function ListProductSlider():JsonResponse{                  // Slider Web-API Routes
        $data=ProductSlider::all();
        return ResponseHelper::Out('success',$data,200);
    }

    public function ProductDetailsById(Request $request):JsonResponse{     // Product Details Web-API Routes
        $data=ProductDetails::where('product_id',$request->id)->with('product','product.category')->get();
        return ResponseHelper::Out('success',$data,200);
    }

    public function ListReviewByProduct(Request $request):JsonResponse{
        $data=ProductReview::where('product_id',$request->product_id)
            ->with(['customer'=>function($query){                    // this might cause error as we changed tables name
                $query->select('id','name');
            }])->get();
        return ResponseHelper::Out('success',$data,200);
    }



    public function CreateProductReview(Request $request):JsonResponse{                    // User Product Review Web-API Routes 
        $user_id=$request->header('id');
        $profile=Customer::where('user_id',$user_id)->first();

        if($profile){
            $request->merge(['customer_id' =>$profile->id]);
            $data=ProductReview::updateOrCreate(
                ['customer_id' => $profile->id,'product_id'=>$request->input('product_id')],
                $request->input()
            );
            return ResponseHelper::Out('success',$data,200);
        }
        else{
            return ResponseHelper::Out('fail','Customer profile not exists',200);
        }

    }


    public function ProductWishList(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
    
        // Use whereHas to filter by user_id through customer relationship
        $data = ProductWish::whereHas('customer', function ($query) use ($user_id) {
            $query->where('user_id', $user_id); // Ensure 'user_id' exists in customers table
        })->with('product')->get();
    
        return ResponseHelper::Out('success', $data, 200);
    }
    

    public function CreateWishList(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
    
        // Retrieve the associated customer_id for the given user_id
        $customer = Customer::where('user_id', $user_id)->first();
    
        if (!$customer) {
            return ResponseHelper::Out('error', 'Customer not found for this user ID.', 404);
        }
    
        // Use the customer_id to create or update the ProductWish
        $data = ProductWish::updateOrCreate(
            [
                'customer_id' => $customer->id,
                'product_id' => $request->product_id,
            ],
            [
                'customer_id' => $customer->id,
                'product_id' => $request->product_id,
            ]
        );
    
        return ResponseHelper::Out('success', $data, 200);
    }


    // public function ProductWishList(Request $request):JsonResponse{           // User Product Wish Web-API Routes 
    //     $user_id=$request->header('id');
        
    //     $data=ProductWish::where('user_id',$user_id)->with('product')->get();
    //     return ResponseHelper::Out('success',$data,200);
    // }

    // public function CreateWishList(Request $request):JsonResponse{
    //     $user_id=$request->header('id');
    //     $data=ProductWish::updateOrCreate(
    //         ['user_id' => $user_id,'product_id'=>$request->product_id],
    //         ['user_id' => $user_id,'product_id'=>$request->product_id],
    //     );
    //     return ResponseHelper::Out('success',$data,200);
    // }


    // public function RemoveWishList(Request $request):JsonResponse{
    //     $user_id=$request->header('id');
    //     $data=ProductWish::where(['user_id' => $user_id,'product_id'=>$request->product_id])->delete();
    //     return ResponseHelper::Out('success',$data,200);
    // }


    public function RemoveWishList(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
    
        // Retrieve the associated customer_id for the given user_id
        $customer = Customer::where('user_id', $user_id)->first();
    
        if (!$customer) {
            return ResponseHelper::Out('error', 'Customer not found for this user ID.', 404);
        }
    
        // Delete the product wish using the customer_id and product_id
        $data = ProductWish::where([
            'customer_id' => $customer->id,
            'product_id' => $request->product_id,
        ])->delete();
    
        return ResponseHelper::Out('success', $data, 200);

        
    }
    

    public function CreateCartList(Request $request):JsonResponse{                           // User Product Cart Web-API Routes 
        $user_id=$request->header('id');                                           
        $product_id =$request->input('product_id');
        $color=$request->input('color');
        $size=$request->input('size');
        $qty=$request->input('qty');

        $UnitPrice=0;

        $productDetails=Product::where('id','=',$product_id)->first();
        if($productDetails->discount==1){
            $UnitPrice=$productDetails->discount_price;
        }
        else{
            $UnitPrice=$productDetails->price;
        }
        $totalPrice=$qty*$UnitPrice;


        $data=ProductCart::updateOrCreate(
            ['user_id' => $user_id,'product_id'=>$product_id],
            [
                'user_id' => $user_id,
                'product_id'=>$product_id,
                'color'=>$color,
                'size'=>$size,
                'qty'=>$qty,
                'price'=>$totalPrice
            ]
        );

        return ResponseHelper::Out('success',$data,200);
    }



    public function CartList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $data=ProductCart::where('user_id',$user_id)->with('product')->get();
        return ResponseHelper::Out('success',$data,200);
    }



    public function DeleteCartList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $data=ProductCart::where('user_id','=',$user_id)->where('product_id','=',$request->product_id)->delete();
        return ResponseHelper::Out('success',$data,200);
    }








    //User





    function ProductPage():View{
        return view('pages.dashboard.product-page');
    }


    function CreateProduct(Request $request)
    {
       // $user_id=$request->header('id');

        // Prepare File Name & Path
        $img=$request->file('img_url');

        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{$t}-{$file_name}";
        $img_url="uploads/{$img_name}";


        // Upload File
        $img->move(public_path('uploads'),$img_name);


        // Save To Database
     $product = Product::create([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$img_url,
            'category_id'=>$request->input('category_id'),
             'discount_price'=>$request->input('discount_price'),
             'stock'=>$request->input('stock'),
             'star'=>$request->input('star'),
             'remark'=>$request->input('remark'),
                ]);

        $product_id=$product->id; 

        return ProductDetails::create([
            'product_id'=>$product_id,
            'color'=>$request->input('color'),
            'size'=>$request->input('size'),
            'des'=>$request->input('des'),
            'img1'=> $img_url
        ]);

        
    }


    function DeleteProduct(Request $request)
    {
      //  $user_id=$request->header('id');
        $product_id=$request->input('id');
        $filePath=$request->input('file_path');
        InvoiceProduct::where('product_id',$product_id)->delete();
        ProductDetails::where('product_id',$product_id)->delete();
        File::delete($filePath);
        return Product::where('id',$product_id)->delete();

    }


    function ProductByID(Request $request)
    {
      //  $user_id=$request->header('id');
        $product_id=$request->input('id');
        return Product::where('id',$product_id)->first();
    }


    function ProductList(Request $request)
    {
      //  $user_id=$request->header('id');
        return Product::with('category')->get();
    }



    public function UpdateProduct(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'id' => 'required|exists:products,id',
                'name' => 'sometimes|string|max:255',
                'price' => 'sometimes|numeric',
                'unit' => 'sometimes|string|max:50',
                'category_id' => 'sometimes|exists:categories,id',
                'discount_price' => 'nullable|numeric',
                'stock' => 'nullable|integer',
                'star' => 'nullable|numeric|between:0,5',
                'img' => 'nullable|image|max:2048',
                'img1' => 'nullable|image|max:2048',
                'color' => 'nullable|string|max:100',
                'size' => 'nullable|string|max:100',
                'des' => 'nullable|string',
            ]);

            // Fetch the product
            $product = Product::findOrFail($validated['id']);

            // Handle product image upload
            if ($request->hasFile('img')) {
                if ($product->img_url) {
                    Storage::delete($product->img_url);
                }

                $productImagePath = $request->file('img')->store('public/products');
                $product->img_url = Storage::url($productImagePath);
            }

            // Update product fields
            $product->update($validated);

            // Handle ProductDetails
            $productDetails = $product->details ?? new ProductDetails(['product_id' => $product->id]);

            // Handle additional image upload
            if ($request->hasFile('img1')) {
                if ($productDetails->img1) {
                    Storage::delete($productDetails->img1);
                }

                $detailsImagePath = $request->file('img1')->store('public/product-details');
                $productDetails->img1 = Storage::url($detailsImagePath);
            }

            // Update ProductDetails fields
            $productDetails->update([
                'color' => $validated['color'] ?? $productDetails->color,
                'size' => $validated['size'] ?? $productDetails->size,
                'des' => $validated['des'] ?? $productDetails->des,
            ]);

            return response()->json(['success' => true, 'message' => 'Product updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getProductById(Request $request)
{
    $product = Product::with('details')->find($request->id);

    if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product not found'], 404);
    }

    return response()->json(['success' => true, 'product' => $product, 'details' => $product->details]);
}
}
