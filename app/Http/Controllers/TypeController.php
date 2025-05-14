<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all types with their names and icons
        $types = Type::select('type_id', 'type_name', 'icon_name')->get();

        // Pass the data to the view (if needed)
        return view('types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the form view for creating a new type
        return view('types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'type_name' => 'required|string|max:255',
            'icon_name' => 'required|string|max:255', // Ensure icon_name is validated
        ]);

        // Create a new type record
        Type::create($validated);

        // Redirect to the index page with a success message
        return redirect()->route('type.index')
            ->with('success', 'Type created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        // Fetch the specific type with its name and icon
        $typeData = [
            'type_id' => $type->type_id,
            'type_name' => $type->type_name,
            'icon_name' => $type->icon_name,
        ];

        // Pass the data to the view
        return view('types.show', ['type' => $typeData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        // Pass the type data to the edit form view
        return view('types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'type_name' => 'required|string|max:255',
            'icon_name' => 'required|string|max:255', // Ensure icon_name is validated
        ]);

        // Update the type record
        $type->update($validated);

        // Redirect to the index page with a success message
        return redirect()->route('type.index')
            ->with('success', 'Type updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        // Delete the type record
        $type->delete();

        // Redirect to the index page with a success message
        return redirect()->route('type.index')
            ->with('success', 'Type deleted successfully!');
    }
}
