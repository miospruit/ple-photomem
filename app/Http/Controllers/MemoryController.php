<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Library\LabelDetection;

class MemoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //magic
        $s = $request->input('term');
        $q = Memory::with('tags');
        if ($s) {
           $q = $q->where('title', 'like', '%' . $s . '%')->orWhere('description',  'like', '%' . $s . '%');

           $q = $q->orWhereHas('tags', function ($query) use($s) {
                 return $query->where('name', 'like', '%' . $s . '%');
            });
        }
        $data['memory'] = $q->get();
        return view('memory.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('memory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'description' => 'required',
        ]);
        $image = $request->file('image');
        $path = $image->store('public/images');
        $detectornator = new LabelDetection;
        $memory = new Memory;
        $memory->title = $request->title;
        $memory->description = $request->description;
        $memory->image = $path;
        $memory->save();
        $labels = $detectornator::tags($image->get());
        foreach($labels as $label){
            $tag = Tag::updateOrCreate(
                ['name' => $label]
            );
            $memory->tags()->attach($tag);
        }

        $tags = $memory->tags();

        return redirect()->route('memory.index')
                        ->with('success','memory has been created successfully.', $tags);
                        //ToDo: add return to detail page with tags. Make user select tags and submit from there to the database.
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function show(Memory $memory)
    {
        return view('memory.show', compact('memory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function edit(Memory $memory)
    {
        return view('memory.edit',compact('memory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Memory $memory)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        // $memory = Memory::find($id);
        if($request->hasFile('image')){
            $request->validate([
              'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            $path = $request->file('image')->store('public/images');
            $memory->image = $path;
        }
        $memory->title = $request->title;
        $memory->description = $request->description;

        $memory->save();
        foreach (explode(',', $request->tags) as $tag) {
            $newTag = Tag::firstOrCreate(
                ['name' => $tag]
            );

            $memory->tags()->attach($newTag);
        }

        return redirect()->route('memory.index')
                        ->with('success','Memory updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memory $memory)
    {
        $memory->delete();

        return redirect()->route('memory.index')
                        ->with('success','Memory has been deleted successfully');
    }
}
