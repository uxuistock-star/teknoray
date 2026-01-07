<?php

namespace App\Core;

class App
{
    protected Router $router;
    protected Database $db;

    public function __construct()
    {
        $this->router = new Router();
        // Database connection will be initialized on demand or here
        // $this->db = Database::getInstance();
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }
}
