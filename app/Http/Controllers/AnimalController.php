<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Http\Requests\UpdateAnimalRequest;
use Illuminate\Http\Request;




class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Animal::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha',
            'type' => 'required|alpha',
            'sex' => 'required|alpha',
            'breed' => 'required|regex:/^[\pL\s\-]+$/u',
            'age' => 'integer',
            'slug' => 'required|alpha_dash|unique:animals',
            'childFriendly' => 'required',
            'dogFriendly' => 'required',
            'catFriendly' => 'required',
            'content' => 'required',
            'img' => 'required|image'
        ]);



        $animal = new Animal();
        $animal->name = $request->name;
        $animal->slug = $request->slug;
        $animal->type = $request->type;
        $animal->sex = $request->sex;
        $animal->breed = $request->breed;
        $animal->age = $request->age;
        $animal->childFriendly = $request->childFriendly;
        $animal->dogFriendly = $request->dogFriendly;
        $animal->catFriendly = $request->catFriendly;
        $animal->content = $request->content;
        $animal->img = 'storage/' . $request->file('img')->store('animals', 'public');
        $result = $animal->save();

        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function edit(Animal $animal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnimalRequest  $request
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        //
    }
}