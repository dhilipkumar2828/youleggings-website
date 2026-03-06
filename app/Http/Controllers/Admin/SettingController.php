<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('backend.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
        }

        $data = $request->all();
        $status = $setting->fill($data)->save();

        if ($status) {
            Session::put('success', 'Settings updated successfully');
        } else {
            Session::put('error', 'Something went wrong');
        }

        return redirect()->back();
    }
}
