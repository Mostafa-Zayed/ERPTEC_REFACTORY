<?php

namespace App\Repositories;

use App\Interfaces\ModuleInterface;
use \Module;
use App\System;

class ModuleRepository implements ModuleInterface
{
    public function isInstalled($module_name)
    {
        $is_available = Module::has($module_name);

        if ($is_available) {
            $module_version = System::getProperty(strtolower($module_name) . '_version');
            return empty($module_version) ? false : true;
        }
      
        return false;
    }
}