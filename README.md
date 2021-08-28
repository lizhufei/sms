### 短信通知包
- 发布`php artisan vendor:publish --provider="Hsvisus\Sms\SmsProvider"`
```
    /**
     * 发送通知短信
     * @param string $phone
     * @param array $code
     * @param string $templ
     * @param string $content
     * @return bool
     */
    public function inform(string $phone, array $code, string $templ, string $content='')
   /**
     * 发送验证码
     * @param string $phone
     * @param string $content
     * @return bool
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    public function code(string $phone, string $content='')
     /**
     * 检验证码
     * @param string $phone
     * @param string $code
     * @return bool
     */
    public function verify(string $phone, string $code)
```
