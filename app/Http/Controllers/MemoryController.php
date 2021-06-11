<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use Illuminate\Http\Request;

class MemoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['memory'] = Memory::orderBy('id', 'desc')->paginate(5);
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
        $path = $request->file('image')->store('public/images');
        $memory = new Memory;
        $memory->title = $request->title;
        $memory->description = $request->description;
        $memory->image = $path;
        $memory->save();
     
        return redirect()->route('memory.index')
                        ->with('success','memory has been created successfully.');
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
    public function update(Request $request, Memory $memory, Id $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $memory = Memory::find($id);
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
