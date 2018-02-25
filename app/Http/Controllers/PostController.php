<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getDashboard(){
        $posts = Post::orderBy('created_at', 'desc')->get();
		return view('dashboard', compact('posts'));
    }
    
    public function postCreatePost(Request $request){
        // Validation
        $this->validate($request, [
            'body' => 'required|max:100'
        ]);

        $post = new Post();
        $post->body = $request->input('body');
        $message = 'There was an error';
        if($request->user()->posts()->save($post)){
            $message = 'Post Succesfully created!';
        }
        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    public function getDeletePost($post_id){
        $post = Post::where('id', $post_id)->first();
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message' => 'Successfully Deleted!']);
    }

    public function postEditPost(Request $request){
        $this->validate($request, [
            'body' => 'required'
        ]);

        $post = Post::find($request->get('postId'));
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->body = $request->get('body');
        $post->update();
        return response()->json(['new_body' => $post->body], 200);
    }

    public function postLikePost(Request $request){
        $post_id = $request->get('postId');
        $is_like = $request->get('isLike') === 'true';
        $update = false;
        $post = Post::find($post_id);
        if(!$post){
            return null;
        }

        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if($like){
            $already_like = $like->like;
            $update = true;
            if($already_like == $is_like){
                $like->delete();
                return null;
            }
        } else {
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if($update){
            $like->update();
        } else{
            $like->save();
        }
        return null;
    }
}
