<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$name = 'zack';
        //$this->middleware('auth')->except('index','about');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $name = '<b>zack</b>';
        $age = 18;
        $data = ['name'=>$name,'age'=>$age];
        //return view('home',$data);
        //return view('home', compact('name','age'));
        //return view('home')->with($data);

        return view('home')->with('name',$name)->with('age',$age);
    }

    public function about(){
        $items = ['item1','item2','item3'];
        return view('blogs.about',compact('items'));
    }

    public function checkPermission(){
        if(setting('admin.admin_isSend') == 'on'){
            //發信
        }else{
            //不發信
        }
    }

    public function savesession(){
        session(['platform' => ['Apple','Facebook','Google','AWS']]);
    }

    public function getsession(Request $request){
        //return session('ary','annonymous');
        //return $request->session()->get('platform.3');
        return $request->session()->all();

    }

    public function hassession(Request $request){
        return $request->session()->exists('ary');
    }

    public function pushsession(Request $request){
        $request->session()->push('ary','Vincent');
    }

    public function deletesession(Request $request){
        $request->session()->flush();
    }

    public function flashsession(Request $request){
        $request->session()->flash('msg','Flash Message');
    }

    public function authuser(Request $request) {
        dd($request->user());
    }

    public function authlogin(Request $request) {
        $user = User::findOrFail(4);
        Auth::login($user);
    }

    public function authlogout(){
        Auth::logout();
    }
}
