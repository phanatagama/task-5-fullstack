<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['articles' => Articles::all()]);
    }

    public function create()
    {
        return view('create', ['id' => Auth::id(), 'categories' => Categories::all()]);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $imageName = $image->hashName();
        $image->storeAs('public/articles', $imageName);

        //create articles
        $articles = Articles::create([
            'image'     => $imageName,
            'title'     => $request->title,
            'content'   => $request->content,
            'user_id'   => $request->user_id,
            'categories_id' => $request->category_id,
        ]);

        // return response
        // return new ArticlesResource(true, 'Data Articles Berhasil Ditambahkan!', $articles);
        return redirect('/home');
    }

    public function edit($id)
    {
        return view('edit', ['article' => Articles::find($id), 'users' => User::all(), 'categories' => Categories::all()]);
    }

    public function update(Request $request, $id)
    {
        $articles = Articles::find($id);
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/articles', $image->hashName());

            //delete old image
            Storage::delete('public/articles/'.$articles->image);

            //update articles with new image
            $articles->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content,
            ]);

        } else {

            //update Articles without image
            $articles->update([
                'title'     => $request->title,
                'content'   => $request->content,
            ]);
        }

        //return response
        // return new ArticlesResource(true, 'Data Article Berhasil Diubah!', $articles);
        return redirect('/home');
    }

    /**
     * destroy
     *
     * @param  mixed $article
     * @return void
     */
    public function destroy($id)
    {
        $article = Articles::find($id);
        //delete image
        Storage::delete('public/posts/'.$article->image);

        //delete article
        $article->delete();

        //return response
        return redirect('/home');
    }
}
