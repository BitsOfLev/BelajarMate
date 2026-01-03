<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MBTI;

class MbtiController extends Controller
{
    // Display a listing of MBTI types
    public function index()
    {
        $mbtis = Mbti::orderBy('mbti', 'asc')->paginate(10);
        return view('admin.data-management.mbti.index', compact('mbtis'));
    }


    // Show form to create a new MBTI type
    public function create()
    {
        return view('admin.data-management.mbti.create');
    }

    // Store a newly created MBTI type
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:mbtis,type',
        ]);

        Mbti::create([
            'type' => $request->type,
        ]);

        return redirect()->route('admin.data-management.mbti.index')
                         ->with('success', 'MBTI type added successfully.');
    }

    // Show form to edit an existing MBTI type
    public function edit($id)
    {
        $mbti = Mbti::findOrFail($id);
        return view('admin.data-management.mbti.edit', compact('mbti'));
    }

    // Update an existing MBTI type
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:mbtis,type,' . $id . ',mbtiID',
        ]);

        $mbti = Mbti::findOrFail($id);
        $mbti->update([
            'type' => $request->type,
        ]);

        return redirect()->route('admin.data-management.mbti.index')
                         ->with('success', 'MBTI type updated successfully.');
    }

    // Delete an MBTI type
    public function destroy($id)
    {
        $mbti = Mbti::findOrFail($id);
        $mbti->delete();

        return redirect()->route('admin.data-management.mbti.index')
                         ->with('success', 'MBTI type deleted successfully.');
    }
}

