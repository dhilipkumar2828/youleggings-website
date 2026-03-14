<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Models\Category;
class BannerController extends Controller
{
  function __construct()
    {
        //  $this->middleware('permission:banner-view|banner-add|banner-edit|banner-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:banner-add', ['only' => ['create','store']]);
        //  $this->middleware('permission:banner-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:banner-delete', ['only' => ['destroy']]);
        //  $this->userid=@Auth::user()->roles[0]->id;
        //  $this->username=@Auth::user()->roles[0]->name;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

           $banners=Banner::orderBy('id','DESC')->get();
            return view('backend.banner.view',compact('banners'));

    }

    public function bannerStatus(Request $request)
    {
        $banner = Banner::findOrFail($request->id);
        $banner->status = ($banner->status == 'active') ? 'inactive' : 'active';
        $banner->save();
        
        return response()->json(['msg' => 'Status updated successfully', 'status' => true]);
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->orderBy('id', 'DESC')->get();
        return view('backend.banner.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,qt|max:20480',
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/banner'), $filename);
            $data['photo'] = '/uploads/banner/' . $filename;
        }

        Banner::create($data);
        return redirect()->route('banner.index')->with('success', 'Successfully created banner');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        $categories = Category::where('status', 'active')->get();
        return view('backend.banner.edit', compact('banner', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,qt|max:20480',
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/banner'), $filename);
            $data['photo'] = '/uploads/banner/' . $filename;
        }

        $banner->update($data);
        return redirect()->route('banner.index')->with('success', 'Successfully updated banner');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('banner.index')->with('success', 'Banner successfully deleted');
    }
}

