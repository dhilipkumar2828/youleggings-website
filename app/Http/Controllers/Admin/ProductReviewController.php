<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReviews;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReviews::with('productname')->orderBy('id', 'desc')->get();
        return view('backend.product_review.index', compact('reviews'));
    }

    public function update(Request $request, $id)
    {
        $review = ProductReviews::findOrFail($id);
        $review->update($request->all());
        return back()->with('success', 'Review updated successfully');
    }

    public function destroy($id)
    {
        $review = ProductReviews::findOrFail($id);
        $review->delete();
        return back()->with('success', 'Review deleted successfully');
    }

    public function reviewStatus(Request $request)
    {
        if ($request->mode == 'true') {
            $status = 'active';
        } else {
            $status = 'inactive';
        }
        ProductReviews::where('id', $request->id)->update(['status' => $status]);
        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }
}
