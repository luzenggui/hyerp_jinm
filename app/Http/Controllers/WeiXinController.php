<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\util\Http;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Log;
use Jenssegers\Agent\Agent;
use GuzzleHttp\Client;
use Cache;


class WeixinController extends Controller
{
    private static $APPNAME = '';

    protected $openId;

    protected $session_key;
    protected $clientId;
    protected $clientSecret;

    public function weixin(){
        return Socialite::with('weixin')->redirect();
    }

    protected function getOpenidUrl()
    {
        return 'https://api.weixin.qq.com/sns/jscode2session';
    }

    protected function getOpenidFields($code)
    {
        $this->clientId=config('env.WEIXIN_KEY');
        $this->clientSecret=config('env.WEIXIN_SECRET');
        return [
            'appid' => $this->clientId, 'secret' => $this->clientSecret,
            'js_code' => $code, 'grant_type' => 'authorization_code',
        ];
    }


    public function login($appname = 'weixin', $url = ''){
        $code = request('code', '');
//        Log::info($code);

//        Log::info($code);
        self::getOpenid($code);

        self::$APPNAME = $appname;
        $access_token=self::getAccessToken();
        $status=21020000;
        $data=[
            "data"=> $access_token,
            "status"=>$status
        ];
        Log::info($data);
        return response()->json($data);
    }

    public static function getconfig($agentid = '')
    {
//        $clientId=config('env.WEIXIN_KEY');
//        $clientSecret=config('env.WEIXIN_SECRET');
//
//        $config = array(
//            'url' => $url,
//            'nonceStr' => $nonceStr,
//            'timeStamp' => $timeStamp,
//            'corpId' => config('custom.dingtalk.corpid'),
//            'signature' => $signature,
//            'ticket' => $ticket,
////            'agentId' => config('custom.dingtalk.agentidlist.' . self::$APPNAME),       // such as: config('custom.dingtalk.agentidlist.approval')      // request('app')
//            'agentId' => $agentid,
//            'appname' => self::$APPNAME,
//            'session' => $corpAccessToken,
//        );

//        return $config;
    }


    public  function getAccessToken() {
        $accessToken = Cache::remember('access_token', 7200/60 - 5, function() {        // 减少5分钟来确保不会因为与钉钉存在时间差而导致的问题
            $url = 'https://api.weixin.qq.com/cgi-bin/token';
            $appid = config('services.weixin.client_id');
            $secret = config('services.weixin.client_secret');
            $grant_type = 'client_credential';
            $params = compact('appid', 'secret','grant_type');
            $reply = self::get($url, $params);
            Log::info($reply);
            $accessToken = array_get($reply,'access_token');
            return $accessToken;
        });
        return $accessToken;
    }

    public  function getOpenid($code) {
            $url = 'https://api.weixin.qq.com/sns/jscode2session';
            $appid = config('services.weixin.client_id');
            $secret = config('services.weixin.client_secret');
            $js_code = $code;
            $grant_type = 'authorization_code';
            $params = compact('appid', 'secret', 'js_code', 'grant_type');
            $reply = self::get($url, $params);
//            Log::info($reply['openid']);
            $openid=array_get($reply,'openid');
            self::setOpenId($openid) ;
            $session_key=array_get($reply,'session_key');
            self::setSessionKkey($session_key);
    }

    public  function setOpenId($openId)
    {
        $this->$openId = $openId;

        return $this;
    }
    public   function setSessionKkey($session_key)
    {
        $this->$session_key = $session_key;

        return $this;
    }
//    private static function get($url, $params)
//    {
//        $response = \Httpful\Request::get($url . '?' . http_build_query($params))->send();
//        if ($response->hasErrors()) {
//            throw new \Exception($response->hasErrors());
//        }
//        if (!$response->hasBody()) {
//            throw new \Exception("No response body.");
//        }
//        if ($response->body->errcode != 0) {
//            throw new \Exception($response->body->errmsg);
//        }
//        return $response->body;
//    }

    private  function get($url, $params)
    {
        $response = \Httpful\Request::get($url . '?' . http_build_query($params))->send();
        Log::info($response);
        if ($response->hasErrors()) {
            throw new \Exception($response->hasErrors());
        }
        if (!$response->hasBody()) {
            throw new \Exception("No response body.");
        }
        if (isset($response->body->errcode) && $response->body->errcode != 0) {
            throw new \Exception($response->body->errmsg);
        }
        return json_decode($response,true);
    }

    public function post($url, $params, $data, $handlererr = true)
    {
        $response = \Httpful\Request::post($url . '?' . http_build_query($params))
            ->body($data)
            ->sendsJson()
            ->send();
        if ($response->hasErrors()) {
            throw new \Exception($response->hasErrors());
        }
        if (!$response->hasBody()) {
            throw new \Exception("No response body.");
        }
        if ($handlererr)
        {
            if ($response->body->errcode != 0) {
                throw new \Exception($response->body->errmsg);
            }
        }

        return json_decode($response,true);
    }
}