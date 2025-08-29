<?php

// app/View/Admin/AdminAccountViewModel.php
namespace App\View\Admin;
class AdminAccountViewModel
{
    public $adminAccounts;
    public function __construct($adminAccounts)
    {
        $this->adminAccounts = $adminAccounts;
    }
}
