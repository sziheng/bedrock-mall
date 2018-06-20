<?php

namespace Bedrock\Http\Controllers\Web;

use Bedrock\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
/**
 * Class BaseController
 *
 * @package \Bedrock\Http\Controllers\Web
 */
class BaseController extends Controller
{

    const VERSION = '0.1.0';

    const CODE_NOT_FUND_RESOURCE = 200001;//请求的资源不存在（资源 404）;
    const CODE_PARAM_ILLEGAL     = 200002;//参数不合法，必填的参数没有传入，或类型不合法

    public function __construct()
    {

    }


    /**
     * 找不到资源 统一返回格式
     * @param string $message
     * @return string
     */
    public static function resourceNotFound($message = "Not Found Resource"): string
    {
        return self::encodeResult(self::CODE_NOT_FUND_RESOURCE, $message);
    }

    /**
     * 参数不合法 统一返回格式
     * @param null $message
     * @return string
     */
    public static function parametersIllegal($message = null): string
    {
        return self::encodeResult(self::CODE_PARAM_ILLEGAL, $message);
    }

    /**
     * 统一返回格式
     * @param $msgcode
     * @param null $message
     * @param null $data
     * @param string $nextStep
     * @return string
     */
    public static function encodeResult($msgcode, $message = NULL, $data = NULL, $nextStep = NULL)
    {
        if ($data == null) {
            $data = new \stdClass();
        }

        $result = [
            "requestId"  => 100000,
            'msgcode'    => $msgcode,
            'message'    => $message,
            'response'   => $data,
            'version'    => self::VERSION,
            'next_step'  => $nextStep,
            'servertime' => time()
        ];

        return \Response::json($result);
    }
}
