@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>
           test 나만의 장소 글 쓰기 test
        </h1>
        <hr/>
        {{--form id 임의로 일단 지정 dropzone 때문--}}
        <form id="createForm" action = "{{route('placeposts.store')}}" method="POST" enctype="multipart/form-data" class="form__article">
            {!! csrf_field() !!}


            @include('placeposts.partial.form')


            <div class="form-group">
                <button type="submit" class="btn-primary">
                    저장하기
                </button>
            </div>
        </form>
    </div>
@stop