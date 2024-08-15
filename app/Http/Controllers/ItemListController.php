<?php

namespace App\Http\Controllers;

use App\Models\ItemList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemListController extends Controller
{
    public function index(){

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|min:3',
            'quantity' => 'required',
            'price' => 'required',
            'total' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Please fix errors',
                'errors' => $validator->errors()
            ]);
        }

        $item_list = new ItemList();
        $item_list->item_name = $request->item_name;
        $item_list->quantity = $request->quantity;
        $item_list->price = $request->price;
        $item_list->total = $request->total;
        $item_list->save();

        return response()->json([
            'status' => true,
            'message' => 'Item Added Successfully',
            'data' => $item_list
        ]);
    }
}
