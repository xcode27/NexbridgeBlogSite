<?php

namespace App\Http\Controllers\PostController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\PostModel;
use App\CustomUserModel;
use App\LikePost;
use Session;

class PostController extends Controller
{
    //

    public function createPost(Request $request){

    	$date_create = date('Y-m-d H:i:s');
    	try{

    		$validator = Validator::make($request->all(), [
                                        'Title' => 'required',
                                        'Body' => 'required',
                                        'user' => 'required',
                                        
                                    ]);

    			if($validator->fails())
    			{
                    return response()->json(['status'=>'error','message'=>$validator->errors()->all()]);
                       
                 }
                
                 $user = PostModel::create([
                                            'Title' => $request->input('Title'),
                                            'Body' => $request->input('Body'),
                                            'user_id' => $request->input('user'),
                                            'date_created' =>  $date_create,    
                                ]);
                                    
                                return response(['status'=>'success', 'message' => 'Story successfully posted.']);

    	}catch(\Exception $e){
    		return $e;
    	}

    }

    public function getStoryByUser($userid){

    	try{
    			$story = DB::table('post_models as a')
    						->join('custom_user_models as b', 'b.id','a.user_id')
    						->select('a.id','b.fullname as author','a.Title','a.Body','.date_created','a.date_modified','a.visitor_like')
    						->where('a.user_id',$userid)->orderBy('date_created','DESC')->get();

    			return \Response::json($story);

    	}catch(\Exception $e){
    		return $e;
    	}

    }

    public function getStory(){

    	try{
    			$story = DB::table('post_models as a')
    						->join('custom_user_models as b', 'b.id','a.user_id')
    						->select('b.id','b.fullname as author','a.Title','a.Body','.date_created','a.date_modified','a.visitor_like','a.id as postId')->orderBy('date_created','DESC')->get();

    			return \Response::json($story);

    	}catch(\Exception $e){
    		return $e;
    	}

    }

    public function deletePost($id){

        $form = PostModel::findOrFail($id);

        if($form->delete()){
                return response(['status'=>'success', 'message' => 'Post story successfully removed']);
        }
    }

    public function getUserPost($id){

        try{

            $story = PostModel::select('Title','Body')->where('id', $id)->get();
            return \Response::json($story);

        }catch(\Exception $e){
            return $e;
        }

    }

    public function updatePost(Request $request){

        $date_create = date('Y-m-d H:i:s');
        try{

            $validator = Validator::make($request->all(), [
                                        'Title' => 'required',
                                        'Body' => 'required',
                                        
                                    ]);

                if($validator->fails())
                {
                    return response()->json(['status'=>'error','message'=>$validator->errors()->all()]);
                       
                 }
                 
                 $post = PostModel::where('id',$request->input('Postid'))->first();
                                            $post->Title = $request->input('Title');
                                            $post->Body = $request->input('Body');
                                            $post->date_modified =  $date_create;  
                                            $post->save();
                                    
                                return response(['status'=>'success', 'message' => 'Story successfully updated.']);

        }catch(\Exception $e){
            return $e;
        }

    }

    public function likeStory(Request $request){



        try{

            $user = Session::get('id');
            $date_create = date('Y-m-d H:i:s');

            $post = PostModel::select('visitor_like')->where('id',$request->input('post_id'))->first();

            $likeHistory = LikePost::select('user_id')->where('user_id',$user)
                                                      ->where('post_id',$request->input('post_id'))->first();
            
            if(count($likeHistory) == 0){

                $counter = $post->visitor_like + 1;

                $author1 = PostModel::where('id',$request->input('post_id'))->first();

                $author1->visitor_like = $counter;
                $author1->save();
                
                $user = LikePost::create([
                                            'user_id' => $user,
                                            'post_id' => $request->input('post_id'),    
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
