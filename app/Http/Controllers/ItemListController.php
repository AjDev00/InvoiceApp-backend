<?php

namespace App\Http\Controllers;

use App\Models\ItemList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemListController extends Controller
{
    public function index(){

    }


    //save a single item list.
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required|exists:invoices,id', //make sure the invoice id exists.
            'item_name' => 'required|array|min:1',
            'quantity' => 'required|array|min:1',
            'price' => 'required|array|min:1',
            'total' => 'required|array|min:1',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix errors',
                'errors' => $validator->errors()
            ]);
        }
        
        $item_list_array = []; //empty array to hold the item list.
        
        //foreach item list, there should be a quantity, price and total.
        foreach ($request->item_name as $key => $item_name) { 
            $item_list = new ItemList();

            $item_list->item_name = $item_name;
            $item_list->invoice_id = $request->invoice_id; //post the invoice id.
            $item_list->quantity = $request->quantity[$key];
            $item_list->price = $request->price[$key];
            $item_list->total = $request->total[$key];
            $item_list->save();
            $item_list_array[] = $item_list;
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Items Added Successfully',
            'data' => $item_list_array
        ]);
    }


    //update a single itemlist.
    public function update($id, Request $request){
        $item_list = ItemList::find($id);

        if($item_list === null){
            return response()->json([
                'status' => false,
                'message' => 'Item not found',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required|exists:invoices,id', //make sure the invoice id exists.
            'item_name' => 'required|array|min:1',
            'quantity' => 'required|array|min:1',
            'price' => 'required|array|min:1',
            'total' => 'required|array|min:1',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix errors',
                'errors' => $validator->errors()
            ]);
        }
        
        $item_list_array = []; //empty array to hold the item list.
        
        //foreach item list, there should be a quantity, price and total.
        foreach ($request->item_name as $key => $item_name) { 
            $item_list->item_name = $item_name;
            $item_list->invoice_id = $request->invoice_id; //post the invoice id.
            $item_list->quantity = $request->quantity[$key];
            $item_list->price = $request->price[$key];
            $item_list->total = $request->total[$key];
            $item_list->save();
            $item_list_array[] = $item_list;
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Items Updated Successfully',
            'data' => $item_list_array
        ]);
    }
}
