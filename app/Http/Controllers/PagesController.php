<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class PagesController extends Controller
{
    //
    public function index(){
        
           // Session::flush();
            return view('pages.login');
        
    	
    }

    public function userregistration(){
    	return view('pages.registration');
    }

    public function login(){
    	return view('pages.login');
    }

    public function home(){
    	return view('pages.home');
    }

    public function profile(){
    	return view('pages.profile');
    }

    public function Logout(){
        return view('pages.login');
    }
    public function userProfile($id){
        return view('pages.UserProfile')->with('user_id',$id);;
    }

    public function editProfileDetails(){
        return view('pages.editProfile');
    }

    public function removeSession(){
        Session::flush();
    }
}
