<?php

if(! function_exists(is_pos_layout)){
    function is_pos_layout()
    {
        if((request()->segment(1) == 'pos' && (request()->segment(2) == 'create' || request()->segment(3) == 'edit')) || (request()->segment(1) == 'pos'  && request()->segment(2) == 'retailer'  && (request()->segment(3) == 'create' || request()->segment(4) == 'edit') ) || request()->segment(2) == 'create-book' ){
            return true;
        } else {
            return false;
        }
    }
}