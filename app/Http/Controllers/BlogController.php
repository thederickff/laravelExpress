<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class BlogController extends Controller
{
    //


    public function index()
    {

        $blogs = Blog::all();
        return view('blog.index', compact('blogs'));
    }

    // Edit data function
    public function editItem(Request $request)
    {

        $blog = Blog::find($request->id);

        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->save();
        return response()->json($blog);
    }

    // Add data into database
    public function addItem(Request $request)
    {
        $rules = array(
            'title' => 'required',
            'description' => 'required'
        );

        // for validator
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()){
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->description = $request->description;
            $blog->save();
            return response()->json($blog);
        }
    }

    // Delete item
    public function deleteItem(Request $request){


        $blog = Blog::find($request->id);
        $blog->delete();
        return response()->json();
    }
    // Get item
    public function getItem(){
        $blogs = Blog::all();

        return response()->json($blogs);
    }
}
