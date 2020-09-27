<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Photo;

class AdminMediasController extends Controller
{
    //
    public function index() {

        $photos = Photo::all();

        return view('admin.media.index', compact('photos'));

    }

    public function create() {

        return view('admin.media.create');

    }

    public function store(Request $request) {

        // get the file from request
        $file = $request->file('file');

        // get the name of the file and append the time
        $name = time() . $file->getClientOriginalName();

        // move the file to the local storage directory 'images'
        $file->move('images', $name);

        // insert the path in db
        Photo::create(['file' => $name]);

    }

    public function destroy($id) {
        
        $photo = Photo::findOrFail($id);

        unlink(public_path() . $photo->file);

        $photo->delete();

    }

    public function deleteMedia(Request $request) {

        if(isset($request->delete_single)) {

            $photo_id = array_search('Delete', $request->delete_single);

            $this->destroy($photo_id);

            return redirect()->back();

        }

        if(isset($request->delete_all) && !empty($request->checkBoxArray)) {

            $photos = Photo::findOrFail($request->checkBoxArray);

            foreach($photos as $photo) {
    
                unlink(public_path() . $photo->file);
    
                $photo->delete();
    
            }
    
            return redirect()->back();

        } else {
            
            return redirect()->back();

        }
    }
}
