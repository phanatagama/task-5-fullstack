<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticlesResource;
use App\Models\Articles;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get articles
        $posts = Articles::latest()->paginate(5);

        //return collection of articles as a resource
        return new ArticlesResource(true, 'List Data Articles', $posts);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
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
            'user_id'   => auth()->id(),
            'categories_id' => Categories::whereBelongsTo(auth()->user())->pluck('id')->first(),
        ]);

        // return response
        return new ArticlesResource(true, 'Data Articles Berhasil Ditambahkan!', $articles);
    }

    /**
     * show
     *
     * @param  mixed $articles
     * @return void
     */
    public function show($id)
    {
        //return single article as a resource
        return new ArticlesResource(true, 'Data Article Ditemukan!', Articles::find($id));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $article
     * @return void
     */
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
        return new ArticlesResource(true, 'Data Article Berhasil Diubah!', $articles);
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
        return new ArticlesResource(true, 'Data Article Berhasil Dihapus!', null);
    }
}
