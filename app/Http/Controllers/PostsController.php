<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\Post;
use App\User;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:255',
            'image' => 'max:10240|mimes:jpeg,gif,png'
        ]);
        
        $image = null;
        
        if ($request->file('image')) {
            $file = $request->file('image');
        
            $image = md5(sha1(uniqid(mt_rand(), true))).'.'.$file->getClientOriginalExtension();
            
            // ファイルのアップロード
            Storage::disk('s3')->put($image, file_get_contents($file), 'public');
            
        }
        
        $request->user()->posts()->create([
            'content' => $request->content,
            'image' => $image,
        ]);
    
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $user = User::find(\Auth::user()->id);
        
        if (\Auth::user()->id === $post->user_id) {
            
            $data = [
                'user' => $user,
                'post' => $post,
            ];
            
            $data += $this->counts($user);
            
            return view('posts.edit', $data);
            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required|max:255',
            'image' => 'max:10240|mimes:jpeg,gif,png',
        ]);
        
        $post = Post::find($id);
        
        $image = null;
        
        if ($request->file('image')) {
            $file = $request->file('image');
        
            $image = md5(sha1(uniqid(mt_rand(), true))).'.'.$file->getClientOriginalExtension();
            
            // ファイルのアップロード
            Storage::disk('s3')->put($image, file_get_contents($file), 'public');
            
        }
        
        if (\Auth::user()->id === $post->user_id) {
            
            if ($request->file('image') || $request->image_delete) {
                
                if ($post->image) {
                    Storage::disk('s3')->delete($post->image);
                }
                
                $post->update([
                    'content' => $request->content,
                    'image' => $image,
                ]);
                
            }else {
                $post->update([
                    'content' => $request->content,
                ]);
            }
            
        }
    
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        
        if (\Auth::user()->id === $post->user_id) {
            
            if ($post->image) {
                Storage::disk('s3')->delete($post->image);
            }
            $post->delete();
            
        }
        
        return redirect('/');
    }
}
