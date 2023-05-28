<?php 

namespace App\Interfaces;

use App\Business;

interface BusinessInterface extends MainInterface
{
    public function addBusiness(array $businessData);
}