<?php

namespace App\Http\Controllers;

use App\Models\championship_categories;
use Illuminate\Http\Request;

class ChampionshipCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(championship_categories::where('status', 'V')->with(['championship', 'category'])->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        echo "<pre>+ $request->all()</pre>";
        $data = $request->validate([            
            'championship_id' => 'required|exists:championships,championship_id',
            'category_id'     => 'required|exists:categories,category_id',
            'max_teams'       => 'required|integer',
        ]);
        $item = championship_categories::create(array_merge($data, ['status' => 'V']));
        return response()->json(['message' => 'Categoría asignada al campeonato', 'data' => $item], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(championship_categories $championship_categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(championship_categories $championship_categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, championship_categories $championship_categories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(championship_categories $championship_categories)
    {
        //
    }
}
