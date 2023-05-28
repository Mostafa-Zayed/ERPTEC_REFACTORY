<?php

namespace App\Interfaces\Shipment;


use App\Transaction;

interface ShipmentInterface
{
    public function prepareOrder($transaction);
}