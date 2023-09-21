<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets=Pet::where('user_id','=',Auth::id())->orderBy('updated_at', 'desc')->paginate(5);
        return view('pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
        $request->user()->pets()->create($request->all());
        return redirect()->route('pets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        $this->authorize('view',$pet);
        return view('pets.show',compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        return view('pets.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetRequest $request, Pet $pet)
    {
        $this->authorize('update',$pet);
        $pet->update($request->all());
        return redirect()->route('pets.edit',$pet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $this->authorize('delete',$pet);
        $pet->delete();
        return redirect()->route('pets.index');
    }
}
