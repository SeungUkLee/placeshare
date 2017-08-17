<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlacepostsRequest;
use App\Placepost;
use Illuminate\Database\Eloquent\Collection;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Webpatser\Uuid\Uuid;


class PlacepostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $placeposts = \App\Placepost::with('user')->get(); // 다른사람 글까지 보임...
        $user = \Auth::user(); // 세션에서 현재 로그인한 사용자의 정보를 가져오기위해 Auth::user() 메서드를 사용
        $placeposts = Placepost::where('user_id', $user->id)->get();

        return view('placeposts.index', compact('placeposts')); // compact 는 변수와 그 값을 배열로 만들어줌
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $placepost = new Placepost();

        return view('placeposts.create', compact('placepost'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        return __METHOD__ .'store page';
//    }
    public function store(\App\Http\Requests\PlacepostsRequest $request) {

        $user = $request->user();
        $placepost = $user->placeposts()->create(
            $request->getPayload()
        );
        
        if (! $placepost) {

            return back()->withInput();
        }
        // 첨부파일 연결
        $request->getAttachments()->each(function ($attachment) use ($placepost) {

            $attachment->placepost()->associate($placepost);
            $attachment->save();
        });
//        return $this->respondCreated($placepost);
        return redirect(route('placeposts.index'));

//        $placepost = new Placepost([
//            'title' => $request->get('title'),
//            'content' => $request->get('content'),
//            'uuid' => Uuid::generate(),
//            'lat' => 100,
//            'lon' => 100,
//        ]);
//
//        $user = \Auth::user();
//
//        $placepost->user()->associate($user->id);
//        $placepost->save();
//
//        if(! $placepost) {
//            return back()->with('flash_message', '글이 저장되지 않습니다.')->withInput();
//        }
//
//        return redirect(route('placeposts.index'))->with('flash_message', '작성하신 글이 저장되었습니다.');
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
//        $placepost = Placepost::find($uuid);
        $placepost = Placepost::where('uuid', '=', $uuid)->first();

        if($placepost == null) {
//            abort(404, $uuid, ' Model not found(모델을 찾을 수 없습니다.)');
            abort(404, ' Model not found(모델을 찾을 수 없습니다.)');
        }

        return view('placeposts.show')->with('placepost',$placepost);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Placepost $placepost)
    {
        $this->authorize('update', $placepost);

        return view('placeposts.edit', compact('placepost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlacepostsRequest $request, Placepost $placepost)
    {
        $this->authorize('update', $placepost);

        $placepost->update($request->all());

//        return $this->respondUpdated($placepost);
        return redirect(route('placeposts.show', $placepost->uuid));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Placepost $placepost)
    {
        $this->authorize('delete', $placepost);
        $this->deleteAttachments($placepost->attachments);
        $placepost->delete();

        return response()->json([], 204, [], JSON_PRETTY_PRINT);
//        return redirect(route('/placeposts'));
    }

    public function deleteAttachments(Collection $attachments)
    {
        $attachments->each(function ($attachment) {
            $filePath = attachments_path($attachment->filename);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            return $attachment->delete();
        });
    }

//    protected function respondCreated($placepost)
//    {
//        return redirect(route('placeposts.index'));
//    }

    public function getUserPlace() {
        $user = \Auth::user(); // 세션에서 현재 로그인한 사용자의 정보를 가져오기위해 Auth::user() 메서드를 사용
        $placeloaction = Placepost::select('lat','lng', 'title','uuid')->where('user_id', $user->id)->get();

        foreach ($placeloaction as $item) {
            $item->title =
                '<div style="padding:5px"> <a href="/placeposts/'.$item->uuid.'">'.$item->title.'</a> 
                    
                </div>';
        }

        return response()->json([
            'positions' => $placeloaction
        ]);
    }
}
