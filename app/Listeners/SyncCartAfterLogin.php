<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\CartTable;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Login;

class SyncCartAfterLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Login  $event
     * @return void
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        $sessionCart = session()->get('cart', []);
        if (!empty($sessionCart)) {
//$cart = CartTable::where('customer_id',$user->id)->get();

            // Step 1: Delete existing DB cart entries for this user
            CartTable::where('customer_id', $user->id)->delete();

            // Step 2: Save session cart to DB
            foreach ($sessionCart as $productId => $item) {
                CartTable::create([
                    'customer_id' => $user->id,
                    'product_id' => $item['product_id'],
                    'product_varient' => $item['product_varient'],
                    'arrtibute_name'  => $item['attribute_name'] ?? '',
                    'product_qty' => $item['product_qty'],
                    'product_name' => $item['product_name'],
                    'product_color' => $item['product_color'],
                    'price' => $item['price'],
                    'status' => $item['status']
                    // Add any other fields as needed
                ]);
            }

            // Step 3: Clear session cart (optional)
            session()->forget('cart');
        }
        else{
             CartTable::where('customer_id', $user->id)->delete();
        }
    }
}
