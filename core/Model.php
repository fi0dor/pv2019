<?php

    namespace Core;

    require "core/Database.php";
    require "core/Session.php";

    abstract class Model
    {
        protected $db;
        protected $session;

        public function __construct() 
        {  
            $instance = Database::getInstance(); 
            $this->db = $instance;
            $this->session = new Session();
        }
    } 

?>