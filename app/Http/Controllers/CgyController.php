<?php

namespace App\Http\Controllers;

use App\Cgy;
use Illuminate\Http\Request;

class CgyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cgies = Cgy::with('songs')->enabled()->get();
        $songs_count = Cgy::withCount('songs')->get();
        dd($cgies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cgy  $cgy
     * @return \Illuminate\Http\Response
     */
    public function show(Cgy $cgy)
    {
        //檢視分類有哪些歌曲
        dd($cgy->songs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cgy  $cgy
     * @return \Illuminate\Http\Response
     */
    public function edit(Cgy $cgy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cgy  $cgy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cgy $cgy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cgy  $cgy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cgy $cgy)
    {
        //
    }

    public function addSong($cgy_id,$song_id){
        $cgy = \App\Cgy::findOrFail($cgy_id);
        $song = \App\Song::findOrFail($song_id);
        $song98 = \App\Song::findOrFail(98);
        $cgy->songs()->saveMany([$song,$song98]);
        return '加入完成';
    }

    public function addTag(Cgy $cgy, \App\Tag $tag){
        $cgy->tags()->save($tag,['description'=>'test me']);
        //$cgy->tags()->attach([$tag->id]);
        return '新增Tag完成';
    }

    public function removeTag(Cgy $cgy,\App\Tag $tag)
    {
        $cgy->tags()->detach($tag->id);
        return '移除Tag完成';
    }

    public function syncTag(Cgy $cgy)
    {
        $cgy->tags()->sync([5,6,7,8]);
        return '重置Tag完成';
    }

    public function showFirstTag(Cgy $cgy)
    {
        dd($cgy->tags()->first()->pivot->description);
    }

}
