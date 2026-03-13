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
        $status = ($request->mode == 'active') ? 'accept' : 'reject';
        Clientfeedback::where('id', $request->id)->update(['status' => $status]);
        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }

    public function add_feedback()
    {
        return view('backend.feedback.add');
    }

    public function store_feedback(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'feedback' => 'required',
        ]);

        $status = $request->has('status') ? 'accept' : 'reject';

        Clientfeedback::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'feedback' => $request->feedback,
            'status' => $status,
            'rate' => 5, // Default rating
        ]);

        return redirect()->route('testimonial.index')->with('success', 'Feedback added successfully');
    }

    public function delete_feedback($id)
    {
        $feedback = Clientfeedback::findOrFail($id);
        $feedback->delete();
        return back()->with('success', 'Feedback deleted successfully');
    }
}
