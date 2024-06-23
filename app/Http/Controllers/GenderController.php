<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class GenderController extends Controller
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
        return 'create page';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gender' => ['required', 'unique:genders'],
        ]);

        Gender::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gender $gender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gender $gender)
    {
        return $gender->gender;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gender $gender)
    {
        $validated = $request->validate([
            'gender' => [
                'required',
                Rule::unique('genders')->ignore($gender),
            ],
        ]);

        $gender->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gender $gender)
    {
        $gender->delete();
    }
}
