<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ShoppingList;
use App\Models\ShoppingListItem;
use App\Models\Product;

class ShoppingListController extends Controller
{
    /**
     * get the specified list.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function get(Request $request, $id)
    {
        // Get list id(s) associated with user id. 
        // Then return elements from list items and order by weight
        // TODO: Need to figure out how to auto incremenet weight column for items

        $shopping_lists = ShoppingList::where('user_id', $id)
                                        ->get();
        
        if (count($shopping_lists) > 0)
        {
            $response = array();
            foreach ($shopping_lists as $list)
            {
                $list_items = array();
                $list_items = ShoppingListItem::where('list_id', $list->id)
                                                ->orderBy('weight_on_list', 'desc')
                                                ->get();
                foreach ($list_items as $item)
                {
                    $product = Product::where('id', $item->product_id)->first();
                    $item['product_name'] = $product->name;
                    $item['product_price'] = $product->price;
                }

                $response['list_items'] = $list_items;
                $response['list_budget'] = $list->budget;
            }
            $status = 200;
        } else {
            $response['error'] = "No lists associated with that user";
            $status = 204;
        }                                   

        return response()->json($response, $status);
    }



    /**
     * Add items to the specified list.
     *
     * @param  Request  $request
     * @param  string  $user_id
     * @param  string  $list_id 
     * @return Response
     */    
    public function addToList(Request $request, $user_id, $list_id)
    {

        $items_to_add = $request->all();
        $items_to_add = $items_to_add['items'];
        if (count($items_to_add) == 0)
        {
            $response['error'] = "No items given to add";
            return response()->json($response, 200);
        }

        $shopping_list = ShoppingList::where('id', $list_id)
                                        ->first();
        $existing_shopping_list_items = ShoppingListItem::where('list_id', $shopping_list->id)
                                                ->get();

        $new_item = null;

        // I guarantee there will always be a product for an input                                     
        foreach ($items_to_add as $new_item) 
        {
            $product = Product::where('name', $new_item)->first();
            if (is_null($product))
            {
                Product::create(['name' => $new_item]);
            }
        }

        foreach ($items_to_add as $new_item)
        {
            $new_product = Product::where('name', $new_item)->first();
            $is_in_list = false;
            foreach ($existing_shopping_list_items as $item)
            {
                $existing_product = Product::where('id', $item->product_id)->first();
                if (strcmp($existing_product->name, $new_item) === 0)
                {
                    $is_in_list = true;
                }
            }

            if (!$is_in_list)
            {
    
                $new_item = ShoppingListItem::create(['list_id' => $shopping_list->id, 
                                        'product_id' => $new_product->id, 
                                        'is_purchased' => false, 
                                        'weight_on_list' => 0]);
                
            }
        }
        $response['added_item'] = $new_item;
        $response['message'] = "New items added to list";
        return response()->json($response, 200);
    }

    /**
     * Add items to the specified list.
     *
     * @param  Request  $request
     * @param  string  $user_id
     * @param  string  $list_id 
     * @param int $item_id
     * @return Response
     */ 
    public function removeFromList(Request $request, $user_id, $list_id, $item_id) 
    {
        // $items_to_remove = $request->all();
        $items_to_remove = $item_id;
        if (!$items_to_remove)
        {
            $response['error'] = "No items given to remove";
            return response()->json($response, 200);
        }

        ShoppingListItem::destroy($items_to_remove);        

        $response['removed_item'] = $items_to_remove;
        $response['message'] = "Items successfully deleted";
        return response()->json($response, 200);
        
    }
}




