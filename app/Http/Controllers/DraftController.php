<?php

namespace App\Http\Controllers;

use App\Models\Draft;
use Illuminate\Http\Request;
use Carbon;
use Illuminate\Support\Facades\Validator;

class DraftController extends Controller
{
    public function index(){

    }


    //save/insert drafts.
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'bill_from_street_address' => 'required',
            'bill_to_invoice_date' => 'date',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Please fix the errors',
                'errors' => $validator->errors()
            ]);
        }

        $draft = new Draft();
        $draft->bill_from_street_address = $request->bill_from_street_address;
        $draft->bill_from_city = $request->bill_from_city;
        $draft->bill_from_post_code = $request->bill_from_post_code;
        $draft->bill_from_country = $request->bill_from_country;
        $draft->bill_to_client_name = $request->bill_to_client_name;
        $draft->bill_to_client_email = $request->bill_to_client_email;
        $draft->bill_to_street_address = $request->bill_to_street_address;
        $draft->bill_to_city = $request->bill_to_city;
        $draft->bill_to_post_code = $request->bill_to_post_code;
        $draft->bill_to_country = $request->bill_to_country;
        $draft->bill_to_invoice_date = $request->bill_to_invoice_date;
        $draft->bill_to_payment_terms = $request->bill_to_payment_terms;
        $draft->bill_to_project_desc = $request->bill_to_project_desc;
        $draft->save();

        return response()->json([
            'status' => true,
            'message' => 'Draft Successfully Saved',
            'data' => $draft
        ]);
    }
}
