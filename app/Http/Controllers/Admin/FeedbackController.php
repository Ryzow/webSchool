<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->get();
        return view('school.admin.feedback.index', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'nullable|email',
            'pesan' => 'required|string',
        ]);

        Feedback::create($request->all());

        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->back()->with('success', 'Feedback berhasil dihapus.');
    }
}
