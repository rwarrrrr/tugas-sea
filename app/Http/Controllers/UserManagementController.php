<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.users.index');
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => [
                            'required',
                            'min:8',
                            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).+$/'
                        ]
        ]);

        $data['role'] = 'admin'; 
        
        $user = User::create($data);

        return response()->json([
            'message' => 'User berhasil ditambahkan',
            'data' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        $user->update($data);
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            $users = User::whereIn('id', $ids)->get();

            foreach ($users as $user) {
                if (Auth::id() === $user->id) {
                    continue; 
                }

                $user->delete();
            }
        }

        return response()->json(['message' => 'Data terpilih berhasil dihapus']);
    }

    public function data(Request $request)
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return '<button class="btn btn-warning btn-sm edit-btn"
                            data-id="'.$user->id.'"
                            data-name="'.$user->name.'">Edit</button>
                            
                        <button class="btn btn-secondary btn-sm reset-password" 
                            data-id="'.$user->id.'">Reset PW</button>

                        <button class="btn btn-danger btn-sm delete-btn" 
                            data-id="' . $user->id . '">
                            Delete
                        </button>
                ';
            })
            ->rawColumns(['action']) 
            ->make(true);
    }

    public function resetPassword(User $user)
    {
        if (Auth::id() === $user->id) {
            return response()->json(['message' => 'Anda tidak bisa mereset password Anda sendiri'], 403);
        }

        $defaultPassword = 'Password123!';

        $user->update([
            'password' => Hash::make($defaultPassword)
        ]);

        return response()->json(['message' => 'Password berhasil direset ke: ' . $defaultPassword]);
    }


}
