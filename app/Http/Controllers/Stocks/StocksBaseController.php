<?php

namespace App\Http\Controllers\Stocks;

use App\Http\Controllers\Controller;

class StocksBaseController extends Controller
{
    /**
     * Base route name for the controller.
     * Example: 'storeitems'
     */
    protected $routeName = '';

    /**
     * Get the base route name.
     */
    public function getRouteName()
    {
        return $this->routeName;
    }
}
