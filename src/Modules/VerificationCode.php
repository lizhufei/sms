<?php
/**
 * 验证码
 */
namespace Hsvisus\Sms\Modules;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hsvisus\Sms\Models\VerificationCode as Code;

class VerificationCode
{
    private $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
                        'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
                        't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',
                        'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',
                        'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
                        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    /**
     * 发送验证码
     * @param string $phone
     * @param string $content
     * @return bool
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    public function sendCode(string $phone, $content='')
    {
        $sms = new Sms();
        $code[0] = array_rand($this->chars, 6);
        $result = $sms->setGateway(config('sms.operator', 'qcloud'))
            ->setTemplate(config('sms.code_template_id', '764328'))
            ->setCode($code)
            ->setContent($content)
            ->send($phone);
        if ('success' == $result['status']){
            Code::updateOrCreate(
                [ 'phone' => $phone,],
                ['code' => $code[0], 'send_time' => date('Y-m-d H:i:s')]
            );
            return true;
        }
        file_put_contents('sms_error.txt', var_export($result, true).'-'.date('YmdHis').PHP_EOL);
        return false;
    }

    /**
     * 检查验证码
     * @param string $phone
     * @param string $code
     * @return bool
     */
    public function check(string $phone, string $code)
    {
        $code = Code::where(['phone'=>$phone, 'code' => $code])->first();
        if ($code){
            $sendTime = Carbon::parse($code->send_time);
            $now = Carbon::now();
            if ($sendTime->addMinutes($code->expired)->lte($now)){
                return true;
            }
        }
        return false;
    }
}
