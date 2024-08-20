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
            'item_name' => 'required|array|min:1',
            'item_name.*' => 'required|min:3',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
            'price' => 'required|array|min:1',
            'price.*' => 'required|numeric|min:0.01',
            'total' => 'required|array|min:1',
            'total.*' => 'required|numeric|min:0.01'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix errors',
                'errors' => $validator->errors()
            ]);
        }
        
        $item_list_array = [];
        
        foreach ($request->item_name as $key => $item_name) {
            $item_list = new ItemList();
            
            $item_list->item_name = $item_name;
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
}
