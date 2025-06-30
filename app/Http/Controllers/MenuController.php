<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Testimonial;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        // Fetch plans and testimonials for the menu page
        $plans = Plan::where('is_active', 1)->get();
        $testimonials = Testimonial::latest()->take(5)->get();

        return view('pages.menu.index', [
            'plans' => $plans,
            'testimonials' => $testimonials,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required'
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        Subscription::create([
            'user_id'       => Auth::id(),
            'name'          => Auth::user()->name,
            'phone'         => Auth::user()->phone,
            'plan'          => $plan->name,
            'meal_types'    => $plan->meal_types,
            'delivery_days' => $plan->delivery_days,
            'total_price'   => $plan->price,
        ]);

        return response()->json([
            'message' => 'Subscription created successfully',
            'data' => [
                'plan' => $plan->name,
                'price' => $plan->price,
            ]
        ], 201);
    }
}
