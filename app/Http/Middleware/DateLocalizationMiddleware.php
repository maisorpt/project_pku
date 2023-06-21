<?php
namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class DateLocalizationMiddleware
{
    public function handle($request, Closure $next)
    {
        app()->setLocale('id');
        Carbon::setLocale('id');

        return $next($request);
    }
}