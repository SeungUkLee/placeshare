
{{--<div class="row" style= "background-color: #FFFFF8">--}}
    {{----}}
    {{--<div class="col-sm-3">--}}
        {{--<img style="width: 100%; height: 5vh" src="{{$placepost->attachments->first()->url}}"  alt="image">--}}
        {{--<img class="img-thumbnail" src=""  alt="image">--}}
    {{--</div>--}}

    {{--<div class="col-sm-9" >--}}
        {{--<div class="container">--}}
            {{--<h4 class="media-heading">--}}
                {{--<a href="{{ route('placeposts.show', $placepost->uuid) }}">--}}
                    {{--{{ $placepost->title }}--}}
                {{--</a>--}}
            {{--</h4>--}}

            {{--<p class="text-muted">--}}
                {{--<a> {{ $placepost->user->name }} </a>--}}
                {{--<small>--}}
                    {{--• {{ $placepost->created_at->diffForHumans() }}--}}
                {{--</small>--}}
            {{--</p>--}}
            {{--</div>--}}


        {{--</div>--}}
        {{--@if ($viewName === 'articles.index')--}}
        {{--@include('tags.partial.list', ['tags' => $article->tags])--}}
        {{--@endif--}}

        {{--@if($viewName === 'placeposts.show')--}}
        {{--@include('attachments.partial.list', ['attachments' => $placepost->attachments])--}}
        {{--@endif--}}
    {{--</div>--}}
{{--</div>--}}

<div class="media">

    <div class="media-body" style= "background-color: #FFFFF8">
        <div class="container">
            <h4 class="media-heading">
                <a href="{{ route('placeposts.show', $placepost->uuid) }}">
                        {{ $placepost->title }}
                </a>
            </h4>

            <p class="text-muted">
                <a> {{ $placepost->user->name }} </a>
                <small>
                    • {{ $placepost->created_at->diffForHumans() }}
                </small>
            </p>
        </div>
        {{--@if ($viewName === 'articles.index')--}}
            {{--@include('tags.partial.list', ['tags' => $article->tags])--}}
        {{--@endif--}}

        {{--@if($viewName === 'placeposts.show')--}}
            {{--@include('attachments.partial.list', ['attachments' => $placepost->attachments])--}}
        {{--@endif--}}
    </div>
</div>
