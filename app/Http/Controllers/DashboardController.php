<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())
            ->where('status', '!=', 'canceled')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('subscriptions'));
    }

    public function indexAdmin()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin-dashboard', compact('subscriptions'));
    }

    public function dataAdmin(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $subs = Subscription::whereBetween('created_at', [$start, $end])->get();
        
        return response()->json([
            'new_subscriptions' => $subs->count(),
            'mrr' => $subs->sum('total_price'),
            'reactivations' => Subscription::whereBetween('updated_at', [$start, $end])
                ->where('status', 'canceled')
                ->count(),
            'growth' => Subscription::where('status', 'active')->count(),
            'chart' => [
                'labels' => $subs->groupBy(fn($s) => $s->created_at->format('d M'))->keys(),
                'data' => $subs->groupBy(fn($s) => $s->created_at->format('d M'))->map->count()->values(),
                'total_price' => $subs->groupBy(fn($s) => $s->created_at->format('d M'))
                                    ->map(fn($group) => $group->sum('total_price'))
                                    ->values()
            ]
        ]);
    }
}
