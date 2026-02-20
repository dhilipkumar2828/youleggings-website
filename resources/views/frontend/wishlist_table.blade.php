          <!--== Start Wishlist Area Wrapper ==-->

          <section class="section-space padd-tb-60 wishlisttable_render">

              @if (Auth::guard('users')->check() || Auth::guard('guest')->check())

                  <div class="container">

                      <div class="shopping-wishlist-form table-responsive">

                          <!-- <h2 class="title text-center">Cart</h2> -->

                          @if (count($wishlist) > 0)

                              <form action="#" method="post">

                                  <table class="table text-center">

                                      <thead>

                                          <tr>

                                              <th class="product-thumbnail" style="width: 80px">Product</th>

                                              <th class="product-name" style="width: 250px">Description</th>

                                              <th class="product-price" style="width: 100px">Price</th>

                                              <!-- <th class="product-add-to-cart">&nbsp;</th> -->
                                              <th class="product-add-to-cart" style="width: 200px">&nbsp;</th>
                                              <th class="product-remove" style="width: 50px">Remove </th>
                                          </tr>

                                      </thead>

                                      <tbody>
                                          @php
                                              $photo = [];
                                          @endphp
                                          @foreach ($wishlist as $key => $w)
                                              @php

                                                  $productvariant = DB::table('product_variants')
                                                      ->where('id', $w->rowId)
                                                      ->first();

                                                  $product = DB::table('products')
                                                      ->where('id', $w->product_id)
                                                      ->first();

                                                  $regular_price = '';
                                                  if ($product->discount_type === 'fixed') {
                                                      $regular_price = number_format(
                                                          $productvariant->regular_price - $product->discount,
                                                          2,
                                                      );
                                                  } else {
                                                      $discount =
                                                          ($productvariant->regular_price / 100) * $product->discount;
                                                      $regular_price = number_format(
                                                          $productvariant->regular_price - $discount,
                                                          2,
                                                      );
                                                  }

                                                  $A_prodimg = explode(',', $productvariant->photo);
                                                  array_push($photo, $A_prodimg[0]);
                                              @endphp

                                              <!-- cart modal -->

                                              <aside class="product-action-modal modal fade"
                                                  id="action-CartAddModal1_{{ $product->id }}" tabindex="-1"
                                                  aria-hidden="true">

                                                  <div class="modal-dialog modal-dialog-centered">

                                                      <div class="modal-content">

                                                          <div class="modal-body">

                                                              <div class="product-action-view-content">

                                                                  <button type="button" class="btn-close"
                                                                      data-bs-dismiss="modal">

                                                                      <i class="fa fa-times"></i>

                                                                  </button>

                                                                  <div
                                                                      class="modal-action-messages cart_title_{{ $product->id }}">

                                                                  </div>

                                                                  <div class="modal-action-product">

                                                                      <div class="thumb" style="padding:10px 0px">

                                                                          <img src="{{ $photo[$key] }}"
                                                                              alt="Organic Food Juice" width="466"
                                                                              height="320">

                                                                      </div>

                                                                      <h4 class="product-name">{{ $product->name }}</h4>

                                                                  </div>

                                                              </div>

                                                          </div>

                                                      </div>

                                                  </div>

                                              </aside>

                                              <!-- End cart  modal -->

                                              <tr class="tbody-item">

                                                  <td class="product-thumbnail">

                                                      <div class="thumb wishlist-img-box" style="padding:10px 0px">

                                                          <a href="single_products/?id={{ $product->id }}">

                                                              <img src="{{ $photo[$key] }}" width="68"
                                                                  height="84" alt="Image-HasTech">

                                                          </a>

                                                      </div>

                                                  </td>

                                                  <td class="product-name">

                                                      <a class="title" style="white-space: nowrap;"
                                                          href="single_products/?id={{ $product->id }}">{{ $product->name }}</a>

                                                  </td>

                                                  <td class="product-price">

                                                      <span class="price">₹</span><span>{{ $regular_price }}</span>

                                                  </td>

                                                  <!-- <td class="product-stock-status">

                                <span class="wishlist-in-stock">In Stock</span>

                            </td> -->

                                                  <td class="product-add-to-cart">

                                                      <button type="button"
                                                          class="default-btn btn-shop-cart wishlist_tocart"
                                                          data-product_id="{{ $product->id }}"
                                                          style="white-space: nowrap;">Add to Cart</button>

                                                  </td>
                                                  <td class="product-remove">
                                                      <span class="btnde remove">
                                                          <input type="hidden" name="product_varient_id"
                                                              id="product_varient_id" value="{{ $w->rowId }}">
                                                          <a class="remove text-white remove wishlistremove"
                                                              data-product_id="{{ $product->id }}"
                                                              href="javascript:void(0)"><svg
                                                                  xmlns="http://www.w3.org/2000/svg" width="24"
                                                                  height="24" viewBox="0 0 24 24"
                                                                  style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                                                  <path
                                                                      d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm4 12H8v-9h2v9zm6 0h-2v-9h2v9zm.618-15L15 2H9L7.382 4H3v2h18V4z">
                                                                  </path>
                                                              </svg></a>
                                                      </span>

                                                  </td>

                                              </tr>
                                          @endforeach

                                      </tbody>

                                  </table>

                              </form>
                          @else
                              <div class="text-center">

                                  <b>Your Wishlists is empty</b>

                              </div>

                          @endif

                      </div>

                  </div>
              @else
                  <div class="text-center">

                      <b>Please <a href="{{ url('user/auth') }}">Login</a> here to see Wishlist </b>

                  </div>

              @endif

          </section>

          <!--== End Wishlist Area Wrapper ==-->
