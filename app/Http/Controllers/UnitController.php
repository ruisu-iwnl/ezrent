<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'unit.code' => 'required|string|max:255|unique:units,code',
            'unit.status' => 'required|in:vacant,maintenance',
            'unit.description' => 'nullable|string|max:1000',
        ]);

        Unit::create([
            'admin_id' => auth()->id(),
            'code' => $request->input('unit.code'),
            'status' => $request->input('unit.status'),
            'description' => $request->input('unit.description'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Unit created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'unit.code' => 'required|string|max:255|unique:units,code,' . $unit->id,
            'unit.status' => 'required|in:vacant,maintenance',
            'unit.description' => 'nullable|string|max:1000',
        ]);

        $unit->update([
            'code' => $request->input('unit.code'),
            'status' => $request->input('unit.status'),
            'description' => $request->input('unit.description'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Unit updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        //
    }
}
