<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Exports\PlansExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.plans.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
            'highlight' => 'string|max:191',
            'meal_types'    => 'required|array|min:1',
            'delivery_days' => 'required|array|min:1',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('plans', 'public');
        }
        $data['is_active'] = true; 
        
        $plan = Plan::create($data);

        return response()->json([
            'message' => 'Plan berhasil ditambahkan',
            'data' => $plan,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|integer|min:10000', 
            'highlight' => 'string|max:191',
            'meal_types'    => 'required|array|min:1',
            'delivery_days' => 'required|array|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean'
        ]);
        
        if ($request->hasFile('image')) {
            if ($plan->image && Storage::disk('public')->exists($plan->image)) {
                Storage::disk('public')->delete($plan->image);
            }

            $data['image'] = $request->file('image')->store('plans', 'public');
        }

        $plan->update($data);
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);

        if ($plan->image && Storage::disk('public')->exists($plan->image)) {
            Storage::disk('public')->delete($plan->image);
        }

        $plan->delete();

        return response()->json(['message' => 'Plan deleted successfully.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            $plans = Plan::whereIn('id', $ids)->get();

            foreach ($plans as $plan) {
                if ($plan->image && Storage::disk('public')->exists($plan->image)) {
                    Storage::disk('public')->delete($plan->image);
                }
                $plan->delete();
            }
        }

        return response()->json(['message' => 'Data terpilih berhasil dihapus']);
    }

    public function bulkStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'status' => 'required|boolean',
        ]);


        Plan::whereIn('id', $request->ids)->update([
            'is_active' => $request->status
        ]);

        return response()->json(['message' => 'Status berhasil diperbarui']);
    }

    public function data(Request $request)
    {
        $plans = Plan::query();

        return DataTables::of($plans)
            ->addColumn('action', function ($plan) {
                return '<button class="btn btn-warning btn-sm edit-btn"
                            data-id="'.$plan->id.'"
                            data-name="'.$plan->name.'"
                            data-price="'.$plan->price.'"
                            data-highlight="'.$plan->highlight.'"
                            data-meal_types="' . htmlspecialchars(json_encode($plan->meal_types), ENT_QUOTES, 'UTF-8') . '"
                            data-delivery_days="' . htmlspecialchars(json_encode($plan->delivery_days), ENT_QUOTES, 'UTF-8') . '" 
                            data-delivery_days=\''.json_encode($plan->delivery_days).'\'                            
                            data-description="'.$plan->description.'"
                            data-image="'.$plan->image.'"
                            data-is_active="'.$plan->is_active.'">Edit</button>
                            
                        <button class="btn btn-danger btn-sm delete-btn" 
                            data-id="' . $plan->id . '">
                            Delete
                        </button>
                ';
            })
            ->addColumn('image', function ($plan) {
                if ($plan->image) {
                    return '<img src="'.asset('storage/'.$plan->image).'" width="80">';
                }
                return '-';
            })
            ->rawColumns(['action', 'image']) 
            ->make(true);
    }

    public function export(Request $request)
    {
        $ids = $request->input('ids', []);
        return Excel::download(new PlansExport($ids), 'plans_export.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $ids = $request->input('ids', []);
        $plans = Plan::whereIn('id', $ids)->get();

        $pdf = Pdf::loadView('pages.admin.plans.export_pdf', compact('plans'));
        return $pdf->download('plans_export.pdf');
    }
}
