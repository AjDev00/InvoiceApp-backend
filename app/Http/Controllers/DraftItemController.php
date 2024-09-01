<?php

namespace App\Http\Controllers;

use App\Models\Draft;
use App\Models\DraftItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DraftItemController extends Controller
{

    //show all drafts.
    public function index(){
        $draft = Draft::with('draftItem')->get();
        $count = $draft->count();

        if(empty($draft)){
            return response()->json([
                'status' => false,
                'message' => 'No Drafts'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $draft,
            'draft_count' => $count,
        ]);
    }


    //insert drafts.
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
            $draft_item->draft_id = $request->draft_id; //post the draft id.
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


    //show a single draft.
    public function show($id){
        $draft = Draft::with('draftItem')->find($id);

        if(!$draft){
            return response()->json([
                'status' => false,
                'message' => 'Draft not found!'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $draft
        ]);
    }


    //update a single draft-item.
    public function update($draft_id, Request $request){
        // Fetch all items with the same draft_id
        $items = DraftItem::where('draft_id', $draft_id)->get();

        // Check if items were found for the given invoice_id
        if ($items->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No items found for the given draft ID',
            ]);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
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
            $newItem = new DraftItem();
            $newItem->draft_id = $draft_id; // Set the same invoice ID for the new items
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


    //delete a draft.
    public function destroy($id){
        $draft = Draft::with('draftItem')->find($id);

        if(!$draft){
            return response()->json([
                'status' => false,
                'message' => 'Draft not found!'
            ]);
        }

        $draft->delete();

        return response()->json([
            'status' => true,
            'message' => 'Draft deleted successfully!'
        ]);
    }
}
