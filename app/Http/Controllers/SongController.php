<?php

namespace App\Http\Controllers;

use App\Cgy;
use App\Song;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests\SongRequest;

class SongController extends Controller
{
 /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function index(Request $request)
 {
  //$songs = Song::where('name','like','Song%')->orderBy('id','desc')->get();
  //$songs = Song::whereRaw('id >= 8 AND id <10')->get();
  //$songs = Song::select('name','album_id')->get();
  //dd(DB::table('songs')->where('name', 'like', 'Song%')->orderBy('id', 'desc')->get()
  //);
  dd(Song::getQuery()->select('name')->where('name', 'like', 'Song%')->orderBy('id', 'desc')->first()
  );
  //dd(Song::getQuery());
  return $songs;
 }

 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
  $cgies = Cgy::pluck('title', 'id');
  $styles = json_decode(setting('site.styles'));
  //dd($cgies);
  return view('songs.create', compact('cgies','styles'));
 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function store(SongRequest $request)
 {
  //dd($request->except(['_token']));
  $data_except = $request->except(['_token', 'desc']);
  //dd($request->filled('password'));
  //dd($request->input('password','abc'));
  //dd($request->hasFile('pic'));
    //dd($request->input('hit'));
    //控制器驗證表單是否合法
    // $this->validate($request,[
    //     'name' => 'required',
    //     'url' => 'required',
    //     'hit' => 'integer|max:10'
    // ]);

    //手動建立驗證器
    // $validator = Validator::make($request->all(), [
    //     'name' => 'required',
    //     'url' => 'required',
    //     'hit' => 'integer|max:10'
    // ]);

    // if($validator->fails()){
    //     return redirect('/songs/create')->withErrors($validator)->withInput();
    // }


    //驗證成功
    //寫入資料庫



  //第一種作法
  //   $song                 = new Song;
  //   $song->name           = 'Song1';
  //   $song->published_time = \Carbon\Carbon::now();
  //   $song->sell_at        = \Carbon\Carbon::now();
  //   $song->album_id       = 1;
  //   $song->cgy_id         = 1;
  //   $song->url            = "https://url.com";
  //   $song->cover          = "https://cover.com";
  //   $song->save();

  //第二種作法
  //   $data = [
  //    'name'           => 'Song1',
  //    'published_time' => \Carbon\Carbon::now(),
  //    'sell_at'        => \Carbon\Carbon::now(),
  //    'album_id'       => 1,
  //    'cgy_id'         => 1,
  //    'url'            => "https://url.com",
  //    'cover'          => "https://cover.com",
  //   ];
  //$song = new Song($data);
  //$song->save();
  $data_only = $request->only(['name', 'sell_at', 'album_id', 'cgy_id', 'url', 'cover', 'published_time']);
  //dd($data_only);
  $song       = Song::create($data_except);
  $song->name = 'name2';
  $song->save();
  //return redirect('/songs/1');
 }

 /**
  * Display the specified resource.
  *
  * @param  \App\Song  $song
  * @return \Illuminate\Http\Response
  */
 public function show(Song $song)
 {
  $song = Song::where('name','name2')->where('album_id',1)->first();
  // dd($song);
  // return $song;
  $cgy_6 = \App\Cgy::find(6);
  //dd($song->cgy->desc);
  $song->cgy()->associate($cgy_6);
  $song->save();
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Song  $song
  * @return \Illuminate\Http\Response
  */
 public function edit(Song $song)
 {
  $cgies = Cgy::pluck('title', 'id');

  return view('songs.edit', compact('song', 'cgies'));
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Song  $song
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, Song $song)
 {
  //第一種作法
  //  $song->name = 'Song3';
  //  $song->save();

  //第二種作法
  //$song = Song::updateOrCreate(['id'=>$song->id],['name'=>'Song99']);
  //$request->except(['_method','_token','id']
  dd($request->all());
  $data = $request->only(['name', 'sell_at', 'album_id', 'cgy_id', 'url', 'cover', 'published_time']);
  //dd($data);
  Song::updateOrCreate(['id' => $song->id], $data);

 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Song  $song
  * @return \Illuminate\Http\Response
  */
 public function destroy(Song $song)
 {
  //$song->delete();

  Song::destroy($song->id);
 }

 public function modifyCgy(Song $song)
 {
  $cgy_2 = \App\Cgy::findOrFail(2);
  $song->cgy()->associate($cgy_2);
  $song->save();
 }

 public function modify(Song $song)
 {
  $song->name = 'test me';
  $song->save();
 }

 public function testAccessor(Song $song)
 {
    //return $song->name;
    return $song->getAttributes()['name'];
    //return $song->new_name;
 }

 public function testMutator(Song $song)
 {
     $song->name = $song->name;
     $song->save();
     return redirect('/');
 }

 public function testCast(Song $song)
 {
     //dd($song->created_at);
     return $song->created_at;
 }

 public function testFormat(Song $song)
 {
     dd($song);
 }


}
