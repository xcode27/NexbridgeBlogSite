<?php

namespace App\Http\Controllers\UserProfile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CustomUserModel;
use App\visitorTable;
use Session;

class userProfileController extends Controller
{
   

    public function getUserProfile($author){

    	try{
    			$story = CustomUserModel::select('id','fullname','username','birthdate','photo','visitor','email')->where('id',$author)->get();
    			return \Response::json($story);

    	}catch(\Exception $e){
    		return $e;
    	}

    }

    public function countVisitor(Request $request){

    	try{

    		$user = Session::get('id');
    		$date_create = date('Y-m-d H:i:s');

    		$author = CustomUserModel::select('visitor')->where('id',$request->input('authorid'))->first();

    		$visitHistory = visitorTable::select('user_id')->where('user_id',$user)
                                                           ->where('profile_visited',$request->input('authorid'))->first();
    		
    		if(count($visitHistory) == 0){

    			$counter = $author->visitor + 1;

    			$author1 = CustomUserModel::where('id',$request->input('authorid'))->first();

    			$author1->visitor = $counter;
    			$author1->save();
    			
    			$user = visitorTable::create([
                                            'user_id' => $user,
                                            'profile_visited' => $request->input('authorid'),
                                            'date_visited' =>  $date_create,    
                                ]);
                                  
                   return response(['status'=>'success', 'message' => 'success']);  
                                	
    		}else{
                return response(['status'=>'success', 'message' => 'success']);
            }
    		

    	}catch(\Exception $e){
    		return $e;
    	}
    }

}
