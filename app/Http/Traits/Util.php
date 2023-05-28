<?php

namespace App\Http\Traits;

use App\Currency;
use \DB;
use \Carbon;
use App\Models\Country;

trait Util
{
    /**
     * Gives a list of all currencies
     *
     * @return array
     */
    public static function allCurrencies()
    {
        $currencies = Currency::select('id', DB::raw("concat(country, ' - ',currency, '(', code, ') ') as info"))
            ->orderBy('country')
            ->pluck('info', 'id');

        return $currencies;
    }
    
    /**
     * Gives a list of all timezone
     *
     * @return array
     */
    public static function allTimeZones()
    {
        $datetime = new \DateTimeZone("EDT");

        $timezones = $datetime->listIdentifiers();
        $timezone_list = [];
        foreach ($timezones as $timezone) {
            $timezone_list[$timezone] = $timezone;
        }

        return $timezone_list;
    }

    /**
     * get all monthes
     * 
     * @return array
     */
    public static function getAllMonthes()
    {
        // $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = __('business.months.' . $i);
        }
        return $months;
    }

    /**
     * Gives a list of all accouting methods
     *
     * @return array
     */
    public static function allAccountingMethods()
    {
        return [
            'fifo' => __('business.fifo'),
            'lifo' => __('business.lifo')
        ];
    }
    
    /**
     * get all countries
     * 
     * @return array
     */
    public static function getAllCountries()
    {
        return Country::select('id','country_name')->pluck('country_name', 'id');

        return $currencies;
    }
    
    public static function availableModules()
    {
        return [
            'purchases' => ['name' => __('purchase.purchases')],
            'add_sale' => ['name' => __('sale.add_sale')],
            'pos_sale' => ['name' => __('sale.pos_sale')],
            'stock_transfers' => ['name' => __('lang_v1.stock_transfers')],
            'stock_adjustment' => ['name' => __('stock_adjustment.stock_adjustment')],
            'expenses' => ['name' => __('expense.expenses')],
            'account' => ['name' => __('lang_v1.account')],
            'tables' => [ 'name' => __('restaurant.tables'),
                        'tooltip' => __('restaurant.tooltip_tables')
                    ] ,
            'modifiers' => [ 'name' => __('restaurant.modifiers'),
                    'tooltip' => __('restaurant.tooltip_modifiers')
                ],
            'service_staff' => [
                    'name' => __('restaurant.service_staff'),
                    'tooltip' => __('restaurant.tooltip_service_staff')
                ],
            'booking' => ['name' => __('lang_v1.enable_booking')],
            'kitchen' => [
                'name' => __('restaurant.kitchen_for_restaurant')
            ],
            'subscription' => ['name' => __('lang_v1.enable_subscription')],
            'types_of_service' => ['name' => __('lang_v1.types_of_service'),
                        'tooltip' => __('lang_v1.types_of_service_help_long')
                    ]
        ];
    }
    
    public static function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = '';
        $decimal_separator  = '';

        if (!empty($currency_details)) {
            $thousand_separator = $currency_details->thousand_separator;
            $decimal_separator = $currency_details->decimal_separator;
        } else {
            $thousand_separator = session()->has('currency') ? session('currency')['thousand_separator'] : '';
            $decimal_separator = session()->has('currency') ? session('currency')['decimal_separator'] : '';
        }

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }
    
     /**
     * Uploads document to the server if present in the request
     * @param obj $request, string $file_name, string dir_name
     *
     * @return string
     */
    public static function uploadFile(&$request, $file_name, $dir_name, $file_type = 'document')
    {
        //If app environment is demo return null
        if (config('app.env') == 'demo') {
            return null;
        }
        
        $uploaded_file_name = null;
        if ($request->hasFile($file_name) && $request->file($file_name)->isValid()) {
            
            //Check if mime type is image
            if ($file_type == 'image') {
                if (strpos($request->$file_name->getClientMimeType(), 'image/') === false) {
                    throw new \Exception("Invalid image file");
                }
            }

            if ($file_type == 'document') {
                if (!in_array($request->$file_name->getClientMimeType(), array_keys(config('constants.document_upload_mimes_types')))) {
                    throw new \Exception("Invalid document file");
                }
            }
            
            if ($request->$file_name->getSize() <= config('constants.document_size_limit')) {
                $new_file_name = time() . '_' . $request->$file_name->getClientOriginalName();
                if ($request->$file_name->storeAs($dir_name, $new_file_name)) {
                    $uploaded_file_name = $new_file_name;
                }
            }
        }

        return $uploaded_file_name;
    }
    
    
    public static function generateDateFillter()
    {
        
        return [
            'this_yr' => [
                'start' => Carbon::today()->startOfYear()->toDateString(),
                'end' => Carbon::today()->endOfYear()->toDateString()
            ],
            'this_month' => [
                'start' => date('Y-m-01'),
                'end' => date('Y-m-t')
            ],
            'this_week' => [
                'start' => date('Y-m-d',strtotime('monday this week')),
                'end' => date('Y-m-d', strtotime('sunday this week'))
            ]
        ];
    }
    
    /**
     * Converts date in business format to mysql format
     *
     * @param string $date
     * @param bool $time (default = false)
     * @return strin
     */
    public static function uf_date($date, $time = false)
    {
        $date_format = session('business.date_format');
        $mysql_format = 'Y-m-d';
        if ($time) {
            if (session('business.time_format') == 12) {
                $date_format = $date_format . ' h:i A';
            } else {
                $date_format = $date_format . ' H:i';
            }
            $mysql_format = 'Y-m-d H:i:s';
        }

        return !empty($date_format) ? \Carbon::createFromFormat($date_format, $date)->format($mysql_format) : null;
    }
    
    /**
     * Increments reference count for a given type and given business
     * and gives the updated reference count
     *
     * @param string $type
     * @param int $business_id
     *
     * @return int
     */
    // public static function setAndGetReferenceCount($type, $business_id = null)
    // {
    //     if (empty($business_id)) {
    //         $business_id = request()->session()->get('user.business_id');
    //     }

    //     $ref = ReferenceCount::where('ref_type', $type)
    //                       ->where('business_id', $business_id)
    //                       ->first();
    //     if (!empty($ref)) {
    //         $ref->ref_count += 1;
    //         $ref->save();
    //         return $ref->ref_count;
    //     } else {
    //         $new_ref = ReferenceCount::create([
    //             'ref_type' => $type,
    //             'business_id' => $business_id,
    //             'ref_count' => 1
    //         ]);
    //         return $new_ref->ref_count;
    //     }
    // }
}