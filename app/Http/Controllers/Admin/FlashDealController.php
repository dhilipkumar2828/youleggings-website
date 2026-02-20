<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlashDeal;
use Illuminate\Support\Facades\Session;

class FlashDealController extends Controller
{
    public function index()
    {
        $deals = FlashDeal::orderBy('id', 'desc')->get();
        return view('backend.flash_deal.index', compact('deals'));
    }

    public function create()
    {
        return view('backend.flash_deal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'deal_end_date' => 'nullable|date',
            'banner_image' => 'nullable|string',
            'deal_image_1' => 'nullable|string',
        ]);

        $deal = new FlashDeal();
        $deal->title = $request->title;
        $deal->subtitle = $request->subtitle;
        $deal->description = $request->description;
        $deal->banner_image = $request->banner_image;
        $deal->deal_title = $request->deal_title ?? 'HOT DEAL';
        $deal->discount_value = $request->discount_value;
        $deal->deal_end_date = $request->deal_end_date;
        $deal->deal_image_1 = $request->deal_image_1;
        $deal->status = $request->status ?? 'active';
        $deal->save();

        Session::flash('success', 'Flash Deal created successfully!');
        return redirect()->route('flash-deals.index');
    }

    public function edit($id)
    {
        $deal = FlashDeal::findOrFail($id);
        return view('backend.flash_deal.edit', compact('deal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'deal_end_date' => 'nullable|date',
            'banner_image' => 'nullable|string',
        ]);

        $deal = FlashDeal::findOrFail($id);
        $deal->title = $request->title;
        $deal->subtitle = $request->subtitle;
        $deal->description = $request->description;
        $deal->banner_image = $request->banner_image;
        $deal->deal_title = $request->deal_title;
        $deal->discount_value = $request->discount_value;
        $deal->deal_end_date = $request->deal_end_date;
        $deal->deal_image_1 = $request->deal_image_1;
        $deal->status = $request->status;
        $deal->save();

        Session::flash('success', 'Flash Deal updated successfully!');
        return redirect()->route('flash-deals.index');
    }

    public function destroy($id)
    {
        $deal = FlashDeal::findOrFail($id);
        $deal->delete();
        Session::flash('success', 'Flash Deal deleted successfully!');
        return redirect()->back();
    }
}
