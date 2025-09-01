<?php

// app/DTOs/Admin/AdminAccountDTO.php
namespace App\DTOs\Admin;
class AdminAccountDTO
{
    public $id;
    public $username;
    public $email;
    public $status;
    public function __construct($id, $username, $email, $status)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->status = $status;
    }
}
