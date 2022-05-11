<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UpdateAnimalRequest;




class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        return Animal::where('type', $type)->get();
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
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
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
    public function show($slug)
    {
        return Animal::where('slug', $slug)->first();
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $animal = Animal::where('slug', $slug)->first();

        $request->validate([
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'type' => 'required|alpha',
            'sex' => 'required|alpha',
            'breed' => 'required|regex:/^[\pL\s\-]+$/u',
            'age' => 'integer',
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('animals')->ignore($animal->id)
            ],
            'childFriendly' => 'required',
            'dogFriendly' => 'required',
            'CatFriendly' => 'required',
            'content' => 'required',
            'img' => 'required|image'
        ]);


        $imagePath = public_path($animal->img);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }



        $animal->name = $request->name;
        $animal->slug = $request->slug;
        $animal->type = $request->type;
        $animal->sex = $request->sex;
        $animal->breed = $request->breed;
        $animal->age = $request->age;
        $animal->childFriendly = $request->childFriendly;
        $animal->dogFriendly = $request->dogFriendly;
        $animal->CatFriendly = $request->CatFriendly;
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $animal = Animal::find($id);
        $imagePath = public_path($animal->img);
        File::delete($imagePath);
        $result = $animal->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}