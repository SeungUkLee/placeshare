<div class="media">
{{--    @include('users.partial.avatar', ['user' => $placepost->user])--}}

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

