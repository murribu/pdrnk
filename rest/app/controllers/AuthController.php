<?php

class AuthController extends BaseController {

  public function status() {
    //I think I'm thinking of this totally wrong. I may have to build my own thing here.
    return Response::json(array(Auth::check(),Session::get('testHash')));
  }
  
  public function login(){
    if (Auth::attempt(array('email'=> Input::get('email'),'password'=> Input::get('password')))){
      return Response::json(array(Auth::user(),Auth::check()));
    }else{
      return Response::json(array('Error' => 'Invalid username or password'), 500);
    }
  }
  
  public function logout(){
    Auth::logout();
    return Response::json(array('Logged Out!'));
  }
  
  public function register(){
    $user = new User;
    $user->email = strtolower(Input::get('email'));
    $user->password = Hash::make(Input::get('password'));
    $user->save();
    Session::put('testHash','testVal');
    Auth::login($user);
    
    return Response::json(Auth::user());
  }
}
?>