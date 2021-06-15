<?php

namespace App\Http\Controllers;

use App\Map;
use App\Tag;
use App\Attraction;
use App\Http\Requests\MapRequest;
use Illuminate\Http\Request;
use Exception;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {

            $tag = $request->tag ;
            $region = $request->region ;
            $town = $request->town ;
            $area = $request->area ;
            if ($request->area) {
                return view('maps.index', [
                    'tags' => Tag::get(),
                    'attractions' => Attraction::where('name', $area)->with(['tags', 'position', 'images'])->get()
                ]);
            };

            $attractions = Attraction::QueryTags($tag)->QueryPosition($region, $town)->with(['tags', 'position', 'images'])->get();
            $tags = Tag::get();
            dd($attractions);
        } catch (Exception $e) {
            $attractions = Attraction::with('tags', 'position', 'images')->inRandomOrder()->take(100)->get();
            $tags = Tag::get();
        };
        return view('maps.index', compact('attractions', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('maps.factory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MapRequest $request)
    {
        $map = Map::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
        ]);
        return redirect()->route('maps.show', ['map' => $map->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('test2');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $action = 'Edit';
        return view('maps.factory', compact('action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MapRequest $request, $id)
    {
        if ($request->name) {
            $map = Map::findOrFail($id);
            $map->update([
                'name' => $request->name,
            ]);
        };


        return redirect()->route('maps.show', ['map' => $map->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $map = Map::find($id);
        $map->attractions()->sync([]);
        $map->delete();
    }
}
