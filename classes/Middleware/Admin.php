<?php

class Admin
{
    public function handle()
    {
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            header('location: /login');
            exit();
        }
    }
}