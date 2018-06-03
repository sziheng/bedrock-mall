<?php

namespace Bedrock\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Bedrock\Http\Controllers\Controller;



class UploadController extends Controller
{

    /**
     * Create by szh
     * @param Request $request
     */
    public function upload(Request $request)
    {
        //图片上传
        if ($request->file('thumbs')){
            $path = $request->file("thumbs")->storePublicly(date('Y-m-d',time()));
            $params['thumb'] = '/storage/'. $path;
            return json_encode($params['thumb']);
        }
    }

}



