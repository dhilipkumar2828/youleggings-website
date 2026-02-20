@php
    $total_Amt = number_format($shipping + $sub_amt, 2, '.', '');
    $deliverycharges = '0';
    $shipping_charges = '0';
    $deliverydetails = DB::table('shippingcharges')
        ->where('from', '<=', $sub_amt)
        ->where('to', '>=', $sub_amt)
        ->first();
    if (!empty($deliverydetails)) {
        $deliverycharges = $deliverydetails->amount;
    }

    if ($deliverycharges) {
        $shipping_charges = number_format($deliverycharges + $shipping, 2, '.', '');
        $total_Amt = number_format($deliverycharges + $sub_amt, 2, '.', '');
    }

    if (count($coupon) > 0) {
        $coupan_id = $coupon['id'];
        $coupan_details = DB::table('coupon')->where('id', $coupan_id)->first();
        if (auth()->guard('users')->user()) {
            $customer_id = auth()->guard('users')->user()->id;
        } else {
            $customer_id = 0;
        }

        $couponProductId = $coupon['product_id'];
        if ($couponProductId > 0) {
            $cartDataa = DB::table('cart_tables')
                ->where('customer_id', $customer_id)
                ->where('product_id', $couponProductId)
                ->first();
            if ($cartDataa != '') {
                $cartProductEachPrice = $cartDataa->product_qty * $cartDataa->price;

                if ($coupan_details->offer_details == 1) {
                    $discount_Amt = $cartProductEachPrice - $coupon['discount'];
                } else {
                    $discount_Amt = number_format(($cartProductEachPrice * $coupon['discount']) / 100, 2, '.', '');
                }
            }
        } else {
            if ($coupan_details->offer_details == 1) {
                $discount_Amt = $coupon['discount'];
            } else {
                $discount_Amt = number_format(($sub_amt * $coupon['discount']) / 100, 2, '.', '');
            }
        }
    }
@endphp

<div class="col-12 col-lg-12">

    <div class="cart-totals-wrap">

        <h2 class="title">Cart Totals</h2>

        <table>

            <tbody>

                <tr class="cart-subtotal">

                    <th>Subtotal</th>

                    <td>

                        <span class="amt_symbol">₹</span><span> {{ number_format($sub_amt, 2, '.', '') }}</< /span>

                    </td>

                </tr>

                <!---
            <tr class="shipping-totals">

                <th>Delivery Charges</th>

                <td>

                    <ul class="shipping-list m-0">

                         <li class="radio">

                            <label for="radio1"><span class="amt_symbol">₹ {{ number_format($deliverycharges) }}</</span></label>

                        </li>

                    </ul>

                </td>

            </tr>
            ---->

                <tr class="order-total">
                    <th>Coupon Applied</th>
                    <td>
                        @if (session('coupon'))
                            <span
                                class="amount amt_symbol">₹{{ number_format(session('coupon')['discount'], 2) }}</span>
                        @else
                            <span class="amount amt_symbol">₹0</span>
                        @endif
                    </td>
                </tr>

                <tr class="order-total">
                    <th>Total</th>
                    <td>
                        @if (session('coupon'))
                            <?php
                            // Debugging output: Check if the coupon data is passed correctly
                            $sub_amt = (float) $sub_amt;
                            $deliverycharges = (float) $deliverycharges;
                            $discount_Amt = (float) session('coupon')['discount'];
                            // Calculate the total after discount
                            $total_amount = $sub_amt - $discount_Amt;
                            ?>
                            <span class="amount amt_symbol">₹{{ number_format($total_amount, 2) }}</span>
                        @else
                            <?php
                            // Calculate total without any coupon applied
                            $sub_amt = (float) $sub_amt;
                            $deliverycharges = (float) $deliverycharges;
                            // Total without discount
                            $total_amount = $sub_amt;
                            ?>
                            <span class="amount amt_symbol">₹{{ number_format($total_amount, 2) }}</span>
                        @endif
                    </td>
                </tr>

            </tbody>

        </table>

        <div class="text-start mt-4">

            <a href="{{ url('view/checkout') }}" class="default-btn">Proceed to checkout</a>

        </div>

    </div>

</div>
