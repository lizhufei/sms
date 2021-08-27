<?php


namespace Hsvisus\Sms\Modules;


use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class Sms
{
    private $config = [];
    private $content = [];
    private $template_id = '';
    private $data = [];
    private $gateway;

    public function __construct(float $timeout=5.0, string $logPath='/public/sms/easy-sms.log')
    {
        $this->config = [
            // HTTP 请求的超时时间（秒）
            'timeout' => $timeout,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
                // 默认可用的发送网关
                'gateways' => [],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => ['file' => $logPath],
            ],
        ];
    }

    /**
     * 设定短信发送网关
     * @param string $name
     * @return $this
     */
    public function setGateway(string $name)
    {
        $this->gateway = $name;
        $this->config['default']['gateways'][] = $name;
        $this->config['gateways'][$name] = $this->deploy($name);
        return $this;
    }

    /**
     * 设定模板ID
     * @param string $tid
     * @return $this
     */
    public function setTemplate(string $tid)
    {
        $this->template_id = $tid;
        return $this;
    }

    /**
     * 设定短信内容替换代码
     * @param array $data
     * @return $this
     */
    public function setCode(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 设定短信内容
     * @param string $content
     * @return $this
     */
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * 发送短信
     * @param string $phone
     * @return array|mixed
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    public function send(string $phone)
    {
        try{
            $sms = new EasySms($this->config);
            $result = $sms->send($phone, [
                'content'  => $this->content,
                'template' => $this->template_id,
                'data' => $this->data
            ]);
            return $result[$this->gateway];
        } catch (NoGatewayAvailableException $e){
            return $e->results;
        }

    }

    /**
     * 网关配置
     * @param string $name
     * @return array|string[]
     */
    private function deploy(string $name):array
    {
        $deploy = [];
        switch ($name){
            case 'aliyun':
                $deploy = [
                    'access_key_id' => config('sms.app_key'),
                    'access_key_secret' => config('sms.app_secret'),
                    'sign_name' => config('sms.sign_name'),
                ];
                break;
            case 'qcloud':
                $deploy = [
                    'sdk_app_id' => config('sms.app_key'), // SDK APP ID
                    'app_key' => config('sms.app_secret'), // APP KEY
                    'sign_name' => config('sms.sign_name'), // 短信签名，如果使用默认签名，该字段可缺省（对应官方文档中的sign）
                ];
                break;
            case 'huawei':
                $deploy = [
                    'endpoint' => '', // APP接入地址
                    'app_key' => config('sms.app_key'), // APP KEY
                    'app_secret' => '', // APP SECRET
                    'from' => [
                        'default' => '1069012345', // 默认使用签名通道号
                        'custom' => 'csms12345', // 其他签名通道号 可以在 data 中定义 from 来指定
                        'abc' => 'csms67890', // 其他签名通道号
                    ],
                    'callback' => '' // 短信状态回调地址
                ];
                break;
            case 'qiniu':
                $deploy = [
                    'secret_key' => '',
                    'access_key' => '',
                ];
                break;
            case 'ucloud':
                $deploy = [
                    'private_key'  => '',    //私钥
                    'public_key'   => '',    //公钥
                    'sig_content'  => '',    // 短信签名,
                    'project_id'   => '',    //项目ID,子账号才需要该参数
                ];
                break;
            case 'smsbao';
                $deploy = [
                    'user'  => '',    //账号
                    'password'   => ''   //密码
                ];
                break;
            case 'rongcloud';
                $deploy = [
                    'app_key' => '',
                    'app_secret' => '',
                ];
                break;
        }
        return $deploy;
    }


}
