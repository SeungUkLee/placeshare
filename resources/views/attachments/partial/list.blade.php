@if($attachments->count())
    <div id="carousel-single" class="carousel slide add-big-bottom" data-ride="carousel">
        <!-- Indicators -->

        <!-- Wrapper for slides -->
        <div class="carousel-inner" id="myCarousel">

            @foreach($attachments as $attachment)
                <figure class="item preload loaded" data-img-src="{{$attachment->url}}" style="background-image: url('{{$attachment->url}}');">
                </figure>
            @endforeach
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-single" data-slide="prev">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.422 7.406L10.828 12l4.594 4.594L14.016 18l-6-6 6-6z"></path></svg>		</a>
        <a class="right carousel-control" href="#carousel-single" data-slide="next">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9.984 6l6 6-6 6-1.406-1.406L13.172 12 8.578 7.406z"></path></svg>		</a>
    </div>

@endif

@section('script')
    @parent
    <script>
        $(document).ready(function () {
            $('#myCarousel').find('.item').first().addClass('active');
        });
    </script>
@stop

