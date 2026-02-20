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

class AutoWishlist extends Command

{

    /**

     * The name and signature of the console command.

     *

     * @var string

     */

    protected $signature = 'auto:wishlistsend';

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

        for($j=0;$j<count($wishlists);$j++){

            $wishlistuser=User::where('id',$wishlists[$j]->customer_id)->first();

            $diff = now()->diffInDays($wishlists[$j]->updated_at);

              $wishlists_table=Wishlist::where('status','active')->where('customer_id',$wishlistuser->id)->get();

          //    if($diff >= 2){

           Mail::to($wishlistuser->email)->send(new WishlistMail($wishlists_table));

                      //}

            DB::table('wishlists')->where('id',$wishlist->id)->update(['updated_at'=>$current_timestamp->toDateTimeString()]);

                    }

        return 0;

     }

}
