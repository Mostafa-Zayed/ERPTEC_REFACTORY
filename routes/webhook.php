<?php 



// Route::get('/whatsapp/{business_id}','WhatsappController@test')->namesapce('Modules\Whatsapp\Htpp\Controllers')->name('whatsapp');

Route::namespace('Modules\Whatsapp\Http\Controllers')->group(function(){
    
    Route::get('whatsapp/{business_id}','WhatsappController@verifyWebhook')->name('whatsapp.verify');
    Route::post('/whatsapp/{business_id}','WhatsappController@webhookData')->name('whatsapp.webhook-data');
    
});
// get('/whatsapp/{business_id}','WhatsappController@test')->namesapce('Modules\Whatsapp');