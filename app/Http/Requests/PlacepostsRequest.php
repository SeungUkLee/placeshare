<?php

namespace App\Http\Requests;

use App\Attachment;
use Illuminate\Foundation\Http\FormRequest;
use Webpatser\Uuid\Uuid;

class PlacepostsRequest extends FormRequest
{
    protected $dontFlash = ['files'];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
//            'content' => ['required' , 'min:5'],
            'files' => ['array'],
            'files.*' => ['mimes:jpg,png','max:30000'],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute은(는) 필수 입력 항목입니다.',
            'min' => ':attribute은(는) 최소 :min 글자 이상이 필요합니다.',
        ];
    }

    public function attributes()
    {
        return [
            'title' => '제목',
//            'content' => '본문',
        ];
    }

    public function getPayload()
    {
        return array_merge($this->all(), [
//            'notification' => $this->has('notification'),
            'uuid' => Uuid::generate()
        ]);
    }

    /**
     * 사용자 입력 값으로부터 첨부파일 객체를 조회
     *
     * @return Collection
     */
    public function getAttachments()
    {
        return Attachment::whereIn(
            'id',
            $this->input('attachments', [])
        )->get();
    }
}
