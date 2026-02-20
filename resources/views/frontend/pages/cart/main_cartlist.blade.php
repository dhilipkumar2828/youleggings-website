<div class="shopping-cart-form table-responsive">
    <!-- <h2 class="title text-center">Cart</h2> -->
    <form action="#" method="post">
        <table class="table text-center border">
            <thead>
                <tr>

                    <th class="product-thumbnail">Product</th>
                    <th class="product-name">Name</th>

                    <th class="product-price">Unit Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-subtotal">Total</th>
                    <!---
                    <th class="product-remove"> </th>
                    --->
                </tr>
            </thead>
            <tbody>

                @php
                    // Fetch color attributes, trying both uppercase and lowercase keys
                    $colorAttribute = DB::table('attributes')->where('attribute_type', 'COLOR')->first();
                    if (!$colorAttribute) {
                        $colorAttribute = DB::table('attributes')->where('attribute_type', 'color')->first();
                    }

                    $availableColors = [];
                    if ($colorAttribute) {
                        // Check if value is JSON
                        $decoded = json_decode($colorAttribute->value, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $availableColors = $decoded;
                        } else {
                            // Fallback to comma-separated if not JSON
                            $availableColors = explode(',', $colorAttribute->value);
                        }
                    }

                    // Sort colors by length descending to match longest first
                    usort($availableColors, function ($a, $b) {
                        return strlen($b) - strlen($a);
                    });
                @endphp

                @foreach ($carts as $key => $aData)
                    @if (auth()->guard('users')->user() || auth()->guard('guest')->user())
                        <?php
                        $stockOutt = false;
                        $stockOutCss = '';
                        if ($aData->in_stock < $aData->product_qty) {
                            $stockOutt = true;
                            $stockOutCss = 'background:lightgrey;color:red;pointer-events:none;';
                        }
                        ?>
                        <tr class="tbody-item" style="{{ $stockOutCss }}">

                            <td class="product-thumbnail">
                                <div class="thumb">
                                    <div class="image-box">
                                        <img src="{{ url($productimage[$key]) }}" width="68" height="84"
                                            alt="Image-HasTech">

                                    </div>
                                    <?php
                                    if ($stockOutt) {
                                        echo 'Out of Stock';
                                    }
                                    ?>
                                </div>
                            </td>
                            <?php
                            $in_stock = 0;
                            if ($aData->product_id) {
                                $p_id = $aData->product_id;
                                $product = DB::table('products')->where('status', 'active')->where('id', $p_id)->first();
                                if (!empty($product)) {
                                    $product_variants = DB::table('product_variants')->where('product_id', $product->id)->where('variants', $aData->arrtibute_name)->first();
                                    if (!empty($product_variants)) {
                                        $in_stock = $product_variants->in_stock;
                                    }
                                }
                            }
                            ?>
                            <td class="product-name">
                                <a class="title"
                                    href="{{ url('products/') . '/' . $product->slug }}">{{ $aData->product_name }} </a>

                                @php
                                    $sizeVal = $aData->arrtibute_name;
                                    $colorVal = $aData->product_color;

                                    if (empty($colorVal)) {
                                        foreach ($availableColors as $color) {
                                            if (stripos($sizeVal, $color) !== false) {
                                                $colorVal = $color;
                                                break;
                                            }
                                        }
                                    }

                                    if (empty($colorVal)) {
                                        $p_variant = DB::table('product_variants')
                                            ->where('product_id', $aData->product_id)
                                            ->where('variants', $aData->arrtibute_name)
                                            ->first();
                                        if ($p_variant && !empty($p_variant->colors)) {
                                            $colorVal = $p_variant->colors;
                                        }
                                    }
                                    if (!empty($colorVal)) {
                                        $sizeVal = str_ireplace($colorVal, '', $sizeVal);
                                        $sizeVal = trim($sizeVal, ' ,');
                                    }
                                @endphp
                                <div>{{ $sizeVal }} {{ $colorVal }}</div>
                            </td>

                            <td class="product-price">
                                <span class="price">₹</span><span>{{ number_format($aData->price, 2, '.', '') }}</span>
                            </td>
                            <td class="product-quantity">
                                <div class="cart-page-pro-qty">
                                    <input type="hidden" id="count_prod_qty{{ $aData->product_varient }}"
                                        class="count_prod_qty" value="{{ isset($cart_get) ? $cart_get : 01 }}"
                                        data-product_id="{{ $aData->product_varient }}">

                                    <input type="text" id="quantity{{ $aData->product_varient }}" title="Quantity"
                                        class="quantity count_prod_qty{{ $aData->product_id }}"
                                        data-product_id="{{ $aData->product_varient }}"
                                        value="{{ $aData->product_qty }}" diabled>
                                    <div class="dec qty-btn cart_rendercount"
                                        data-product_price="{{ number_format($aData->price, 2, '.', '') }}"
                                        data-product_id="{{ $aData->product_varient }}" data-type="dec"
                                        data-product_varient_id="{{ $aData->product_varient }}"
                                        data-quantity="{{ $in_stock }}">-</div>
                                    <div class="inc qty-btn cart_rendercount"
                                        data-product_price="{{ number_format($aData->price, 2, '.', '') }}"
                                        data-product_id="{{ $aData->product_varient }}" data-type="inc"
                                        data-product_varient_id="{{ $aData->product_varient }}"
                                        data-quantity="{{ $in_stock }}">+</div>
                                </div>
                            </td>
                            <td class="product-subtotal">
                                <input type="hidden" id="max_qty" name="max_qty" value="{{ $in_stock }}">
                                <span class="product_rate_{{ $aData->product_varient }}">{{ $aData->product_qty }} x
                                    <span class="price">₹</span>{{ number_format($aData->price, 2, '.', '') }}</span>
                            </td>
                        </tr>
                    @else
                        @if (!empty($carts[$key]['product_id']))
                            @php
                                $stockOutt = false;
                                $stockOutCss = '';
                                if ($carts[$key]['in_stock'] < $carts[$key]['product_qty']) {
                                    $stockOutt = true;
                                    $stockOutCss = 'background:lightgrey;color:red;pointer-events:none;';
                                }
                            @endphp
                            <tr class="tbody-item" style="{{ $stockOutCss }}">

                                <td class="product-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ url($productimage[$key]) }}" width="68" height="84"
                                            alt="Image-HasTech">
                                    </div>

                                    <?php
                                    if ($stockOutt) {
                                        echo 'Out of Stock';
                                    }
                                    ?>
                                </td>
                                <td class="product-name">
                                    <?php
                                    $in_stock = 0;
                                    if (!empty($carts[$key]['product_id'])) {
                                        $p_id = $carts[$key]['product_id'];
                                        $product = DB::table('products')->where('status', 'active')->where('id', $p_id)->first();
                                        if (!empty($product)) {
                                            $product_variants = DB::table('product_variants')->where('product_id', $product->id)->where('variants', $carts[$key]['variant'])->first();
                                            if (!empty($product_variants)) {
                                                $in_stock = $product_variants->in_stock;
                                            }
                                        }
                                    }
                                    ?>
                                    <?php
                        if(!empty($carts[$key]['product_id'])){
                        ?>
                                    <a class="title"
                                        href="{{ url('products/') . '/' . $product->slug }}">{{ $carts[$key]['product_name'] }}</a>
                                    <?php } ?>
                                </td>
                                <td class="product-name">
                                    @php
                                        $gSizeVal = $carts[$key]['variant'];
                                        $gColorVal = isset($carts[$key]['product_color'])
                                            ? $carts[$key]['product_color']
                                            : '';

                                        if (empty($gColorVal)) {
                                            foreach ($availableColors as $color) {
                                                if (stripos($gSizeVal, $color) !== false) {
                                                    $gColorVal = $color;
                                                    break;
                                                }
                                            }
                                        }

                                        if (empty($gColorVal)) {
                                            $p_variant = DB::table('product_variants')
                                                ->where('product_id', $carts[$key]['product_id'])
                                                ->where('variants', $carts[$key]['variant'])
                                                ->first();
                                            if ($p_variant && !empty($p_variant->colors)) {
                                                $gColorVal = $p_variant->colors;
                                            }
                                        }
                                        if (!empty($gColorVal)) {
                                            $gSizeVal = str_ireplace($gColorVal, '', $gSizeVal);
                                            $gSizeVal = trim($gSizeVal, ' ,');
                                        }
                                    @endphp
                                    {{ $gSizeVal }}
                                </td>
                                <td class="product-name">
                                    {{ $gColorVal }}
                                </td>
                                <td class="product-price">
                                    <span
                                        class="price">₹</span><span>{{ number_format($carts[$key]['price'], 2, '.', '') }}</span>
                                </td>
                                <td class="product-quantity">
                                    <div class="cart-page-pro-qty">
                                        <input type="hidden" id="count_prod_qty{{ $carts[$key]['product_varient'] }}"
                                            class="count_prod_qty" value="{{ $carts[$key]['product_qty'] }}"
                                            data-product_id="{$carts[$key]['product_varient']}}">

                                        <input type="text" id="quantity{{ $carts[$key]['product_varient'] }}"
                                            title="Quantity"
                                            class="quantity count_prod_qty{{ $carts[$key]['product_varient'] }}"
                                            data-product_id="{{ $carts[$key]['product_varient'] }}"
                                            value="{{ $carts[$key]['product_qty'] }}" diabled>
                                        <div class="dec qty-btn cart_rendercount"
                                            data-product_price="{{ $carts[$key]['price'] }}"
                                            data-product_id="{{ $carts[$key]['product_varient'] }}" data-type="dec"
                                            data-product_varient_id="{{ $carts[$key]['product_varient'] }}"
                                            data-quantity="{{ $in_stock }}">-</div>
                                        <div class="inc qty-btn cart_rendercount"
                                            data-product_price="{{ $carts[$key]['price'] }}"
                                            data-product_id="{{ $carts[$key]['product_varient'] }}" data-type="inc"
                                            data-product_varient_id="{{ $carts[$key]['product_varient'] }}"
                                            data-quantity="{{ $in_stock }}">+</div>
                                    </div>
                                </td>
                                <td class="product-subtotal">
                                    <input type="hidden" id="max_qty" name="max_qty" value="{{ $in_stock }}">
                                    <input type="hidden" id="product_id" name="product_id"
                                        value="{{ $carts[$key]['product_id'] }}">
                                    <span class="price">₹</span><span
                                        class="product_rate_{{ $carts[$key]['product_varient'] }}">{{ $carts[$key]['product_qty'] }}
                                        x {{ number_format($carts[$key]['price'], 2, '.', '') }}</span>
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr class="tbody-item-actions d-none">
                    <td colspan="6">
                        <input type="text" name="coupontotal" id="coupantotal" value="{{ $sub_amt }}">
                        <button type="button" class="btn-update-cart">₹{{ $sub_amt }}</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
