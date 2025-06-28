<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Testimonial;
use App\Models\AppLog;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'message' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $save = Testimonial::create($validated);

        if (!$save) {
            return redirect()->back()->with('error', 'Failed to submit your review. Please try again.');
        }

        AppLog::create([
            'foreign_id' => $save->id,
            'changed_by' => Auth::id(),
            'model_type' => 'Testimonial',
            'action' => 'created',
            'old_data' => '',
            'new_data' => $validated,
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}
