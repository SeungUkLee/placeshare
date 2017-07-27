<?php
/**
 * Created by PhpStorm.
 * User: SeungUk
 * Date: 2017. 7. 18.
 * Time: 오전 1:49
 */
// 사용자 정의 헬퍼 함수

if (! function_exists('attachment_path')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function attachments_path($path = '')
    {
        //return public_path($path ? 'attachments' . DIRECTORY_SEPARATOR . $path : 'attachments');
        // public_path : 프로젝트의 웹 서버 루트 디렉토리의 절대경로 반환하는 함수
        return public_path('files'.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }
}

if (! function_exists('format_filesize')) {
    /**
     * Calculate human-readable file size string.
     *
     * @param $bytes
     * @return string
     */
    function format_filesize($bytes)
    {
        if (! is_numeric($bytes)) return 'NaN';
        $decr = 1024;
        $step = 0;
        $suffix = ['bytes', 'KB', 'MB'];
        while (($bytes / $decr) > 0.9) {
            $bytes = $bytes / $decr;
            $step ++;
        }
        return round($bytes, 2) . $suffix[$step];
    }
}

if (! function_exists('current_url')) {
    /**
     * Build current url string, without return param.
     *
     * @return string
     */
    function current_url()
    {
        if (! request()->has('return')) {
            return request()->fullUrl();
        }

        return sprintf(
            '%s?%s',
            request()->url(),
            http_build_query(request()->except('return'))
        );
    }
}
