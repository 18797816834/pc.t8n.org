<?php
namespace Dingtalk;
use extend\Curl\Curl;
/**
 * Created by PhpStorm.
 * User: cyk
 * Date: 2017/11/13
 * Time: 14:33
 */

class DingTalk
{
    /**
     * 企业
     */
    private $corpid = "dingd3ce2c2d2efb747235c2f4657eb6378f";
    private $corpsecret = "px65d90_F7pzcOrYR4O07vFmkQf4cFqFeOL-0j26-G1XStOvhHn93NKOVhIOwJm5";
    private $SSOsecret = "us8k2laU4ckSdnGKNXVnIoUzQPjV0YKo4VWkbhJh_-wAEjmH1Hvu9awx29cTfg-c";
    private $host = 'https://oapi.dingtalk.com';

    /**
     * 免登服务
     */
    private $agentId = "133553220";
    private $nonceStr;


    /**
     * isv 套件
     */
    private $token = 'ceshidingding';
    private $encodingAesKey = 'Gj3992HD0U90jGj3992HD0UGj3992HD0UGj3992HD0U';
    
    public function ceshi(){
        return $this->token;
    }

    private function httpGet($url, $params = array())
    {
        $host = $this->host;
        $real_url = $host . '/' . $url;
        if (!empty($params)) {
            $real_url .= '?';
            foreach ($params as $k => $val) {
                $real_url .= "$k=$val&";
            }
        }
        $real_url = rtrim($real_url, '&');
        $result = http_request($real_url);
        return json_decode($result, true);
    }

    private function httpPost($url, $params = array())
    {
        $host = $this->host;
        $real_url = $host . '/' . $url;
        $curl = new \Curl\Curl();
        $curl->init();
        $data = json_encode($params, JSON_UNESCAPED_UNICODE);//参数json
        // var_dump($data);
        $curl->setHeaders(array('Content-Type'=>'application/json'));
        $result = $curl->post($real_url, $data);
        $curl->close();
        return json_decode($result, TRUE);
    }

    /**
     * start of 建立连接
     */
    public function getAccessToken()
    {
        /**
         * 缓存accessToken。accessToken有效期为两小时，需要在失效前请求新的accessToken。
         */
        $corpid = $this->corpid;
        $corpsecret = $this->corpsecret;
        $response = $this->httpGet('gettoken', array('corpid' => $corpid, 'corpsecret' => $corpsecret));
        if ($response['errcode'] == 0) {//正确返回
            $accessToken = $response['access_token'];
        }
        return $accessToken;
    }
    public function get_all_users($user_id)
    {
        $accessToken = $this->getAccessToken();
        $response = $this->httpGet('user/get', array('access_token' => $accessToken, 'userid' => $user_id));
        return $response;
    }

    /**
     * 通过CODE换取用户身份
     * @param  string $code 通过Oauth认证会给URL带上CODE
     * @return mixed [type]       [description]
     */
    public function userGetUserInfo($code = '')
    {
        $accessToken = $this->getAccessToken();
        $response = $this->httpGet('user/getuserinfo', array('access_token' => $accessToken, 'code' => $code));
        return $response;
    }

    /**
     * @author cyk
     * @return mixed
     * 获取企业员工人数
     */
    public function get_users_count()
    {
        $accessToken = $this->getAccessToken();
        $response = $this->httpGet('/user/get_org_user_count', array('access_token' => $accessToken, 'onlyActive' => 1));
        return $response;
    }

    public function get_agent_id()
    {
        $agent_id = $this->agentId;
        return $agent_id;
    }

    /**
     * 企业会话消息接口
     * 企业可以主动发消息给员工，消息量不受限制
     * @param  array $content array($touser,$toparty,$agentid,$msgtype,$text)
     * @return mixed [type]          [description]
     */
    public function messageSend($content = array())
    {
        $accessToken = $this->getAccessToken();
        $response = $this->httpPost('message/send?access_token=' . $accessToken, $content);
        return $response;
    }

    //发送各类型信息到钉钉
    public function send_msg($msg_type, $to_user, $to_party, $data)
    {
        $agent_id = $this->get_agent_id();
        $content = array(
            'touser' => $to_user,
            'toparty' => $to_party,
            'agentid' => $agent_id,
            'msgtype' => $msg_type,
            $msg_type => $data);
        $info = $this->messageSend($content);
        return $info;
    }


    /**
     * 获取jsapi_ticket
     */
    public function getJsApiTicket()
    {
        $accessToken = $this->getAccessToken();
        $response = $this->httpGet('get_jsapi_ticket', array('access_token' => $accessToken, 'type' => 'jsapi'));
        $js_ticket = $response['ticket'];
        return $js_ticket;
    }
    public static function sign($ticket, $nonceStr, $timeStamp, $url)
    {
        $plain = 'jsapi_ticket=' . $ticket .
            '&noncestr=' . $nonceStr .
            '&timestamp=' . $timeStamp .
            '&url=' . $url;
        return sha1($plain);
    }

    /**免登服务所需校验
     * @return mixed
     */
    public function getConfig()
    {
        $corpId = $this->corpid;
        $agentId = $this->agentId;
        $nonceStr = $this->nonceStr;
        $timeStamp = time();
        $url = '';
        $ticket = $this->getJsApiTicket();
        $signature = $this->sign($ticket, $nonceStr, $timeStamp, $url);
        $config = array(
            'url' => $url,
            'nonceStr' => $nonceStr,
            'agentId' => $agentId,
            'timeStamp' => $timeStamp,
            'corpId' => $corpId,
            'signature' => $signature);
        return json_encode($config, JSON_UNESCAPED_SLASHES);
    }

}