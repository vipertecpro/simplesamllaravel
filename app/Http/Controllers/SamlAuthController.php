<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SamlAuthController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Redirect to saml auth login page.
     */
    public function index()
    {
        return view('home');
    }
}
