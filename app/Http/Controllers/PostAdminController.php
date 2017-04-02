<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostAdminController extends Controller
{
   
   private $post;
   public function __construct(Post $post) {
       $this->post = $post;
   }

   public function index(){
       
       $posts = $this->post->paginate(5);
       
       return view('admin.post.index', compact('posts'));
   }
   public function create(){
       return view('admin.post.create');
   }
   public function store(PostsRequest $request){
       
       
       $this->post->create($request->all());
       
       return redirect()->route('admin.posts.index');
   }
   public function edit($id){

       $post = $this->post->find($id);

       return view('admin.post.edit', compact('post'));
   }
   public function update($id, PostsRequest $request){
        $this->post->find($id)->update($request->all());
        return redirect()->route('admin.posts.index');
   }
   public function destroy($id){
       DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       $this->post->find($id)->delete();
       DB::statement('SET FOREIGN_KEY_CHECKS=1;');

       return redirect()->route('admin.posts.index');
   }

}
