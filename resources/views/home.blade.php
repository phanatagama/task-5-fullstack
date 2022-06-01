@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
         <div class="row col">
             <div class="card">
                 <div class="card-body">
                 <a href="{{ '/articles/create/'}}" class="btn btn-primary my-3"><i class="bi bi-plus">Add Article</i></a>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Image</th>
                            <th scope="col">Author</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                            <th scope="row">{{ $article->id }}</th>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->content }}</td>
                            <td><img width="32" height="32" src="{{ 'http://127.0.0.1:8000/storage/articles/' . $article->image }}" alt=""></td>
                            <td>{{ $article->user->name }}</td>
                            <td class="d-flex">
                                <a href="{{ '/articles/edit/' . $article->id }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                <form action='{{ "/articles/" . $article->id }}' method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-danger" data-method="DELETE"><i class="bi bi-trash3-fill"></i></button>
                                </form>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                 </div>
             </div>
            
        </div>
    </div>
<!-- <table-component></table-component> -->
@endsection

@section('devscript')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('.table').DataTable();
        } );
    </script>
@endsection
