


<div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
    <label for="place">
        장소
    </label>
    <p id="place"> test </p>
    <input type="hidden" name="lat" id="place-lat" value="">
    <input type="hidden" name="lng" id="place-lng" value="">
</div>


<div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
    <label for="title">
        제목
    </label>
    <input type="text" name="title" id="title" value="{{old('title', $placepost->title)}}" class="form-control">
    {!! $errors->first('title', '<span class="form-error">:message</span>') !!}
</div>





<div class="form-group {{ $errors->has('content') ? 'has-error':'' }}">
    {{--<label for="content">--}}
        {{--본문--}}
    {{--</label>--}}
    {{--<textarea name="content" id="content" rows="5" class="form-control">--}}
        {{--{{old('content', $placepost->content)}}--}}
    {{--</textarea>--}}
    <label for="content"> 본문 </label>
    <textarea name="content" id="content" rows="10" class="form-control">{{ old('content', $placepost->content) }}</textarea>
    {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
</div>


<div class="form-group" id="dropzoneDiv">
    <label for="my-dropzone">Files</label>
    <div id="my-dropzone" class="dropzone"></div>
</div>

{{--<div class="form-group" id="preview-template">--}}
    {{--<label for="my-dropzone">Files</label>--}}
    {{--<div id="dropzonePreview" class="dropzone"></div>--}}
{{--</div>--}}

@section('script')
    @parent
    <script>
        {{--/* Dropzone */--}}
        Dropzone.autoDiscover = false;
        // 드롭존 인스턴스 생성.
//        var placepostId = $('article').data('id');

        // option 방법도 있음..
        var myDropzone = new Dropzone('div#my-dropzone', {
            url: '/attachments',
            paramName: 'files',
            maxFilesize: 3,
            acceptedFiles: '.jpg,.png,.jpeg',
            uploadMultiple: true,
            params: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                placepost_id: '{{$placepost->id}}'
            },
            dictDefaultMessage: '<div class="text-center text-muted">' +
            "<h2>첨부할 파일을 끌어도 놓으세요</h2>" +
            "<p>(또는 클릭하세요.)</p></div>",
            dictFileTooBig: "파일 최대 크기는 3MB 입니다.",
            dictInvalidFileType: 'jpg, png, jpeg 파일만 가능합니다.',
            addRemoveLinks: true,
        });

        var form = $('.form__article').first();  // layouts/app.blade.php 의 logout form에 걸린다.
//        var createform = $('#createForm').first();
//        var editform = $('#editForm').first();

        myDropzone.on('successmultiple', function(file, data) {
            console.log('successmultiple data :'+JSON.stringify(data));
//            console.log('data.length'+data.length);
            console.log('successmultiple file.toString : '+JSON.stringify(file));
            for(var i=0, len=data.length; i<len; i++) {

                $("<input>", {
                    type: "hidden",
                    name: "attachments[]",
                    value:data[i].id
                }).appendTo(form);

                file[i].id = data[i].id;
                file[i].name = data[i].filename;

                console.log('successmultiple file[i].toString : '+JSON.stringify(file[i]));
//                file[i]._url = data[i].url;
            }
//            console.log('file:'+file[0]._id);
        });

            myDropzone.on('removedfile', function(file) {
                // 사용자가 이미지를 삭제하면 UI의 DOM 레벨에서 사라진다.
                // 서버에서도 삭제해야 하므로 Ajax 요청한다.
                console.log("remove file:"+JSON.stringify(file));
                $.ajax({
                    type: 'DELETE',
                    url: '/attachments/' + file.id
                }).then(function(data) {
                    $('input[name="attachments[]"][value="'+data.id+'"]').remove();
                })
            });



        if (Laravel.currentRouteName == 'placeposts.edit') {
//            var placepostId = $('article').data('id');


            var placepostId = '{{$placepost->id}}';
            myDropzone.on("removedfile", function(file) {

            })

            $.get('/server-images/'+placepostId, function(data) {
//                console.log(data.images.length);
//                for(var i=0, len=data.images.length; i<len; i++) {
//
//                    $("<input>", {
//                        type: "hidden",
//                        name: "attachments[]",
//                        value:data.images[i].id
//                    }).appendTo(editform);
//
//                    var file = $("#files")
//                    file._id = data.images[i].id;
//                    file._name = data.images[i].filename;
////                file[i]._url = data[i].url;
//
//                }
                var mockFiles = []
                $.each(data.images, function (key, value) {
                    var mockFile = { id: value.id, name: value.filename, size: value.bytes};
//                    console.log(mockFile);
                    console.log("uploaded :"+data)
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile, '/files/'+value.filename);
//                    myDropzone.createThumbnailFromUrl(file, '/files/'+value.filename);
                    myDropzone.emit("complete", mockFile);
                    mockFiles.push(mockFile);
                });
                myDropzone.emit("successmultiple", mockFiles , data.images);
            });


        };

        //            Dropzone.options.realDropzone = {
        //                previewsContainer: '.dropzoneDiv',
        //                previewTemplate: document.querySelector('div#my-dropzone').innerHTML,
        //                init: function () {
        //                    console.log(Laravel.currentRouteName)
        //                    thisDropzone = this;
        //                    <!-- 4 -->
        //                    $.get('/server-images', placepostId ,function (data) {
        //                        console.log(data)
        //                        <!-- 5 -->
        //                        $.each(data, function (key, value) {
        //                            var mockFile = {name: value.filename, size: value.bytes};
        //                            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
        //                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, attachments_path(value.filename));
        //                        });
        //                    });
        //                }
        //            }



//        var myDropzone = this;
//
//        $.get('/server-images', function(data) {
//
//            $.each(data.images, function (key, value) {
//
//                var file = {name: value.original, size: value.size};
//                myDropzone.options.addedfile.call(myDropzone, file);
//                myDropzone.options.thumbnail.call(myDropzone, file, 'images/icon_size/' + value.server);
//                myDropzone.emit("complete", file);
//                photo_counter++;
//                $("#photoCounter").text( "(" + photo_counter + ")");
//            });
//        });
    </script>

@stop