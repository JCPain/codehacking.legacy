<?php
namespace App\Http\Controllers;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

use App\Http\Requests\PostsCreateRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;
use App\Photo;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::paginate(2);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::pluck('name', 'id')->all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        //
        $input = $request->all();
        
        $user = Auth::user();

        if($file = $request->file('photo_id')) {

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;

        }

         $user->posts()->create($input);

         Session::flash('msg-created', 'Post named ' . $input['title'] . ' has been created.');

         return redirect('/admin/posts');

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
        //
        $post = Post::findOrFail($id);

        $categories = Category::pluck('name', 'id')->all();

        return view('admin.posts.edit', compact('post', 'categories'));
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
        //
        // UPDATE THE POST
        $input = $request->all();

        $post = Post::findOrFail($id);

        // check if there's a new uploaded picture
        if($file = $request->file('photo_id')) {

            // save the new uploaded picture
            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;
 
            // Delete old photo path from the photo table and delete photo in the public directory as well
            if($post->photo_id)
            {
                $photo = Photo::findOrFail($post->photo_id);
    
                unlink(public_path() . $photo->file);

                $photo->delete();
            }

        }

        Auth::user()->posts()->whereId($id)->first()->update($input);

        Session::flash('msg-updated', 'Post named ' . $post->title . ' has been updated.');

        return redirect('/admin/posts');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::findOrFail($id);

        if($post->photo->id) {

            // Delete old photo path from the photo table and delete photo in the public directory as well
            $photo = Photo::findOrFail($post->photo->id);
            
            unlink(public_path() . $post->photo->file);
    
            $photo->delete();

        }
            
        // Delete the post
        $post->delete();

        Session::flash('msg-deleted', 'Post named ' . $post->title . ' has been deleted.');

        return redirect('/admin/posts');

    }
}
