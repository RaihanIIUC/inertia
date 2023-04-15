<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $projects = ProjectResource::collection(Project::with('skill')->latest()->get());
        return Inertia::render('Projects/index',compact('projects'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skills = Skill::all();
        return Inertia::render('Projects/create',compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request)
    {
          if($request->hasFile('image')){
            $image = $request->file('image')->store('projects');

            Project::create([
                'name' => $request->name,
                'project_link' => $request->project_link,
                'skill_id' => $request->skill_id,
                'image' => $image
            ]);
            return \Redirect::route('projects.index')->with('message', 'Project Created successfully');
         }
        return \Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $image = $project->image;
         if($request->hasFile('image')){
            \Storage::delete($project->image);
            $image = $request->file('image')->store('projects');
        }
        $project->update([
         'name' => $request->name,
        'project_link' => $request->project_link,
            'image' => $image,
        ]);

        return \Redirect::route('projects.index')->with('message','Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
          \Storage::delete($project->image);
        $project->delete();
        return \Redirect::back()->with('message', 'Project Deleted successfully');
    }
}
