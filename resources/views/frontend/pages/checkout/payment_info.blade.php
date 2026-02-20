<table class="table checkouttablle">

    <thead>

        <tr>

            <th class="product-name">Product Name</th>

            <th class="product-total">Total</th>

        </tr>

    </thead>

    <tbody class="table-body">

        @php

            $count = 0;

            $discount_amount = 0;

        @endphp

        @foreach ($products as $pro)
            @php

                $productvariant = DB::table('product_variants')->where('product_id', $pro->product_id)->first();

            @endphp

            <tr class="cart-item">

                <input type="hidden" name="product_id[]" class="product_id" value="{{ $pro->product_id }}">

                <input type="hidden" name="product_qty[]" class="product_qty" value="{{ $pro->product_qty }}">

                <td class="product-name">{{ $pro->product_name }}<span class="product-quantity"> ×
                        {{ $pro->product_qty }}</span>

                </td>

                <td class="product-total amt_symbol">₹
                    {{ number_format($pro->price * (int) $pro->product_qty, 2, '.', '') }}

                </td>

            </tr>

            @php

                $discount_amount += 0;

                $count++;

            @endphp
        @endforeach

    </tbody>

    <tfoot class="table-foot">

        <tr class="cart-subtotal">

            <th>Sub total</th>

            <td class="amt_symbol">₹ {{ number_format($sub_amt, 2, '.', '') }}</td>

        </tr>
        <?php
        
        $gst11 = '';
        $gst = '';
        if (!empty($shipping)) {
            $gst11 = $shipping / 2;
        }
        
        $deliverycharges11 = '';
        if (!empty($deliverycharges)) {
            $deliverycharges11 = $deliverycharges;
        }
        
        ?>
        <!----
        <tr class="shipping">

            <input type="hidden" name="shipping_type" class="shipping_type" value="">

            <th>GST</th>

            <td class="amt_symbol" >
                    <div class="tamilnadu" style="display:none;">
                     CGST ₹ <span id="gst1">{{ $gst11 }}</span> SGST ₹ <span id="gst2">{{ $gst11 }}</span>
                    </div>
                     <div class="others" style="display:none;">
                     IGST ₹ <span id="gst">{{ $gst }}</span>
                    </div>
           </td>

        </tr>
        ---->
        <tr class="shipping">

            <th>Shipping Charges </th>

            <td class="amt_symbol">₹ <span id="shipping_amount">0.00</span></td>
            <input type="hidden" id="deliver_charge" value="{{ $deliverycharges11 }}">
        </tr>
        <tr class="shipping">

            <th>Discount Amount </th>

            <td class="amt_symbol">₹ <span id="ship_discount_amount1">0.00</span></td>
            <input type="hidden" id="ship_discount_amount" name="ship_discount_amount">
        </tr>

        <tr>
            <th>Coupon Applied</th>
            <?php
            $discount = 0;
            if (count($coupon) > 0) {
                $coupan_id = $coupon['id'];
                $coupan_details = DB::table('coupon')->where('id', $coupan_id)->first();
            
                // Debugging output
                //var_dump($sub_amt, $coupon['discount'], $coupan_details->offer_details);
            
                // Cast to numeric values
                $sub_amt = (float) $sub_amt;
                $coupon_discount = (float) $coupon['discount'];
            
                $customer_id = auth()->guard('users')->user()->id;
            
                $couponProductId = $coupon['product_id'];
                $productIds = explode(',', $couponProductId);
            
                // Ensure $productIds is an array before passing it to whereIn
            
                if (is_array($productIds) && !empty($productIds) && max($productIds) > 0) {
                    $cartDataa = DB::table('cart_tables')
                        ->where('customer_id', $customer_id)
                        ->whereIn('product_id', $productIds) // Use the array of product IDs
                        ->first();
            
                    // $cartProductEachPrice = ($pro->product_qty * $pro->price);
            
                    $cartProductEachPrice = $cartDataa->product_qty * $cartDataa->price;
            
                    if ($coupan_details->offer_details == 1) {
                        $discount = $cartProductEachPrice - $coupon['discount'];
                    } else {
                        $discount = number_format(($cartProductEachPrice * $coupon['discount']) / 100, 2, '.', '');
                    }
                } else {
                    if ($coupan_details->offer_details == 1) {
                        $discount = $coupon_discount;
                    } else {
                        $discount = number_format(($sub_amt * $coupon_discount) / 100, 2, '.', '');
                    }
                }
                $discount_Amt = $discount;
            }
            ?>
            <input type="hidden" id="discountvalus" name="discountvalus"
                value="{{ session('coupon')['discount'] ?? 0 }}">

            <td>
                @if (session('coupon'))
                    <span class="amount amt_symbol"
                        id="coup">₹{{ number_format(session('coupon')['discount'], 2) }}</span>
                @else
                    <span class="amount amt_symbol" id="coup">₹0</span>
                @endif
            </td>

            <input type="hidden" id="sub_amount" value="{{ $sub_amt }}">

            <input type="hidden" id="shipping_charge" value="">

            <input type="hidden" id="discount_amount" value="">

            <?php
            $discountAmount = 0;
            $deliverycharges = 0;
            ?>

        <tr class="order-total">
            <th>Total</th>
            <td>
                @if (session('coupon'))
                    <?php
                    // Get the coupon discount from the session
                    $discountAmount = (float) session('coupon')['discount'];
                    
                    // Calculate the total after the coupon discount (as per Code 2 logic)
                    $sub_amt = (float) $sub_amt;
                    $deliverycharges = (float) $deliverycharges;
                    
                    // Applying the discount to the subtotal and adding delivery charges
                    $total = $sub_amt - $discountAmount;
                    ?>
                    <span class="amount amt_symbol" id="newamount">₹{{ number_format($total, 2) }}</span>
                @else
                    <?php
                    // If no coupon is applied, the total is just the subtotal + delivery charges (as in Code 1)
                    $sub_amt = (float) $sub_amt;
                    $deliverycharges = (float) $deliverycharges;
                    $total = $sub_amt + $deliverycharges;
                    ?>
                    <span class="amount amt_symbol" id="newamount">₹{{ number_format($total, 2) }}</span>
                @endif
            </td>
        </tr>

    </tfoot>

</table>
