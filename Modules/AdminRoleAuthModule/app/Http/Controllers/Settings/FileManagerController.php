<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FileManagerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View File Manager', only: ['index']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('adminroleauthmodule::settings.file-manager.index');
    }

}
