<?php
namespace MCF7;

class Users
{
    public $user;
    public function __construct()
    {
         $this->user=wp_get_current_user();
    }
}
