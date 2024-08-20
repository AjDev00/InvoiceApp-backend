<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\ItemList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index(){

    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'bill_from_street_address' => 'required|min:3',
            'bill_from_city' => 'required|min:3',
            'bill_from_post_code' => 'required|min:3',
            'bill_from_country' => 'required|min:3',
            'bill_to_client_name' => 'required|min:3',
            'bill_to_client_email' => 'required|email',
            'bill_to_street_address' => 'required|min:3',
            'bill_to_city' => 'required|min:3',
            'bill_to_post_code' => 'required|min:3',
            'bill_to_country' => 'required|min:3',
            'bill_to_invoice_date' => 'required|date',
            'bill_to_payment_terms' => 'required',
            'bill_to_project_desc' => 'required|min:3'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Please fix the errors',
                'errors' => $validator->errors()
            ]);
        }

        $invoice = new Invoice();
        // $item_list = new ItemList();
        
        $invoice->bill_from_street_address = $request->bill_from_street_address;
        $invoice->bill_from_city = $request->bill_from_city;
        $invoice->bill_from_post_code = $request->bill_from_post_code;
        $invoice->bill_from_country = $request->bill_from_country;
        $invoice->bill_to_client_name = $request->bill_to_client_name;
        $invoice->bill_to_client_email = $request->bill_to_client_email;
        $invoice->bill_to_street_address = $request->bill_to_street_address;
        $invoice->bill_to_city = $request->bill_to_city;
        $invoice->bill_to_post_code = $request->bill_to_post_code;
        $invoice->bill_to_country = $request->bill_to_country;
        $invoice->bill_to_invoice_date = $request->bill_to_invoice_date;
        $invoice->bill_to_payment_terms = $request->bill_to_payment_terms;
        $invoice->bill_to_project_desc = $request->bill_to_project_desc;
        $invoice->save();

        return response()->json([
            'status' => true,
            'message' => 'Invoice created successfully!',
            'data' => $invoice,
            'invoice_id' => $invoice->id //save the current invoice id.
        ]);
    }
}
