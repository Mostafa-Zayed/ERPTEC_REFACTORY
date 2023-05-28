<?php 


namespace App\Interfaces;


interface ModuleInterface
{
    public function isInstalled($module_name);
}