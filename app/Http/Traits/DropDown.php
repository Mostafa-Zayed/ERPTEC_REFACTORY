<?php

namespace App\Http\Traits;

use DB;
use App\Category;
use App\Brands;
use App\Unit;
use App\TaxRate;
use App\SellingPriceGroup;
use App\BusinessLocation;

trait DropDown
{
    public function makeDropDown($model, $show_none = false, $filter_use_for_repair = false, $only_base = true)
    {
        switch ($model) {
            case 'Category':
                
                $categories  = Category::OnlyParent()->Type('product')->select(DB::raw('IF(short_code IS NOT NULL, CONCAT(name, "-", short_code), name) as name'), 'id')
                    ->orderBy('name', 'asc')
                    ->get();
                return $categories;
                
            case 'Brands':
                
                $query = Brands::select('name','id');
                
                if($filter_use_for_repair){
                    $query = $query->RepairModule();
                }
                
                $brands = $query->orderBy('name','asc')->pluck('name','id');    
                
                if ($show_none) {
                    $brands->prepend(__('lang_v1.none'), '');
                }
                return $brands;
                
            case 'Unit':
                
                $query = Unit::select(DB::raw('CONCAT(actual_name, " (", short_name, ")") as name'), 'id');
                    if ($only_base) {
                        $query->whereNull('base_unit_id');
                    }

                $units = $query->pluck('name', 'id');
        
                if ($show_none) {
                    $units->prepend(__('messages.please_select'), '');
                }
        
                return $units;
        }
    }
    
    
    public function taxRateDropDown($prepend_none = true, $include_attributes = false, $exclude_for_tax_group = true)
    {
        $query = TaxRate::select('name','id');
        
        if($exclude_for_tax_group) {
            $query = $query->ExcludeForTaxGroup();
        }
        
        $result = $query->get();
        
        $taxRates = $result->pluck('name','id');
        
        if($prepend_none) {
            $taxRates = $taxRates->prepend(__('lang_v1.none'), '');
        }
        
        $taxAttributes = null;
        
        if($include_attributes) {
            $taxAttributes = collect($result)->mapWithKeys(function ($item) {
                return [$item->id => ['data-rate' => $item->amount]];
            })->all();
        }
        
        $output = ['tax_rates' => $taxRates, 'attributes' => $taxAttributes];
        
        return $output;
        
    }
    
    public function businessLocationDropDown($show_all = false, $receipt_printer_type_attribute = false, $append_id = true, $check_permission = true)
    {
        $query = BusinessLocation::Active();

        if ($check_permission) {
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('id', $permitted_locations);
            }
        }
        

        if ($append_id) {
            $query->select(
                DB::raw("IF(location_id IS NULL OR location_id='', name, CONCAT(name, ' (', location_id, ')')) AS name"),
                'id',
                'receipt_printer_type',
                'selling_price_group_id',
                'default_payment_accounts'
            );
        }

        $result = $query->get();

        $locations = $result->pluck('name', 'id');

        $price_groups = $this->sellPriceGroupDropDown();

        if ($show_all) {
            $locations->prepend(__('report.all_locations'), '');
        }

        if ($receipt_printer_type_attribute) {
            $attributes = collect($result)->mapWithKeys(function ($item) use ($price_groups) {
                $default_payment_accounts = json_decode($item->default_payment_accounts, true);
                $default_payment_accounts['advance'] = [
                    'is_enabled' => 1,
                    'account' => null
                ];
                return [$item->id => [
                            'data-receipt_printer_type' => $item->receipt_printer_type,
                            'data-default_price_group' => !empty($item->selling_price_group_id) && array_key_exists($item->selling_price_group_id, $price_groups) ? $item->selling_price_group_id : null,
                            'data-default_payment_accounts' => json_encode($default_payment_accounts)
                        ]
                    ];
            })->all();

            return ['locations' => $locations, 'attributes' => $attributes];
        } else {
            return $locations;
        }
    }
    
    public function sellPriceGroupDropDown($with_default = true)
    {
        $price_groups = SellingPriceGroup::select('id','name')->active()->get();

        $dropdown = [];

        if ($with_default && auth()->user()->can('access_default_selling_price')) {
            $dropdown[0] = __('lang_v1.default_selling_price');
        }
        
        foreach ($price_groups as $price_group) {
            if (auth()->user()->can('selling_price_group.' . $price_group->id)) {
                $dropdown[$price_group->id] = $price_group->name;
            }
        }
        return $dropdown;
    }
}