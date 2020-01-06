<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\Response::macro('apiReturn',function($content, $code = 0, $codeDesc = '', $httpStatus = 200){


            $data = [
                'statusCode'=>$code,
                'statusDesc'=>$codeDesc,
                'data'=>$content,
            ];

            return   response($data, $httpStatus) ;


        });
    }
}
