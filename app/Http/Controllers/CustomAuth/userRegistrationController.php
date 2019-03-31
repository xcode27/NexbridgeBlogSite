<?php

namespace App\Http\Controllers\CustomAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\CustomUserModel;
use Intervention\Image\ImageManagerStatic as Image;

class userRegistrationController extends Controller
{
    //
    public function registerUser(Request $request){

        $date_create = date('Y-m-d H:i:s');

    	try{

    			$validator = Validator::make($request->all(), [
                                        'Fullname' => 'required|string|max:255',
                                        'Birthdate' => 'required|string',
                                        'email' => 'required|email|max:25|unique:custom_user_models',
                                        'Username' => 'required|string|max:255|unique:custom_user_models',
                                        'Password' => 'required|string|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                                        
                                    ]);

    			if($validator->fails())
    			{
                    return response()->json(['status'=>'error','message'=>$validator->errors()->all()]);
                       
                 }

                 if( $request->input('Password') != $request->input('password_confirm')){
                    return response()->json(['status'=>'error','message'=>'Password mismatched']);
                 }

                 $user = CustomUserModel::create([
                                            'fullname' => $request->input('Fullname'),
                                            'birthdate' => $request->input('Birthdate'),
                                            'email' => $request->input('email'),
                                            'username' => $request->input('Username'),
                                            'password' => bcrypt($request->input('Password')),
                                            'created_at' =>  $date_create,    
                                ]);
                                    
                                return response(['status'=>'success', 'message' => 'Store successfully saved. Please add form requirements. Thank you.']);

    	}catch(\Exception $e){
    		 return $e;
    	}

    }

    public function uploadPicture(Request $request){

        $date_create = date('Y-m-d H:i:s');

        try{

            $validator = Validator::make($request->all(), [

                                        'pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                                    ]);
            if($validator->fails())
                {
                    return response()->json(['status'=>'error','message'=>$validator->errors()->all()]);
                       
                 }

            if($request->hasFile('pic')){

                $image = $request->file('pic');
                $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $img = Image::make($image->getRealPath());
                $img->fit(600, 600)->save($destinationPath.'/'.$input['imagename']);
                
                $saveImg = CustomUserModel::where('username',$request->input('user'))->first();
                $saveImg->photo = $input['imagename'];
                $saveImg->save();

                return  response(['status'=>'success', 'message' => 'Registration successfully saved.']);

            }
        }catch(\Exception $e){
             return $e;
        }
        return $request->all();

    }

    public function updateUser(Request $request){

        $date_create = date('Y-m-d H:i:s');

        try{

                $validator = Validator::make($request->all(), [

                                        'Userid' => 'required|string',
                                        'Fullname' => 'required|string|max:255',
                                        'Birthdate' => 'required|string',
                                    ]);

                if($validator->fails())
                {
                    return response()->json(['status'=>'error','message'=>$validator->errors()->all()]);
                       
                 }

                 $user = CustomUserModel::where('id',$request->input('Userid'))->first();

                        $user->fullname = $request->input('Fullname');
                        $user->birthdate = $request->input('Birthdate');
                        $user->updated_at =  $date_create;
                        $user->save();
                                
                        return response(['status'=>'success', 'message' => 'Profile successfully updated']);

        }catch(\Exception $e){
             return $e;
        }

    }
}
