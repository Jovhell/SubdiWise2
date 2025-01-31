<?php

class User
{
    public function handle()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'user') {
            header('location: /login');
            exit();
        }
    }
}