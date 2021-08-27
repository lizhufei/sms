<?php


namespace Hsvisus\Sms\Modules;

class Notification
{
    /**
     * 发送我短信
     * @param string $phone
     * @param array $code
     * @param string $templ
     * @param string $content
     * @return bool
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    public function message(string $phone, array $code, string $templ, string $content='')
    {
        $sms = new Sms();
        $result = $sms->setGateway(config('sms.operator', 'qcloud'))
            ->setTemplate($templ)
            ->setCode($code)
            ->setContent($content)
            ->send($phone);
        if ('success' == $result['status']){
            return true;
        }
        file_put_contents('sms_error.txt', var_export($result, true).'-'.date('YmdHis').PHP_EOL);
        return false;
    }

}
