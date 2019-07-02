<?php

namespace App\Http\Controllers\Myadmin;

use Auth;
use Session;
use App\Blog;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource; // importing Article model as ArticleResource 


class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin',['except' => ['apiCheckUnique','getAllBlogs','store']]); // for admin authentication
        $this->middleware('superadmins'); //for role access

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('myadmin/blog/index');
    }

    public function getAllBlogs()
    {
        $blogs = Blog::orderBy('created_at','desc')->paginate(5); // to get all data use get() instead of paginate()

        //return collection of articles as resource
        return BlogResource::collection($blogs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('myadmin/blog/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = $request->isMethod('put') ? Blog::findOrFail($request->article_id) : new Blog;

        $article->id                = $request->input('article_id');
        // $article->slug              = $request->input('slug');
        // $article->auther_id         = $request->input('auther_id');
        $article->title             = $request->input('title');
        $article->body              = $request->input('body');
        // $article->excerpt           = $request->input('excerpt');
        // $article->featured_image    = $request->input('featured_image');
        // $article->status            = $request->input('status');
        // $article->type              = $request->input('type');
        // $article->published_at      = $request->input('published_at');
        $article->created_at        = $request->isMethod('put') ? $request->input('created_at') :date("Y-m-d H:i:s");
        $article->updated_at        = date("Y-m-d H:i:s");

        if($article->save()){

            return new BlogResource($article);
        }
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
    }

    public function apiCheckUnique(Request $request){

        return json_encode(!Blog::where('slug', '=',$request->slug)->exists());
    }
}
