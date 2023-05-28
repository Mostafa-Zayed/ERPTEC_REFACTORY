<?php 

namespace Modules\Superadmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Superadmin\Interfaces\PackageInterface;
use \Module;
use App\System;

class PackageController2 extends Controller
{
    
    private $packageInterface;
    
    public function __construct(PackageInterface $packageInterface)
    {
        $this->packageInterface = $packageInterface;
    }
    public function index()
    {
        dd(Module::toCollection()->toArray());
    }
    
    
    private function isModuleInstalled($name)
    {
        if(Module::has($name)) {
            if(System::getProperty(strtolower($name . '_version'))) {
                return true;
            }
        }
        
        return false;
    }
}