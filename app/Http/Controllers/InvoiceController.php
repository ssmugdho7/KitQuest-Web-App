<?php

namespace App\Http\Controllers;
use App\Helper\ResponseHelper;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\ProductCart;
use console;
use Exception;
use FontLib\Table\Type\name;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvoiceController extends Controller
{


    //User 

    function InvoiceCreate(Request $request)                       // User Invoice and payment Web-API Routes 
    {
        DB::beginTransaction();
        try {

            //
            $user_id=$request->header('id');
            $user_email=$request->header('email');

        
            $delivery_status='Pending';
            $payment_status='Pending';

            Customer::updateOrCreate(
                ['user_id' => $user_id], // Condition to find the existing record
                [
                    'name' => $request->input('name'),
                    'district' => $request->input('district'),
                    'mobile' => $request->input('mobile'),
                    'addressDetails' => $request->input('addressDetails'),
                ]
            );

            $Profile=Customer::where('user_id','=',$user_id)->first();
            $cus_details=$Profile->district;
           

            // Payable Calculation
            $total=0;
            $cartList=ProductCart::where('user_id','=',$user_id)->get();
            foreach ($cartList as $cartItem) {
                $total=$total+$cartItem->price;
            }

            $vat=($total*3)/100;
            $payable=$total+$vat;

            $invoice= Invoice::create([
                'total'=>$total,
                'vat'=>$vat,
                'payable'=>$payable,
                'cus_details'=>$cus_details,
                'delivery_status'=>$delivery_status,
                'payment_status'=>$payment_status,
                'user_id'=>$user_id
            ]);

            $invoiceID=$invoice->id;

            foreach ($cartList as $EachProduct) {
                InvoiceProduct::create([
                    'invoice_id' => $invoiceID,
                    'product_id' => $EachProduct['product_id'],
                    'user_id'=>$user_id,
                    'qty' =>  $EachProduct['qty'],
                    'sale_price'=>  $EachProduct['price'],
                ]);
            }


           DB::commit();

           return ResponseHelper::Out('success',array(['payable'=>$payable,'vat'=>$vat,'total'=>$total]),200);

        }
        catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::Out('fail',$e,200);
        }

    }

    function InvoiceList(Request $request){
        $user_id=$request->header('id');
        return Invoice::where('user_id',$user_id)->get();
    }

    function InvoiceProductList(Request $request){
        $user_id=$request->header('id');
        $invoice_id=$request->invoice_id;
        return InvoiceProduct::where(['user_id'=>$user_id,'invoice_id'=>$invoice_id])->with('product')->get();
    }

    //User





























    function InvoicePage():View{
        return view('pages.dashboard.invoice-page');
    }

   

    // function invoiceCreate(Request $request){        //commented bcz of same method in InvoiceController

    //     DB::beginTransaction();

    //     try {

    //     $user_id=$request->header('id');
    //     $total=$request->input('total');
    //     $discount=$request->input('discount');
    //     $vat=$request->input('vat');
    //     $payable=$request->input('payable');

    //     $customer_id=$request->input('customer_id');

    //     $invoice= Invoice::create([
    //         'total'=>$total,
    //         'discount'=>$discount,
    //         'vat'=>$vat,
    //         'payable'=>$payable,
    //         'user_id'=>$user_id,
    //         'customer_id'=>$customer_id,
    //     ]);


    //    $invoiceID=$invoice->id;

    //    $products= $request->input('products');

    //    foreach ($products as $EachProduct) {
    //         InvoiceProduct::create([
    //             'invoice_id' => $invoiceID,
    //             'user_id'=>$user_id,
    //             'product_id' => $EachProduct['product_id'],
    //             'qty' =>  $EachProduct['qty'],
    //             'sale_price'=>  $EachProduct['sale_price'],
    //         ]);
    //     }

    //    DB::commit();

    //    return 1;

    //     }
    //     catch (Exception $e) {
    //         DB::rollBack();
    //         return 0;
    //     }

    // }

    function invoiceSelect(Request $request){
     // Fetch data using relationships
     $invoices = Invoice::with(['user', 'customer'])->get();

     return $invoices->map(function ($invoice) {
         return [
             'id' => $invoice->id,
             'name' => $invoice->customer->name ?? 'N/A',
             'mobile' => $invoice->customer->mobile ?? 'N/A',
             'total' => $invoice->total,
             'vat' => $invoice->vat,
             'payable' => $invoice->payable,
         ];
     });

 // Return response (can be JSON for API calls)
 return response()->json($invoices);
    }

    function InvoiceDetails(Request $request){
        $user_id=$request->header('id');
        $customerDetails=Customer::where('user_id',$user_id)->where('id',$request->input('cus_id'))->first();
        $invoiceTotal=Invoice::where('user_id','=',$user_id)->where('id',$request->input('inv_id'))->first();
        $invoiceProduct=InvoiceProduct::where('invoice_id',$request->input('inv_id'))
            ->where('user_id',$user_id)->with('product')
            ->get();
        return array(
            'customer'=>$customerDetails,
            'invoice'=>$invoiceTotal,
            'product'=>$invoiceProduct,
        );
    }

    function invoiceDelete(Request $request){
        DB::beginTransaction();
        try {
            $user_id=$request->header('id');
            InvoiceProduct::where('invoice_id',$request->input('inv_id'))
                ->where('user_id',$user_id)
                ->delete();
            Invoice::where('id',$request->input('inv_id'))->delete();
            DB::commit();
            return 1;
        }
        catch (Exception $e){
            DB::rollBack();
            return 0;
        }
    }
    
    
    
    //Extra methods for admin 
    function  invoiceDispayToAdmin(Request $request){
         return Invoice::where('delivery_status','pending')->orWhere('payment_status','pending')->with('user')->get(); 

    }

    function updateInvoiceFromAdmin(Request $request){
        $id = $request->input('id');
        //console.log(error);
        return Invoice::where('id', $id)->update(['delivery_status'=>$request->input("delivery_status"),
                                                     "payment_status" =>$request->input("payment_status")
    ]);
    }
}



