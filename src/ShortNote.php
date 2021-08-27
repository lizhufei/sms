<?php


namespace Hsvisus\Sms;

use Hsvisus\Sms\Modules\Notification;
use Hsvisus\Sms\Modules\VerificationCode;

class ShortNote
{
    /**
     * 发送通知短信
     * @param string $phone
     * @param array $code
     * @param string $templ
     * @param string $content
     * @return bool
     */
    public function inform(string $phone, array $code, string $templ, string $content='')
    {
        $sms = new Notification();
        return $sms->message($phone, $code, $templ, $content);
    }

    /**
     * 发送验证码
     * @param string $phone
     * @param string $content
     * @return bool
     */
    public function code(string $phone, string $content='')
    {
        $sms = new VerificationCode();
        return $sms->sendCode($phone, $content);
    }

    /**
     * 检验证码
     * @param string $phone
     * @param string $code
     * @return bool
     */
    public function verify(string $phone, string $code)
    {
        $sms = new VerificationCode();
        return $sms->check($phone, $code);

    }

}
