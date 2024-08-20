<?php

namespace App\Http\Controllers;

use App\Models\DraftItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DraftItemController extends Controller
{
    public function index(){
        
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'draft_id' => 'required|exists:drafts,id', //make sure the invoice id exists.
            'item_name' => 'array',
            'quantity' => 'array',
            'price' => 'array',
            'total' => 'array',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix errors',
                'errors' => $validator->errors()
            ]);
        }
        
        $draft_item_array = []; //empty array to hold the item list.
        
        //foreach item list, there should be a quantity, price and total.
        foreach ($request->item_name as $key => $item_name) { 
            $draft_item = new DraftItem();

            $draft_item->item_name = $item_name;
            $draft_item->draft_id = $request->draft_id; //post the invoice id.
            $draft_item->quantity = $request->quantity[$key];
            $draft_item->price = $request->price[$key];
            $draft_item->total = $request->total[$key];
            $draft_item->save();
            $draft_item_array[] = $draft_item;
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Items Added Successfully',
            'data' => $draft_item_array
        ]);
    }
}
