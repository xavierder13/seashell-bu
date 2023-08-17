<?php

namespace App\Http\Controllers;

use App\Models\Species;
use Illuminate\Http\Request;
use App\Imports\SpeciesImport;

class SpeciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $species = Species::where(function($q){
            $key = request()->get('q');
            if(request()->has('q')){
                $q->where('name', 'like', '%'.$key.'%')
                  ->orWhere('kingdom', 'like', '%'.$key.'%')
                  ->orWhere('phylum', 'like', '%'.$key.'%')
                  ->orWhere('class', 'like', '%'.$key.'%')
                  ->orWhere('order', 'like', '%'.$key.'%')
                  ->orWhere('family', 'like', '%'.$key.'%')
                  ->orWhere('genus', 'like', '%'.$key.'%')
                  ->orWhere('species', 'like', '%'.$key.'%');
            }

        })->orderBy('created_at')->paginate(20);
        return view('admin.species', compact('species'));
    }

    public function create()
    {
        return view('admin.add-species');
    }

    public function store(Request $request)
    {
        $species = Species::create($request->all());

        return back()->with('success', 'Species successfully added');

    }

    public function show(Species $species)
    {
        //
    }

    public function edit(Species $species)
    {
        //
    }

    public function update(Request $request, Species $species)
    {
        $species = $species->update($request->all());

        return back()->with('success', 'Species succesfully update.');
    }

    
    public function destroy(Species $species)
    {
        //
    }
}
