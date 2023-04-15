<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillStoreRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = SkillResource::collection(Skill::all());
        return Inertia::render('Skills/index',compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Skills/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkillStoreRequest $request)
    {

        if($request->hasFile('image')){
            $image = $request->file('image')->store('skills');
            Skill::create([
                'name' => $request->name ,
                'image' => $image
            ]);
            return Redirect::route('skills.index')->with('message', 'Skill updated successfully');
        }
        return Redirect::back();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return Inertia::render('Skills/Edit',compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        if($request->hasFile('image')){
            \Storage::delete($skill->image);
            $image = $request->file('image')->store('skills');
            $skill->update($request->all());
            return Redirect::route('skills.index')->with('message', 'Skill updated successfully');
        }
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        \Storage::delete($skill->image);
        $skill->delete();
        return Redirect::back()->with('message', 'Skill updated successfully');
    }
}
