<?php

namespace Hsvisus\Sms;

use Illuminate\Support\ServiceProvider;

class SmsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sms', function ($app) {
            return new ShortNote();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //路由
        //$this->loadRoutesFrom(__DIR__.'/routes.php');
        //配置文件
        $this->publishes([
           __DIR__.'/Config/config.php' => config_path('sms.php'),
        ]);
        //数据迁移
        $migrations = [
           __DIR__.'/Migrations/2021_08_27_171451_create_verification_code_table.php',
        ];
        $this->loadMigrationsFrom($migrations);
    }
}
