<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get Categories
        $posts = Categories::latest()->paginate(5);

        //return collection of Categories as a resource
        return new CategoriesResource(true, 'List Data Categories', $posts);
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
            'name'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create Categories
        $post = Categories::create([
            'name'     => $request->name,
            'user_id'   => auth()->id(),
        ]);

        //return response
        return new CategoriesResource(true, 'Data Categories Berhasil Ditambahkan!', $post);
    }

    /**
     * show
     *
     * @param  mixed $categries
     * @return void
     */
    public function show(Categories $categories)
    {
        //return single post as a resource
        return new CategoriesResource(true, 'Data Post Ditemukan!', $categories);
    }
}
