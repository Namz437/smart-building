<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected $response = [
        'success' => true,
        'data' => null,
        'message' => null
    ];

    public function __construct($response = null)
    {
        if ($response != null) {
            $this->response = $response;
        }
    }
}
