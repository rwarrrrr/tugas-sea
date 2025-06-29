<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::first();
        return view('pages.admin.contacts.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'position' => 'required|string|max:191',
            'name' => 'required|string|max:191',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'open_hours' => 'nullable|string',
            'address' => 'nullable|url|starts_with:https://www.google.com/maps/embed'
        ]);

        Contact::updateOrCreate(
            ['id' => $request->id],
            $request->only(['position', 'name', 'phone', 'email', 'open_hours', 'address'])
        );

        return response()->json(['message' => 'Data kontak berhasil disimpan']);
    }
}
