<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\User;

class LoginController extends Controller
{
 /*
 |--------------------------------------------------------------------------
 | Login Controller
 |--------------------------------------------------------------------------
 |
 | This controller handles authenticating users for the application and
 | redirecting them to your home screen. The controller uses a trait
 | to conveniently provide its functionality to your applications.
 |
  */

 use AuthenticatesUsers;

 /**
  * Where to redirect users after login.
  *
  * @var string
  */
 protected $redirectTo = '/';

 /**
  * Create a new controller instance.
  *
  * @return void
  */
 public function __construct()
 {
  $this->middleware('guest')->except('logout');
 }

 public function showLoginForm()
 {
  return view('auth.login2');
 }

 public function redirectTo()
 {
  if (Auth::user()->role_id == 2) {
   //假如是一般使用者
   return '/home';
  } else if (Auth::user()->role_id == 1) {
   //假如是管理員
   return '/admin';
  } else {
   return '/login';
  }
 }

 //設定登出網址
 protected function loggedOut(Request $request)
 {
  return redirect('/my/logout/path');
 }

 public function username()
 {
  return 'username';
 }

 //轉址到社群平台的登入頁面
 public function redirectToProvider($provider)
 {
  return Socialite::driver($provider)->redirect();
 }

//交由社群平台去呼叫的Call back function
 public function handleProviderCallback($provider)
 {
  //透過供應器來取得用戶
  $user = Socialite::driver($provider)->user();
  //透過用戶和供應器名稱來尋找或建立用戶
  $authUser = $this->findOrCreateUser($user, $provider);
  //進行登入並開啟記得我
  Auth::login($authUser, true);

  return redirect($this->redirectTo);
 }

//假如通過登入提供者驗證後發現使用者已經註冊過，就取得該使用者資料，否則就自動進行簡易註冊動作
 public function findOrCreateUser($user, $provider)
 {
  $authUser = User::where('provider_id', $user->id)->first();
  if (!$authUser) {
   //可能已經用其他管道註冊過
   $authUser = User::where('email', $user->email)->first();
   if ($authUser) {
    $authUser->provider    = $provider;
    $authUser->provider_id = $user->id;
    $authUser->save();
   }
  }

  if ($authUser) {
   return $authUser;
  } else {
   $data = [
    'name'     => $user->name,
    'email'    => $user->email,
    'avatar'   => $user->getAvatar(),
    'provider' => $provider,
    $authUser = User::where('provider_id', $user->id)->first()];
   return User::create($data);
  }
 }
}
