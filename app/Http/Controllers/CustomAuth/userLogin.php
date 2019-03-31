<?php

namespace App\Http\Controllers\CustomAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\CustomUserModel;
use Illuminate\Support\Facades\Hash;
use Session;

class userLogin extends Controller
{
    //
    public function LoginUser(Request $request){
       
       try{

            $date_login = date('Y-m-d H:i:s');


                 $validator = Validator::make($request->all(), [
                                        'Username' => 'required',
                                        'Password' => 'required',
                                    ]);

                if($validator->fails())
                {
                    return response()->json(['status'=>'error','message'=>$validator->errors()->all()]);
                       
                 }

                 $user = CustomUserModel::where('username', '=', $request->input('Username'))->first();
                if($user){

                    if(Hash::check($request->input('Password'), $user->password))
                    {
                                
                                Session::put('id', $user->id);
                                Session::put('Fullname', $user->fullname);
                                Session::put('Birthdate', $user->birthdate);
                                Session::put('Photo', $user->photo);

                     
                                $user->date_last_login = $date_login;
                                $user->save();

                                 return response(['status'=>'success', 'message' => 'Welcome user']);
                    }else{
                                 return response(['status'=>'error', 'message' => 'Invalid password']);
                    }
                }else{
                    return response(['status'=>'error', 'message' => 'Invalid username']);
                }

        }catch(\Exception $e){
            return $e;
        }

    }

}
