<?php

namespace App\Http\Controllers;



use App\Post;

use App\Repositories\Posts;

use Carbon\Carbon;


class PostsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth')->except(['index','show']);
	}

    public function index(\App\Tag $tag = null)
    {
        // return session('message');

        $posts = Post::all();
        
        // return $tag->posts;

    	


        // selectRaw('year(created_at) year,monthname(created_at) month, count(*) published')
        //         ->groupBy ('year','month')
        //         ->orderByRaw('min(created_at) desc')
        //         ->get()
        //         ->toArray();


        return view('posts.index', compact('posts'));      
    }
    // 	return view ('posts.index', compact('posts'));
    // }

     public function show(Post $post)
    {
        
        // $archives = Post::selectRaw('year(created_at) year,monthname(created_at) month, count(*) published')
        //         ->groupBy ('year','month')
        //         ->orderByRaw('min(created_at) desc')
        //         ->get()
        //         ->toArray();

        return view('posts.show', compact('post')); 
    	// $post = Post::find($id);
    	// return view ('posts.show', compact('post'));
    }

     public function create()
    {
    	return view ('posts.create');
    }

     public function store()
    {
    	$post = new Post;

    	// $post->title = request('title');
    	// $post->body = request('body');

    	// $post->save();

    	$this->validate(request(), [

    		'title' => 'required',
    		'body' => 'required'

    	]);



    	auth()->user()->publish(
    		new Post(request(['title', 'body']))
    	);


        session()->flash(

            'message', 'Your post has now been published.'
        );

    	

    	return redirect('/');
    }
}
