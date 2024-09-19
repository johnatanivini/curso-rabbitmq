<?php 
 
 namespace App\Classes;

use Symfony\Component\Dotenv\Dotenv as EnvDot;

 class DotEnv  {
     static function init() {
            $dotenv = new EnvDot();
            $dotenv->load(__DIR__.'/../../.env');
     }
 }

