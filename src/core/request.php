<?php

namespace App\Core;

class Request
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function getBody()
    {
        if ($this->getMethod() === 'GET') {
            return $_GET;
        }

        if ($this->getMethod() === 'POST') {
            return $_POST;
        }

        return [];
    }
}