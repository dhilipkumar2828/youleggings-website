<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clientfeedback;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $feedbacks = Clientfeedback::orderBy('id', 'desc')->get();
        return view('backend.feedback.view', compact('feedbacks'));
    }

    public function update_feedback(Request $request)
    {
        Clientfeedback::where('id', $request->id)->update(['status' => $request->mode]);
        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }

    public function delete_feedback($id)
    {
        $feedback = Clientfeedback::findOrFail($id);
        $feedback->delete();
        return back()->with('success', 'Feedback deleted successfully');
    }
}
