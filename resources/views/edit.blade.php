@extends('layouts.app')
@section('content')
<section class="section container">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Details</h5>

                    <!-- General Form Elements -->
                    <form action="{{ '/articles/edit/' . $article->id}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control " name="title" required="" value="{{ $article->title }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Content</label>
                            <div class="col-sm-10">
                                <textarea class="form-control " style="height: 100px" name="content" required="">{{ $article->content}}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Image URL</label>
                            <div class="col-sm-10">
                                <input disabled type="img" class="form-control " name="image" required="" value="{{ 'http://127.0.0.1:8000/storage/articles/' . $article->image}}">
                            </div>
                        </div>

                        <!-- <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">User</label>
                            <div class="col-sm-10">
                                <select class="form-select " aria-label="Default select example" name="user_id" required="">
                                    <option disabled="" value="">Choose...</option>
                                    @foreach($users as $user)
                                    <option disabled value="{{ $loop->iteration }}" {{ $user->id === $article->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> -->

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <select class="form-select " aria-label="Default select example" name="category_id" required="">
                                    <option disabled="" value="">Choose...</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $loop->iteration }}" {{ $category->id === $article->category_id ? 'selected' : ''}}>{{ $category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form><!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection