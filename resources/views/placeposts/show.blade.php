@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>
            Placepost 상세보기
        </h1>
        <hr/>

        <article data-id="{{ $placepost->id }}">
            <div class="form-group">
                <label for="title">
                    제목
                </label>
                <input type="text" name="title" id="title" value="{{ $placepost->title }}" class="form-control" readonly="true">
            </div>

            <div class="form-group">
                <label for="content">
                    본문
                </label>
            <textarea name="content" id="content" rows="5" class="form-control" readonly="true">
                {{ $placepost->content }}
            </textarea>
            </div>
                @include('attachments.partial.list', ['attachments' => $placepost->attachments])
            <br>
        </article>

        <div class="text-center">
            <p>
                @can('update', $placepost)
                <a href="{{ route('placeposts.edit', $placepost->id) }}" class="btn btn-info">
                    <i class="fa fa-pencil"></i>
                    수정하기
                </a>
                @endcan
                @can('delete', $placepost)
                {{--destroy 와 show 는 같은 uri로 맵핑되고 메서드가 다르다. destory는 delete, show는 get--}}
                {{--이렇게 하면 get메서드로 보내지기 때문에 destory가 아니라 show가 되버린다 이를 form으로 처리하던지 ajax로 처리하던지--}}
                {{--<a href="{{ route('placeposts.destroy', $placepost->id) }}" class="btn btn-danger">--}}
                    {{--<i class="fa fa-trash-o"></i>--}}
                    {{--삭제하기--}}
                {{--</a>--}}
                <button class="btn btn-danger button__delete">
                    <i class="fa fa-trash-o"></i>
                    삭제하기
                </button>
                @endcan
                <a href="#" class="btn btn-info">위치 수정</a>
                <a href="{{ route('placeposts.index') }}" class="btn btn-default">
                    <i class="fa fa-list"></i>
                    글 목록
                </a>
            </p>
        </div>
    </div>
@stop

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.button__delete').on('click', function (e) {
            console.log('hello')
            var placepostId = $('article').data('id');
            console.log('placepostId')
            if (confirm('글을 삭제합니다.')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/placeposts/' + placepostId
                }).then(function () {
                    window.location.href = '/placeposts';
                });
            }
        });
    </script>
@stop

