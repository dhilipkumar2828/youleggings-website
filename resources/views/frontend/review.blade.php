 <?php
 
 $product_review = DB::table('client_feedback')->where('status', 'accept')->orderBy('id', 'desc')->get();
 
 ?>

 @if (count($product_review) > 0)

     @foreach ($product_review as $reviews)
         <div class="product-review-item new_review ">

             <div class="product-review-top">

                 <div class="product-review-thumb">

                     <img src="{{ asset('frontend/img/shop/product-details/review_img.png') }}" alt="Images" width=50>

                 </div>

                 <div class="product-rating product-review-content">

                     <h6 class="product-review-name d-block">{{ $reviews->name }}</h6>

                     <div class="product-review-icon">

                         <label class="rating-label">

                             <span class="d-none">{{ $reviews->rate }} Ratings </span>

                             <input class="rating" max="5"
                                 oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5"
                                 style="--value:{{ $reviews->rate }}" type="range" value="2.5" disabled>

                     </div>

                     <p class="desc">{{ strip_tags($reviews->feedback) }}</p>

                 </div>

             </div>

         </div>
     @endforeach
 @else
     <p>No reviews yet</p>

 @endif
