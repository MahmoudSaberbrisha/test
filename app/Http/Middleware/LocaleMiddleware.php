<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use YlsIdeas\FeatureFlags\Contracts\Features;
use Illuminate\Support\Facades\Cache;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $features = app(Features::class);
        if (!$features->accessible('languages-feature')) {
            Cache::forget('languages');
            session()->put('locale', config('app.locale'));
            App::setLocale(config('app.locale'));
            session()->put('rtl', config('app.locale')=='ar' ? 1 : 0);
        }
        
        $locale = Session::get('locale', config('app.locale'));

        App::setLocale($locale);


        return $next($request);
    }
}
