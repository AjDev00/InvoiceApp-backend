<?php

namespace App\Http\Controllers;

use App\Models\ItemList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemListController extends Controller
{

    //get a single invoice item-list.
    public function index($invoice_id){
        $item_list = ItemList::where('invoice_id', $invoice_id)->get();

        if(!$item_list){
            return response()->json([
                'status' => false,
                'message' => 'No item with this invoice id'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $item_list
        ]);
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
    public function update($invoice_id, Request $request){
        // Fetch all items with the same invoice_id
        $items = ItemList::where('invoice_id', $invoice_id)->get();

        // Check if items were found for the given invoice_id
        if ($items->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No items found for the given invoice ID',
            ]);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
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

        $item_name_array = $request->item_name;
        $quantity_array = $request->quantity;
        $price_array = $request->price;
        $total_array = $request->total;

        $updatedItems = [];

        // Loop through existing items and update them with request data
        foreach ($items as $index => $item) {
            //check if there is a corresponding data in the request arrays.
            if (isset($item_name_array[$index])) {
                $item->item_name = $item_name_array[$index];
            }

            if (isset($quantity_array[$index])) {
                $item->quantity = $quantity_array[$index];
            }

            if (isset($price_array[$index])) {
                $item->price = $price_array[$index];
            }

            if (isset($total_array[$index])) {
                $item->total = $total_array[$index];
            }

            // Save the updated item to the database
            $item->save();
            $updatedItems[] = $item;
        }

        // Check if more items need to be added.
        for ($i = count($items); $i < count($item_name_array); $i++) {
            // Create and save new items based on remaining request data
            $newItem = new ItemList();
            $newItem->invoice_id = $invoice_id; // Set the same invoice ID for the new items
            $newItem->item_name = $item_name_array[$i];
            $newItem->quantity = $quantity_array[$i];
            $newItem->price = $price_array[$i];
            $newItem->total = $total_array[$i];
            $newItem->save(); // Save the new item to the database
            $updatedItems[] = $newItem;
        }

        return response()->json([
            'status' => true,
            'message' => 'Items Updated Successfully',
            'data' => $updatedItems
        ]);

    }


    //delete a single item.
    public function destroy($id){
        $item_list = ItemList::find($id);

        if(!$item_list){
            return response()->json([
                'status' => false,
                'message' => 'ItemList not found!'
            ]);
        }

        $item_list->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ]);

    }
    
}
