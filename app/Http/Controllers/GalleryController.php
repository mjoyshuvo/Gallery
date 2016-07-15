<?php

namespace App\Http\Controllers;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Image;
use App\Gallery;

use Illuminate\Support\Facades\Validator;


class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function viewGalleryList(){
    	$galleries = Gallery::all();
    	return view('gallery', compact ('galleries'));
    }

    public function saveGallery(Request $request){
    	
        // Validate the request
        $validator = Validator::make($request->all(), [
            'gallery_name' => 'required|min:3',
            ]);

        // Take actions when the validation has failed
        if ($validator->fails()) {
            return redirect('gallery/list')
            ->withErrors($validator)
            ->withInput();
        }
        //Create the gallery
    	$gallery = new Gallery;

    	// Save The Gallery
    	$gallery->name = $request->input('gallery_name');
    	$gallery->created_by = Auth::user()->id;
    	$gallery->published = 1;
    	$gallery->save();

    	return redirect()->back()->with('success', 'Gallery Created Successfully');
    }

    public function viewGalleryPics($id){
    	$gallery = Gallery::findOrFail($id);

    	return view('gallery-view', compact('gallery'));
    }

    public function doImageUpload(Request $request){
    	// get the file from the post request

        $file = $request->file('file');

        // set the file name

        $filename = uniqid() . $file->getClientOriginalName();

        // move the file to correct location
      
        $file->move('gallery/images', $filename);
        
        //creating thumbnail through Intervention package of laravel
        
        
        // save the image details into the database
        $gallery = Gallery::find($request->input('gallery_id'));
        $image = $gallery->images()->create([

            'gallery_id' => $request->input('gallery_id'),
            'file_name' => $filename,
            'file_size' => $file->getClientSize(),
            'file_mime' => $file->getClientMimeType(),
            'file_path' => 'gallery/images/' . $filename,
            'created_by' => Auth::user()->id,
        ]);
        return $image;
    }

    public function deleteGallery($id){
        //find the gallery first
        $currentGallery = Gallery::findOrFail($id);

        // check for the authorized user

        if($currentGallery->created_by != Auth::user()->id){
            abort('403', 'You are not allowed to delete this Gallery');
        }

        //load the image of the current gallery

        $images = $currentGallery->images();

        foreach ($currentGallery->images as $image) {
            unlink(public_path($image->file_path));
        }

        $currentGallery->images()->delete();//delete all the records from the image table
        $currentGallery->delete();//delete all the records from the gallery

        return redirect()->back();

    }
}
