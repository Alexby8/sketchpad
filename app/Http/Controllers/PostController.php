<?php

/*
 * TODO
 * Code type chooser
 * */

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function create(){
        $post = new Post();

        $url_edit = $this->generateCode();
        $url_view = $this->generateCode($url_edit);

        if($url_edit && $url_view){
            $post->url_edit = $url_edit;
            $post->url_view = $url_view;
            $post->save();

            return redirect()->route('show', ['slug' => $url_edit]);
        }else{
            abort(500);
        }
    }

    public function show($slug){
        $post = Post::where('url_edit', $slug)->orWhere('url_view', $slug)->first();

        if($post){
            $post_edit = $post->url_edit == $slug ? 1 : 0;

            return view('post.view', ['post' => $post, 'post_edit' => $post_edit]);
        }else{
            abort(404);
        }
    }

    public function update(Request $request, $slug){
        if($slug){
            $post = Post::where('url_edit', $slug)->first();

            if($post){
                $post->content = $request->input('content');
                $post->save();
            }
        }
    }

    public function generateCode($check_code = ''){
        $result = '';

        $counter = 0;
        while(!$result && $counter < 10){
            $counter++;
            $new_code = '';
            $chars = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $length = 6;
            for($i = 1; $i <= $length; $i++){
                $new_code .= $chars[rand(0, strlen($chars) - 1)];
            }

            $exists_post = Post::where('url_edit', $new_code)->orWhere('url_view', $new_code)->first();

            if(!$exists_post){
                $result = $new_code;
            }
            if($result && $check_code && $result == $check_code){
                $result = '';
            }
        }

        return $result;
    }
}
