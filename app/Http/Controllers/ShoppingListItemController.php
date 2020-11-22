<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingListItem;

class ShoppingListItemController extends Controller
{
    
    /**
     * Add items to the specified list.
     *
     * @param  Request  $request
     * @param  string  $user_id
     * @param  string  $list_id 
     * @param int $item_id
     * @return Response
     */ 
    public function updatePurchased(Request $request, $user_id, $list_id, $item_id) 
    {
        $item_to_update = $request->all();
        $item_to_update = $item_to_update['purchased'];
        if (!$item_to_update)
        {
            $response['error'] = "No items given to remove";
            return response()->json($response, 200);
        }

        $shopping_item = ShoppingListItem::where('id', $item_id)->first();
        $shopping_item->is_purchased = $item_to_update;
        $shopping_item->save();

        $response['updated_item'] = $shopping_item;
        $response['message'] = "Item successfully updated";
        return response()->json($response, 200);
        
    }
}
