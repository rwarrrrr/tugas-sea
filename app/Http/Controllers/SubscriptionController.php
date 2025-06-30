<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('pages.subscription.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => ['required', 'regex:/^(08|\+628)[0-9]{8,13}$/'], // nomor HP Indonesia
            'plan'          => 'required|in:Diet,Protein,Royal',
            'meal_types'    => 'required|array|min:1',
            'delivery_days' => 'required|array|min:1',
            'allergies'     => 'nullable|string',
        ], [
            'phone.regex'           => 'Nomor HP tidak valid. Gunakan format 08xx atau +628xx',
            'meal_types.min'        => 'Pilih minimal satu jenis makan.',
            'delivery_days.min'     => 'Pilih minimal satu hari pengantaran.',
        ]);

        $planPrice      = $request->plan;
        $mealCount      = count($request->meal_types);
        $dayCount       = count($request->delivery_days);
        $totalPrice     = $planPrice * $mealCount * $dayCount * 4.3;

        Subscription::create([
            'user_id'       => Auth::id(),
            'name'          => $request->name,
            'phone'         => $request->phone,
            'plan'          => $request->plan,
            'meal_types'    => $request->meal_types,
            'delivery_days' => $request->delivery_days,
            'allergies'     => $request->allergies,
            'total_price'   => $totalPrice,
        ]);

        return response()->json(['message' => 'Subscription berhasil disimpan']);
    }
}
