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

    public function pause(Request $request, $id)
    {
        $request->validate([
            'pause_start' => 'required|date|after_or_equal:today',
            'pause_end' => 'required|date|after_or_equal:pause_start',
        ]);

        $subscription = Subscription::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $subscription->update([
            'pause_start' => $request->pause_start,
            'pause_end' => $request->pause_end,
            'status' => 'paused',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription berhasil dipause.',
        ]);
    }

    public function resume($id)
    {

        $subscription = Subscription::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $subscription->update([
            'pause_start' => null,
            'pause_end' => null,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription berhasil diresume.',
        ]);
    }

    public function cancel($id)
    {

        $subscription = Subscription::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $subscription->update([
            'status' => 'canceled',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription berhasil dibatalkan.',
        ]);
    }

    public function destroy($id)
    {
        $subscription = Subscription::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $subscription->delete();

        return response()->json(['message' => 'Langganan berhasil dibatalkan.']);
    }


}
