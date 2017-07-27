@extends('layouts.app')

@section('content')

    <div class="container">
        <form id="editForm" action="{{ route('placeposts.update', $placepost->id) }}" method="POST" enctype="multipart/form-data" class="form__article">
            {!! csrf_field() !!}
            {!! method_field('PUT') !!}

            @include('placeposts.partial.form')

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">
                    저장하기
                </button>
            </div>
        </form>
    </div>
@stop