<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Placepost;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Log;


//use Intervention\Image\Facades\Image;

class AttachmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function store(Request $request)
    {
        $attachments = [];
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach($files as $file) {
                $filename = str_random().filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL);
                $payload = [
                    'filename' => $filename,
                    'bytes' => $file->getClientSize(),
                    'mime' => $file->getClientMimeType()
                ];
                $file->move(attachments_path(), $filename);

                $attachments[] = ($id = $request->input('placepost_id'))
                    ? \App\Placepost::findOrFail($id)->attachments()->create($payload)
                    : Attachment::create($payload);
            }
        }

        return response()->json($attachments, 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy(Attachment $attachment) {
        $path = attachments_path($attachment->name);
        if (\File::exists($path)) {
            \File::delete($path);
        }
        $attachment->delete();
        return response()->json(
            $attachment,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
//    public function show() {
//        $images = Attachment::where('placepost_id', '=', '50')->get();
//
//        $imageAnswer = [];
//
//        foreach ($images as $image) {
//            $imageAnswer[] = [
//                'filename' => $image->filename,
//                'bytes' => $image->bytes
//            ];
//        }
//
//        return response()->json([
//            'images' => $imageAnswer
//        ]);
//    }
    public function getServerImages($id) {
//        $attachments = [];

//        $images = Image::get('filename');
//        $attachments = Attachment::where('placepost_id', '=', $id)->get();
        Log::info('LOG :: AttachController getServerImages : '.$id);
        $images = Attachment::where('placepost_id', '=', $id)->get();

        $imageAnswer = [];

        foreach ($images as $image) {
            $imageAnswer[] = [
                'id' => $image->id,
                'filename' => $image->filename,
                'bytes' => $image->bytes
            ];
        }

        return response()->json([
            'images' => $imageAnswer
        ]);
    }
}
