<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    protected $valid = [
        'title'=>'required|max:150|string',
        'content'=>'required',
        'category_id' => 'nullable|exists:categories,id',
        'tags' => 'exists:tags,id'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->valid);

        $data_form = $request->all();

        //vado a creare lo slug inserendo un - al posto degli spazi
        $slug = Str::slug($data_form['title']);

        //cotrollo se lo slug esiste già, in tal caso inserisco alla fine un - seguito da un numero
        $count = 1;
        while(Post::where('slug', $slug)->first()){
            $slug = Str::slug($data_form['title'])."-".$count;
            $count ++;
        }

        $data_form['slug'] = $slug;
        $new_post = new Post();
        
        $new_post->fill($data_form);
        $new_post->save();
        if(isset($data_form['tags'])){
            $new_post->tags()->sync($data_form['tags']);
        }
        
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if(!$post){
            abort(404);
        }
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->valid);

        $data_form = $request->all();
       
        if($post->title == $data_form['title']){            
            $slug = $post->slug;
        }else{
            $slug = Str::slug($data_form['title']);        
            $count = 1;
            while(Post::where('slug', $slug)->where('id', '!=', $post->id)->first()){
                $slug = Str::slug($data_form['title'])."-".$count;
                $count ++;
            }
        }
        $data_form['slug'] = $slug;
        
        $post->update($data_form);

        $post->tags()->sync(isset($data_form['tags']) ? $data_form['tags'] : []);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
