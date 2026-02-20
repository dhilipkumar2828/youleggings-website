<?php

namespace App\Console\Commands;

use Carbon\Carbon;

use Carbon\CarbonPeriod;

use Illuminate\Console\Command;

use Mail;

use DB;

use App\Models\User;

use App\Models\CartTable;

use App\Models\Wishlist;

use App\Mail\CartMail;

use App\Mail\WishlistMail;

class AutoCart extends Command

{

    /**

     * The name and signature of the console command.

     *

     * @var string

     */

    protected $signature = 'auto:cartsend';

    /**

     * The console command description.

     *

     * @var string

     */

    protected $description = 'Command description';

    /**

     * Execute the console command.

     *

     * @return int

     */

    public function handle()

    {

        $carts_table=CartTable::where('status','active')->get();

        $wishlists=Wishlist::where('status','active')->get();

        // $current_timestamp=Carbon::now();

        for($i=0;$i<count($carts_table);$i++){

            $user=User::where('id',$carts_table[$i]->customer_id)->first();

            $carts=CartTable::where('status','active')->where('customer_id',$user->id)->get();

            //wishlist mail

             $diff = now()->diffInDays($carts_table[$i]->updated_at);

       //    if($diff >= 2){

             Mail::to($user->email)->send(new CartMail($carts));

        //      DB::table('cart_tables')->where('id',$carts_table[$i]->id)->update(['updated_at'=>$current_timestamp->toDateTimeString()]);

//}

        }

        return 0;

     }

}
