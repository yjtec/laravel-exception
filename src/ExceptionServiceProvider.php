<?php
namespace Yjtec\Exception;

use Illuminate\Support\ServiceProvider;

class ExceptionServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app->bind('App\Exceptions\Handler','Yjtec\Exception\Handler');
    }

}
