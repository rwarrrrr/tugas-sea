<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubscriptionManagementController extends Controller
{
    public function index()
    {
        return view('pages.admin.subscription.index');
    }

    public function data()
    {
        $subs = Subscription::with('user')->latest();
        return DataTables::of($subs)
            ->addIndexColumn()
            ->addColumn('user', fn($s) => $s->user->name)
            ->addColumn('plan', fn($s) => $s->plan)
            ->addColumn('meal_types', fn($s) => implode(', ', $s->meal_types))
            ->addColumn('delivery_days', fn($s) => implode(', ', $s->delivery_days))
            ->addColumn('total_price', fn($s) => 'Rp ' . number_format($s->total_price, 0, ',', '.'))
            ->addColumn('status', fn($s) => ucfirst($s->status))
            ->addColumn('actions', fn($s) => '
                            <button class="btn btn-danger btn-sm cancel-subscription" data-id="'.$s->id.'">Delete</button>
                            <button class="btn btn-info btn-sm show-detail" data-id="'.$s->id.'">Detail</button>
                        ')
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function show($id)
    {
        $s = Subscription::with('user')->findOrFail($id);
        return response()->json([
            'user' => $s->user->name,
            'phone' => $s->phone,
            'plan' => $s->plan,
            'meal_types' => implode(', ', (array) $s->meal_types),
            'delivery_days' => implode(', ', (array) $s->delivery_days),
            'allergies' => $s->allergies,
            'total_price' => $s->total_price,
            'status' => $s->status
        ]);
    }

    public function destroy($id)
    {
        $subscription = Subscription::where('id', $id)
            ->firstOrFail();

        $subscription->delete();

        return response()->json(['message' => 'Langganan berhasil dihapus.']);
    }

}
