<?php

namespace App\Traits;


trait BusinessUtil
{
    public static function getBusinessId()
    {
        return request()->session()->get('user.business_id');
    }
    
    public function getBusinessSettings($key = null)
    {
        
    }
    
    public static function businessCan($permissions)
    {
        foreach ($permissions as $permission) {
            if (!auth()->user()->can($permission)) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        return true;
    }
    
    public static function getPaymentTypes($business_id = null,$show_advance = false)
    {
        $payment_types = [
            'cash' => __('lang_v1.cash'),
            'card' => __('lang_v1.card'),
            'cheque' => __('lang_v1.cheque'),
            'bank_transfer' => __('lang_v1.bank_transfer'),
            'other' => __('lang_v1.other')
        ];
        
        $custom_labels = !empty(session('business.custom_labels')) ? json_decode(session('business.custom_labels'), true) : [];
        
        if(! empty($business_id)){
            $custom_labels = $this->businessRepository->getById($business_id,['custom_labels']);
            $custom_labels = json_decode($custom_labels, true);
        }
        
        $payment_types['custom_pay_1'] = !empty($custom_labels['payments']['custom_pay_1']) ? $custom_labels['payments']['custom_pay_1'] : __('lang_v1.custom_payment', ['number' => 1]);
        $payment_types['custom_pay_2'] = !empty($custom_labels['payments']['custom_pay_2']) ? $custom_labels['payments']['custom_pay_2'] : __('lang_v1.custom_payment', ['number' => 2]);
        $payment_types['custom_pay_3'] = !empty($custom_labels['payments']['custom_pay_3']) ? $custom_labels['payments']['custom_pay_3'] : __('lang_v1.custom_payment', ['number' => 3]);
        $payment_types['custom_pay_4'] = !empty($custom_labels['payments']['custom_pay_4']) ? $custom_labels['payments']['custom_pay_4'] : __('lang_v1.custom_payment', ['number' => 4]);
        $payment_types['custom_pay_5'] = !empty($custom_labels['payments']['custom_pay_5']) ? $custom_labels['payments']['custom_pay_5'] : __('lang_v1.custom_payment', ['number' => 5]);
        $payment_types['custom_pay_6'] = !empty($custom_labels['payments']['custom_pay_6']) ? $custom_labels['payments']['custom_pay_6'] : __('lang_v1.custom_payment', ['number' => 6]);
        $payment_types['custom_pay_7'] = !empty($custom_labels['payments']['custom_pay_7']) ? $custom_labels['payments']['custom_pay_7'] : __('lang_v1.custom_payment', ['number' => 7]);
        
        if ($show_advance) {
          $payment_types = ['advance' => __('lang_v1.advance')] + $payment_types;
        }

        return $payment_types;
    }
}