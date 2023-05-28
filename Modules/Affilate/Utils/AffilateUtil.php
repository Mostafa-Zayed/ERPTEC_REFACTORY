<?php
namespace Modules\Affilate\Utils;

use App\Business;
use App\Category;
use App\Contact;
use App\Address;
use App\Exceptions\PurchaseSellMismatch;
use App\Product;
use App\TaxRate;
use App\Transaction;
use App\Utils\ProductUtil;

use App\Utils\TransactionUtil;

use App\Utils\Util;
use App\Utils\ContactUtil;

use App\VariationLocationDetails;
use App\VariationTemplate;
//use Automattic\Affilate\Client;

use DB;
use Modules\Affilate\Entities\AffilateSyncLog;

use Modules\Affilate\Exceptions\AffilateError;
use Modules\Affilate\Http\traits\ApiTrait;

class AffilateUtil extends Util
{
    /**
     * All Utils instance.
     *
     */
     use ApiTrait; 
    protected $transactionUtil;
    protected $productUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, ProductUtil $productUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->productUtil = $productUtil;
    }


    public function get_api_settings($business_id)
    {
        $business = Business::find($business_id);
        $affilate_api_settings = json_decode($business->affilate_api_settings);
        return $affilate_api_settings;
    }

    private function add_to_skipped_orders($business, $order_id)
    {
        $business = !is_object($business) ? Business::find($business) : $business;
        $skipped_orders = !empty($business->affilate_skipped_orders) ? json_decode($business->affilate_skipped_orders, true) : [];
        if (!in_array($order_id, $skipped_orders)) {
            $skipped_orders[] = $order_id;
        }

        $business->affilate_skipped_orders = json_encode($skipped_orders);
        $business->save();
    }

    private function remove_from_skipped_orders($business, $order_id)
    {
        $business = !is_object($business) ? Business::find($business) : $business;
        $skipped_orders = !empty($business->affilate_skipped_orders) ? json_decode($business->affilate_skipped_orders, true) : [];
        if (in_array($order_id, $skipped_orders)) {
            $skipped_orders = array_diff($skipped_orders, [$order_id]);
        }

        $business->affilate_skipped_orders = json_encode($skipped_orders);
        $business->save();
    }

    /**
     * Creates Automattic\affilate\Client object
     * @param int $business_id
     * @return obj
     */

    public function syncCat($business_id, $data, $type, $new_categories = [])
    {

        //affilate api client object
        $affilate = $this->woo_client($business_id);
        
        if($affilate){
            
          $count = 0;
          
          $request =  $type == 'create' ? 'POST'  : 'PUT' ;
          
        foreach ($data as $chunked_array) {
            $sync_data = [];
            $sync_data[$type] = $chunked_array;
            //Batch update categories
        if(empty($chunked_array['affilate_cat_id'])){
            
              $response = $this->curl_category($business_id,$chunked_array['name'],null ,$chunked_array['parent_id'],$request);   
            
        }else{
            
              $response = $this->curl_update_category($business_id,$chunked_array['name'] ,$chunked_array['affilate_cat_id'],$chunked_array['parent_id'],$request);    
            
        }
    
          //  $response = $affilate->post('products/categories/batch', $sync_data);
           $cat = Category::find($chunked_array['id']);
            //update affilate_cat_id
            if (!empty($response)) {
           
                  if (!empty($response->category_id)) {
                      
                      $cat->affilate_cat_id = $response->category_id;
                      
                      
                      
                   }
                   $cat->save(); 
                    $count++;
               
            }
        }    
            
            
            
            
        }
    
    }

    /**
     * Synchronizes pos categories with affilate categories
     * @param int $business_id
     * @return Void
     */
    public function syncCategories($business_id, $user_id)
    {
        $last_synced = $this->getLastSync($business_id, 'categories', false);

        //Update parent categories
        $query = Category::where('business_id', $business_id)
                        ->where('category_type', 'product')
                        ->where('parent_id', 0);

        //Limit query to last sync
        if (!empty($last_synced)) {
            $query->where('updated_at', '>', $last_synced);
        }

        $categories = $query->get();

        $category_data = [];
        $new_categories = [];
        $created_data = [];
        $updated_data = [];
        foreach ($categories as $category) {
            if (empty($category->affilate_cat_id)) {
                $category_data['create'][] = [
                      'id' => $category->id,
                        'cscart_cat_id' => $category->cscart_cat_id,
                        'parent_id' => $category->parent_id,
                    'name' => $category->name
                ];
                $new_categories[] = $category;
                $created_data[] = $category->name;
            } else {
                $category_data['update'][] = [
                    'id' => $category->id,
                    'cscart_cat_id' => $category->cscart_cat_id,
                      'parent_id' => $category->parent_id,
                    'name' => $category->name
                ];
                $updated_data[] = $category->name;
            }
        }



        if (!empty($category_data['create'])) {
            $this->syncCat($business_id, $category_data['create'], 'create', $new_categories);
        }
        if (!empty($category_data['update'])) {
            $this->syncCat($business_id, $category_data['update'], 'update', $new_categories);
        }
//return json_encode($category_data['update']);
        //Sync child categories
        $query2 = Category::where('business_id', $business_id)
                        ->where('category_type', 'product')
                        ->where('parent_id', '!=', 0);
        //Limit query to last sync
        if (!empty($last_synced)) {
            $query2->where('updated_at', '>', $last_synced);
        }

        $child_categories = $query2->get();

        $cat_id_cscart_id = Category::where('business_id', $business_id)
                                    ->where('parent_id', 0)
                                    ->where('category_type', 'product')
                                    ->pluck('cscart_cat_id', 'id')
                                    ->toArray();

        $category_data = [];
        $new_categories = [];
        foreach ($child_categories as $category) {
          /*  if (empty($cat_id_cscart_id[$category->parent_id])) {
                continue;
            }*/

            if (empty($category->cscart_cat_id)) {
                $category_data['create'][] = [
                    
                       'id' => $category->id,
                    'cscart_cat_id' => $category->cscart_cat_id,
                      'parent_id' => $category->parent_id,
                    'name' => $category->name
                   /* 'name' => $category->name,
                    'parent' => $cat_id_cscart_id[$category->parent_id]*/
                ];
                $new_categories[] = $category;
                $created_data[] = $category->name;
            } else {
                $category_data['update'][] = [
                    
                       'id' => $category->id,
                    'cscart_cat_id' => $category->cscart_cat_id,
                      'parent_id' => $category->parent_id,
                    'name' => $category->name
                  /*  'id' => $category->cscart_cat_id,
                    'name' => $category->name,
                    'parent' => $cat_id_cscart_id[$category->parent_id]*/
                ];
                $updated_data[] = $category->name;
            }
        }

    /*  */ if (!empty($category_data['create'])) {
            $this->syncCat($business_id, $category_data['create'], 'create', $new_categories);
        }
        if (!empty($category_data['update'])) {
            $this->syncCat($business_id, $category_data['update'], 'update', $new_categories);
        }

        //Create log
        if (!empty($created_data)) {
            $this->createSyncLog($business_id, $user_id, 'categories', 'created', $created_data);
        }
        if (!empty($updated_data)) {
            $this->createSyncLog($business_id, $user_id, 'categories', 'updated', $updated_data);
        }/**/
        if (empty($created_data) && empty($updated_data)) {
            $this->createSyncLog($business_id, $user_id, 'categories');
        }
    }

    /**
     * Synchronizes pos products with cscart products
     * @param int $business_id
     * @return Void
     */
    public function syncProducts($business_id, $user_id, $sync_type, $limit = 100, $page = 0)
    {
        //$limit is zero for console command
        if ($page == 0 || $limit == 0) {
            //Sync Categories
            $this->syncCategories($business_id, $user_id);

            //Sync variation attributes
         //   $this->syncVariationAttributes($business_id);
            
            if ($limit > 0) {
                request()->session()->forget('last_product_synced');
            }
        }

        $last_synced = !empty(session('last_product_synced')) ? session('last_product_synced') : $this->getLastSync($business_id, 'all_products', false);
        //store last_synced if page is 0
        if ($page == 0) {
            session(['last_product_synced' => $last_synced]);
        }
        
        $cscart_api_settings = $this->get_api_settings($business_id);
        $created_data = [];
        $updated_data = [];

        $business_location_id = $cscart_api_settings->location_id;
        $offset = $page * $limit;
        $query = Product::where('business_id', $business_id)
                        ->whereIn('type', ['single', 'variable'])
                        ->where('cscart_disable_sync', 0)
                        ->with(['variations', 'category', 'sub_category',
                            'variations.variation_location_details',
                            'variations.product_variation',
                            'variations.product_variation.variation_template']);

        if ($limit > 0) {
            $query->limit($limit)
                ->offset($offset);
        }
                        
        if ($sync_type == 'new') {
            $query->whereNull('cscart_product_id');
        }

        //Select products only from selected location
        if (!empty($business_location_id)) {
            $query->ForLocation($business_location_id);
        }

        $all_products = $query->get();
        $product_data = [];
        $new_products = [];
        $updated_products = [];

        if (count($all_products) == 0) {
            request()->session()->forget('last_product_synced');
        }
        
        foreach ($all_products as $product) {
            //Skip product if last updated is less than last sync
            $last_updated = $product->updated_at;
            //check last stock updated
            $last_stock_updated = $this->getLastStockUpdated($business_location_id, $product->id);

            if (!empty($last_stock_updated)) {
                $last_updated = strtotime($last_stock_updated) > strtotime($last_updated) ?
                        $last_stock_updated : $last_updated;
            }
            if (!empty($product->cscart_product_id) && !empty($last_synced) && strtotime($last_updated) < strtotime($last_synced)) {
                continue;
            }

            //Set common data
            $array = [
                'type' => $product->type == 'single' ? 'single' : 'variable',
                'sku' => $product->sku
            ];

            $manage_stock = false;
            if ($product->enable_stock == 1 && $product->type == 'single') {
                $manage_stock = true;
            }

            //Get details from first variation for single product only
            $first_variation = $product->variations->first();
            if (empty($first_variation)) {
                continue;
            }
            $price = $cscart_api_settings->product_tax_type == 'exc' ? $first_variation->default_sell_price : $first_variation->sell_price_inc_tax;

            if (!empty($cscart_api_settings->default_selling_price_group)) {
                $group_prices = $this->productUtil->getVariationGroupPrice($first_variation->id, $cscart_api_settings->default_selling_price_group, $product->tax_id);

                $price = $cscart_api_settings->product_tax_type == 'exc' ? $group_prices['price_exc_tax'] : $group_prices['price_inc_tax'];
            }

            //Set product stock
            $qty_available = 0;
            if ($manage_stock) {
                $variation_location_details = $first_variation->variation_location_details;
                foreach ($variation_location_details as $vld) {
                    if ($vld->location_id == $business_location_id) {
                        $qty_available = $vld->qty_available;
                    }
                }
            }

            //Set product category
            $product_cat = [];
            if (!empty($product->category)) {
                $product_cat[] = $product->category->cscart_cat_id;
                
            }
            if (!empty($product->sub_category)) {
                $product_cat[] = $product->sub_category->cscart_cat_id;
            }

            //set attributes for variable products
            if ($product->type == 'variable') {
                $variation_attr_data = [];

                foreach ($product->variations as $variation) {
                    if (!empty($variation->product_variation->variation_template->cscart_attr_id)) {
                        $cscart_attr_id = $variation->product_variation->variation_template->cscart_attr_id;
                        $variation_attr_data[$cscart_attr_id][] = $variation->name;
                    }
                }

                foreach ($variation_attr_data as $key => $value) {
                    $array['attributes'][] = [
                        'id' => $key,
                        'variation' => true,
                        'visible'   => true,
                        'options' => $value
                    ];
                }
            }

            $sync_description_as = !empty($cscart_api_settings->sync_description_as) ? $cscart_api_settings->sync_description_as : 'long';
                $array['images'] = '';
                $array['product_id'] = $product->id;
               
                $array['categories'] = '';
                $array['category'] = '';
                $array['description'] = '';
                 $array['name'] = '';
            if (empty($product->cscart_product_id)) {
                $array['tax_class'] = !empty($cscart_api_settings->default_tax_class) ?
                $cscart_api_settings->default_tax_class : 'standard';

                //assign category
                if (in_array('category', $cscart_api_settings->product_fields_for_create)) {
                    if (!empty($product_cat)) {
                        $array['categories'] = $product_cat;
                        $array['category'] = $product->category->cscart_cat_id;
                    }
                }

                if (in_array('weight', $cscart_api_settings->product_fields_for_create)) {
                    $array['weight'] = $this->formatDecimalPoint($product->weight);
                }

                //sync product description
                if (in_array('description', $cscart_api_settings->product_fields_for_create)) {
                    if ($sync_description_as == 'long') {
                        $array['description'] = $product->product_description;
                    } elseif ($sync_description_as == 'short') {
                        $array['short_description'] = $product->product_description;
                    } else {
                        $array['description'] = $product->product_description;
                        $array['short_description'] = $product->product_description;
                    }
                }

                //Set product image url
                //If media id is set use media id else use image src
                if (!empty($product->image) && in_array('image', $cscart_api_settings->product_fields_for_create)) {
                    if ($this->isValidImage($product->image_path)) {
                          $array['images'] = $product->image_url;
                        
                    }
                  
                }

                //assign quantity and price if single product
                if ($product->type == 'single') {
                    $array['manage_stock'] = $manage_stock;
                    if (in_array('quantity', $cscart_api_settings->product_fields_for_create)) {
                        $array['stock_quantity'] = $this->formatDecimalPoint($qty_available, 'quantity');
                    } else {
                        //set manage stock and in_stock if quantity disabled
                        if (isset($cscart_api_settings->manage_stock_for_create)) {
                            if ($cscart_api_settings->manage_stock_for_create == 'true') {
                                $array['manage_stock'] = true;
                            } else if ($cscart_api_settings->manage_stock_for_create == 'false') {
                                $array['manage_stock'] = false;
                            } else {
                                unset($array['manage_stock']);
                            }
                        }
                        if (isset($cscart_api_settings->in_stock_for_create)) {
                            if ($cscart_api_settings->in_stock_for_create == 'true') {
                                $array['in_stock'] = true;
                            } else if ($cscart_api_settings->in_stock_for_create == 'false') {
                                $array['in_stock'] = false;
                            }
                        }
                    }
                    
                    $array['regular_price'] = $this->formatDecimalPoint($price);
                }

                //assign name
                $array['name'] = $product->name;

                $product_data['create'][] = $array;
                $new_products[] = $product;

                $created_data[] = $product->sku;
            } else {
                $array['id'] = $product->cscart_product_id;
                //assign category
                if (in_array('category', $cscart_api_settings->product_fields_for_update)) {
                    if (!empty($product_cat)) {
                        $array['categories'] = $product_cat;
                        $array['category'] = $product->category->cscart_cat_id;
                    }
                }

                if (in_array('weight', $cscart_api_settings->product_fields_for_update)) {
                    $array['weight'] = $this->formatDecimalPoint($product->weight);
                }

                //sync product description
                if (in_array('description', $cscart_api_settings->product_fields_for_update)) {
                    if ($sync_description_as == 'long') {
                        $array['description'] = $product->product_description;
                    } elseif ($sync_description_as == 'short') {
                        $array['short_description'] = $product->product_description;
                    } else {
                        $array['description'] = $product->product_description;
                        $array['short_description'] = $product->product_description;
                    }
                }

                //If media id is set use media id else use image src
                if (!empty($product->image) && in_array('image', $cscart_api_settings->product_fields_for_update)) {
                    if ($this->isValidImage($product->image_path)) {
                        $array['images'] = $product->image_url;
                      
                    }
                }

                if ($product->type == 'single') {
                    //assign quantity
                    $array['manage_stock'] = $manage_stock;
                    if (in_array('quantity', $cscart_api_settings->product_fields_for_update)) {
                        $array['stock_quantity'] = $this->formatDecimalPoint($qty_available, 'quantity');
                    } else {
                        //set manage stock and in_stock if quantity disabled
                        if (isset($cscart_api_settings->manage_stock_for_update)) {
                            if ($cscart_api_settings->manage_stock_for_update == 'true') {
                                $array['manage_stock'] = true;
                            } else if ($cscart_api_settings->manage_stock_for_update == 'false') {
                                $array['manage_stock'] = false;
                            } else {
                                unset($array['manage_stock']);
                            }
                        }
                        if (isset($cscart_api_settings->in_stock_for_update)) {
                            if ($cscart_api_settings->in_stock_for_update == 'true') {
                                $array['in_stock'] = true;
                            } else if ($cscart_api_settings->in_stock_for_update == 'false') {
                                $array['in_stock'] = false;
                            }
                        }
                    }
                    //assign price
                    if (in_array('price', $cscart_api_settings->product_fields_for_update)) {
                        $array['regular_price'] = $this->formatDecimalPoint($price);
                    }
                }

                //assign name
                if (in_array('name', $cscart_api_settings->product_fields_for_update)) {
                    $array['name'] = $product->name;
                }

                $product_data['update'][] = $array;
                $updated_data[] = $product->sku;
                $updated_products[] = $product;
            }
        }

        $create_response = [];
        $update_response = [];

        if (!empty($product_data['create'])) {
            $create_response = $this->syncProd($business_id, $product_data['create'], 'create', $new_products);
        }
        if (!empty($product_data['update'])) {
            $update_response = $this->syncProd($business_id, $product_data['update'], 'update', $updated_products);
        }
        $new_cscart_product_ids = array_merge($create_response, $update_response);

        //Create log
        if (!empty($created_data)) {
            if ($sync_type == 'new') {
                $this->createSyncLog($business_id, $user_id, 'new_products', 'created', $created_data);
            } else {
                $this->createSyncLog($business_id, $user_id, 'all_products', 'created', $created_data);
            }
        }
        if (!empty($updated_data)) {
            $this->createSyncLog($business_id, $user_id, 'all_products', 'updated', $updated_data);
        }

        //Sync variable product variations
    //    $this->syncProductVariations($business_id, $sync_type, $new_cscart_product_ids);

        if (empty($created_data) && empty($updated_data)) {
            if ($sync_type == 'new') {
                $this->createSyncLog($business_id, $user_id, 'new_products');
            } else {
                $this->createSyncLog($business_id, $user_id, 'all_products');
            }
        }

        return $all_products;
    }

    public function syncProd($business_id, $data, $type, $new_products)
    {
        //cscart api client object
        $cscart = $this->woo_client($business_id);

        $new_cscart_product_ids = [];
        $count = 0;  
        
        
      
        if($cscart){
            
         
        foreach ($data as $chunked_array) {
            $sync_data = [];
            $sync_data[$type] = $chunked_array;
       
            if ($type == 'create') {
                
          if($chunked_array['type'] == 'single'){
              
              
           $response = $this->curl_product($business_id,$chunked_array);      
                              
            $pro = Product::find($chunked_array['product_id']);
            //update cscart_cat_id
            if (!empty($response)) {
           
                  if (!empty($response->product_id)) {
                      
                      $pro->cscart_product_id = $response->product_id;
                      
                      
                       $new_cscart_product_ids[] = $response->product_id;
                   }
                   $pro->save(); 
                    $count++;
               
            }
                
          }elseif($chunked_array['type'] == 'variable'){
              
              
              
              
              
          }      
 

             
              
           
            }

            if ($type == 'update') {
               
       if($chunked_array['type'] == 'single'){
              
              $response = $this->curl_update_product($business_id,$chunked_array);         
              
              
                       //update cscart_cat_id
            if (!empty($response)) {
           
                  if (!empty($response->product_id)) {
                      
                 
                      
                      
                       $new_cscart_product_ids[] = $response->product_id;
                   }
               
                    $count++;
               
            }
                  
              
              
          }elseif($chunked_array['type'] == 'variable'){
              
              
              
              
              
          }        
                
    
                
       
 
             
              
           
            
            }
        }    
            
        }
     
       
       
       
   

        return $new_cscart_product_ids;
    }

    /**
     * Synchronizes pos variation templates with cscart product attributes
     * @param int $business_id
     * @return Void
     */
    public function syncVariationAttributes($business_id)
    {
        $cscart = $this->woo_client($business_id);
        
        if($cscart){
            
        $query = VariationTemplate::with('values')->where('business_id', $business_id);

        $attributes = $query->get();
        $data = [];
        $new_attrs = [];
        foreach ($attributes as $attr) {
            if (empty($attr->cscart_attr_id)) {
                
                
            $response = $this->curl_createVariationTemplate($business_id,$attr);  
           if (!empty($response->feature_id)) {
          
                  
              $attr->cscart_attr_id = $response->feature_id;
              $attr->save();  
              
               
              $feature = $this->curl_getVariationTemplate($business_id,$response->feature_id);     
              if($feature->variants){
                  
          
             foreach ($feature->variants as $key => $value) {
             
                   
              foreach ($attr->values as $ke => $valu) {
                   
                     if (strtolower($valu->name) == strtolower($value->variant)) {
                                $valu->cscart_attr_id = $key; 
                                $valu->save();
                            }
                        
               } 
                  
                   
                   
                }         
              
                  
              }
                 
            } 
                $data['create'][] = ['name' => $attr->name];
                $new_attrs[] = $attr;
                
                
            } else {
                
                
                
                
                
                $data['update'][] = [
                    'name' => $attr->name,
                    'id' => $attr->cscart_attr_id
                ];
                
                
            }
        }

   /*     if (!empty($data)) {
            $response = $cscart->post('products/attributes/batch', $data);

            //update cscart_attr_id
            if (!empty($response->create)) {
                foreach ($response->create as $key => $value) {
                    $new_attr = $new_attrs[$key];
                    if ($value->id != 0) {
                        $new_attr->cscart_attr_id = $value->id;
                    } else {
                        $all_attrs = $cscart->get('products/attributes');
                        foreach ($all_attrs as $attr) {
                            if (strtolower($attr->name) == strtolower($new_attr->name)) {
                                $new_attr->cscart_attr_id = $attr->id;
                            }
                        }
                    }
                    $new_attr->save();
                }
            }
        }  */
        }
 
    }

    /**
     * Synchronizes pos products variations with cscart product variations
     * @param int $business_id
     * @param string $sync_type
     * @param array $new_cscart_product_ids (cscart product id of newly created products to sync)
     * @return Void
     */
    public function syncProductVariations($business_id, $sync_type = 'all', $new_cscart_product_ids = [])
    {
        //cscart api client object
        $cscart = $this->woo_client($business_id);
        $cscart_api_settings = $this->get_api_settings($business_id);

        $query = Product::where('business_id', $business_id)
                        ->where('type', 'variable')
                        ->where('cscart_disable_sync', 0)
                        ->with(['variations',
                            'variations.variation_location_details',
                            'variations.product_variation',
                            'variations.product_variation.variation_template']);

        $query->whereIn('cscart_product_id', $new_cscart_product_ids);

        $variable_products = $query->get();
        $business_location_id = $cscart_api_settings->location_id;
        foreach ($variable_products as $product) {

            //Skip product if last updated is less than last sync
            $last_updated = $product->updated_at;

            $last_stock_updated = $this->getLastStockUpdated($business_location_id, $product->id);

            if (!empty($last_stock_updated)) {
                $last_updated = strtotime($last_stock_updated) > strtotime($last_updated) ?
                        $last_stock_updated : $last_updated;
            }
            if (!empty($last_synced) && strtotime($last_updated) < strtotime($last_synced)) {
                continue;
            }

            $variations = $product->variations;

            $variation_data = [];
            $new_variations = [];
            $updated_variations = [];
            foreach ($variations as $variation) {
                $variation_arr = [
                    'sku' => $variation->sub_sku
                ];

                $manage_stock = false;
                if ($product->enable_stock == 1) {
                    $manage_stock = true;
                }

                if (!empty($variation->product_variation->variation_template->cscart_attr_id)) {
                    $variation_arr['attributes'][] = [
                        'id' => $variation->product_variation->variation_template->cscart_attr_id,
                        'option' => $variation->name
                    ];
                }

                $price = $cscart_api_settings->product_tax_type == 'exc' ? $variation->default_sell_price : $variation->sell_price_inc_tax;

                if (!empty($cscart_api_settings->default_selling_price_group)) {
                    $group_prices = $this->productUtil->getVariationGroupPrice($variation->id, $cscart_api_settings->default_selling_price_group, $product->tax_id);

                    $price = $cscart_api_settings->product_tax_type == 'exc' ? $group_prices['price_exc_tax'] : $group_prices['price_inc_tax'];
                }

                //Set product stock
                $qty_available = 0;
                if ($product->enable_stock == 1) {
                    $variation_location_details = $variation->variation_location_details;
                    foreach ($variation_location_details as $vld) {
                        if ($vld->location_id == $business_location_id) {
                            $qty_available = $vld->qty_available;
                        }
                    }
                }

                if (empty($variation->cscart_variation_id)) {
                    $variation_arr['manage_stock'] = $manage_stock;
                    if (in_array('quantity', $cscart_api_settings->product_fields_for_create)) {
                        $variation_arr['stock_quantity'] = $this->formatDecimalPoint($qty_available, 'quantity');
                    } else {
                        //set manage stock and in_stock if quantity disabled
                        if (isset($cscart_api_settings->manage_stock_for_create)) {
                            if ($cscart_api_settings->manage_stock_for_create == 'true') {
                                $variation_arr['manage_stock'] = true;
                            } else if ($cscart_api_settings->manage_stock_for_create == 'false') {
                                $variation_arr['manage_stock'] = false;
                            } else {
                                unset($variation_arr['manage_stock']);
                            }
                        }
                        if (isset($cscart_api_settings->in_stock_for_create)) {
                            if ($cscart_api_settings->in_stock_for_create == 'true') {
                                $variation_arr['in_stock'] = true;
                            } else if ($cscart_api_settings->in_stock_for_create == 'false') {
                                $variation_arr['in_stock'] = false;
                            }
                        }
                    }

                    //Set variation images
                    //If media id is set use media id else use image src
                    if (!empty($variation->media) && count($variation->media) > 0 && in_array('image', $cscart_api_settings->product_fields_for_create)) {
                        $url = $variation->media->first()->display_url;
                        $path = $variation->media->first()->display_path;
                        $cscart_media_id = $variation->media->first()->cscart_media_id;
                        if ($this->isValidImage($path)) {
                            $variation_arr['image'] = !empty($cscart_media_id) ? ['id' => $cscart_media_id] : ['src' => $url];
                        }
                    }

                    $variation_arr['regular_price'] = $this->formatDecimalPoint($price);
                    $new_variations[] = $variation;

                    $variation_data['create'][] = $variation_arr;
                } else {
                    $variation_arr['id'] = $variation->cscart_variation_id;
                    $variation_arr['manage_stock'] = $manage_stock;
                    if (in_array('quantity', $cscart_api_settings->product_fields_for_update)) {
                        $variation_arr['stock_quantity'] = $this->formatDecimalPoint($qty_available, 'quantity');
                    } else {
                        //set manage stock and in_stock if quantity disabled
                        if (isset($cscart_api_settings->manage_stock_for_update)) {
                            if ($cscart_api_settings->manage_stock_for_update == 'true') {
                                $variation_arr['manage_stock'] = true;
                            } else if ($cscart_api_settings->manage_stock_for_update == 'false') {
                                $variation_arr['manage_stock'] = false;
                            } else {
                                unset($variation_arr['manage_stock']);
                            }
                        }
                        if (isset($cscart_api_settings->in_stock_for_update)) {
                            if ($cscart_api_settings->in_stock_for_update == 'true') {
                                $variation_arr['in_stock'] = true;
                            } else if ($cscart_api_settings->in_stock_for_update == 'false') {
                                $variation_arr['in_stock'] = false;
                            }
                        }
                    }

                    //Set variation images
                    //If media id is set use media id else use image src
                    if (!empty($variation->media) && count($variation->media) > 0 && in_array('image', $cscart_api_settings->product_fields_for_update)) {
                        $url = $variation->media->first()->display_url;
                        $path = $variation->media->first()->display_path;
                        $cscart_media_id = $variation->media->first()->cscart_media_id;
                        if ($this->isValidImage($path)) {
                            $variation_arr['image'] = !empty($cscart_media_id) ? ['id' => $cscart_media_id] : ['src' => $url];
                        }
                    }
                    
                    //assign price
                    if (in_array('price', $cscart_api_settings->product_fields_for_update)) {
                        $variation_arr['regular_price'] = $this->formatDecimalPoint($price);
                    }

                    $variation_data['update'][] = $variation_arr;
                    $updated_variations[] = $variation;
                }
            }
           
            if (!empty($variation_data)) {
                $response = $cscart->post('products/' . $product->cscart_product_id . '/variations/batch', $variation_data);

                //update cscart_variation_id
                if (!empty($response->create)) {
                    foreach ($response->create as $key => $value) {
                        $new_variation = $new_variations[$key];
                        if ($value->id != 0) {
                            $new_variation->cscart_variation_id = $value->id;
                            $media = $new_variation->media->first();
                            if (!empty($media)) {
                                $media->cscart_media_id = !empty($value->image->id) ? $value->image->id : null;
                                $media->save();
                            }
                        } else {
                            if (!empty($value->error->data->resource_id)) {
                                $new_variation->cscart_variation_id = $value->error->data->resource_id;
                            }
                        }
                        $new_variation->save();
                    }
                }

                //Update media id if changed from cscart site
                if (!empty($response->update)) {
                    foreach ($response->update as $key => $value) {
                        $updated_variation = $updated_variations[$key];
                        if ($value->id != 0) {
                            $media = $updated_variation->media->first();
                            if (!empty($media)) {
                                $media->cscart_media_id = !empty($value->image->id) ? $value->image->id : null;
                                $media->save();
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Synchronizes Woocommers Orders with POS sales
     * @param int $business_id
     * @param int $user_id
     * @return void
     */
    public function syncOrders($business_id, $user_id)
    {
        $last_synced = $this->getLastSync($business_id, 'orders', false);
        
         $cscart = $this->woo_client($business_id); 
         if($cscart){
               
        $orders = $this->getOrders($business_id);
        
        $cscart_sells = Transaction::where('business_id', $business_id)
                                ->whereNotNull('cscart_order_id')
                                ->with('sell_lines', 'sell_lines.product', 'payment_lines')
                                ->get();

        $new_orders = [];
        $updated_orders = [];

        $cscart_api_settings = $this->get_api_settings($business_id);
        $business = Business::find($business_id);

        $skipped_orders = !empty($business->cscart_skipped_orders) ? json_decode($business->cscart_skipped_orders, true) : [];
        
        $business_data = [
            'id' => $business_id,
            'accounting_method' => $business->accounting_method,
            'location_id' => $cscart_api_settings->location_id,
            'pos_settings' => json_decode($business->pos_settings, true),
            'business' => $business
        ];

        $created_data = [];
        $updated_data = [];
        $create_error_data = [];
        $update_error_data = [];

        foreach ($orders as $order) {
            //Only consider orders modified after last sync
            if ((!empty($last_synced) && date('Y-m-d H:i:s', strtotime(gmdate("Y-m-d\TH:i:s\Z", $order->timestamp))) <= strtotime($last_synced) && !in_array($order->order_id, $skipped_orders)) || in_array($order->status, ['D','F','I','B'])) {
                continue;
            }
            //Search if order already exists
            $sell = $cscart_sells->filter(function ($item) use ($order) {
                return $item->cscart_order_id == $order->order_id;
            })->first();

            $order_number = $order->order_id;
            $sell_status = $this->cscartOrderStatusToPosSellStatus($order->status, $business_id);

            if ($sell_status == 'draft') {
                $order_number .= " (" . __('sale.draft') . ")";
            }
            if (empty($sell)) {
                $created = $this->createNewSaleFromOrder($business_id, $user_id, $order, $business_data);
                $created_data[] = $order_number;

                if ($created !== true) {
                    $create_error_data[] = $created;
                }
            } else {
                $updated = $this->updateSaleFromOrder($business_id, $user_id, $order, $sell, $business_data);
                $updated_data[] = $order_number;

                if ($updated !== true) {
                    $update_error_data[] = $updated;
                }
            }
        }

        //Create log
        if (!empty($created_data)) {
            $this->createSyncLog($business_id, $user_id, 'orders', 'created', $created_data, $create_error_data);
        }
        if (!empty($updated_data)) {
            $this->createSyncLog($business_id, $user_id, 'orders', 'updated', $updated_data, $update_error_data);
        }

        if (empty($created_data) && empty($updated_data)) {
            $error_data = $create_error_data + $update_error_data;
            $this->createSyncLog($business_id, $user_id, 'orders', null, [], $error_data);
        } 
         }
      
    }

    /**
     * Creates new sales in POSfrom cscart order list
     * @param id $business_id
     * @param id $user_id
     * @param obj $order
     * @param array $business_data
     */
    public function createNewSaleFromOrder($business_id, $user_id, $order, $business_data)
    {
        $input = $this->formatOrderToSale($business_id, $user_id, $order);

        if (!empty($input['has_error'])) {
            return $input['has_error'];
        }

        $invoice_total = [
            'total_before_tax' => $order->total,
            'tax' => 0,
        ];

        DB::beginTransaction();

        $transaction = $this->transactionUtil->createSellTransaction($business_id, $input, $invoice_total, $user_id, false);
        $transaction->cscart_order_id = $order->order_id;
        $transaction->save();

        //Create sell lines
        $this->transactionUtil->createOrUpdateSellLines($transaction, $input['products'], $input['location_id'], false, null, ['cscart_line_items_id' => 'line_item_id'], false);

      //  $this->transactionUtil->createOrUpdatePaymentLines($transaction, $input['payment'], $business_id, $user_id, false);

        if ($input['status'] == 'final') {
            //update product stock
            foreach ($input['products'] as $product) {
                if ($product['enable_stock']) {
                    $this->productUtil->decreaseProductQuantity(
                        $product['product_id'],
                        $product['variation_id'],
                        $input['location_id'],
                        $product['quantity']
                    );
                }
            }

            //Update payment status
            $transaction->payment_status = 'due';
            $transaction->save();

            try {
                $this->transactionUtil->mapPurchaseSell($business_data, $transaction->sell_lines, 'purchase');
            } catch (PurchaseSellMismatch $e) {
                DB::rollBack();

                $this->add_to_skipped_orders($business_data['business'], $order->order_id);
                return [
                    'error_type' => 'order_insuficient_product_qty',
                    'order_number' => $order->order_id,
                    'msg' => $e->getMessage()
                ];
            }
        }

        $this->remove_from_skipped_orders($business_data['business'], $order->order_id);

        DB::commit();

        return true;
    }

    /**
     * Formats cscart order response to pos sale request
     * @param id $business_id
     * @param id $user_id
     * @param obj $order
     * @param obj $sell = null
     */
    public function formatOrderToSale($business_id, $user_id, $order, $sell = null)
    {
        $cscart_api_settings = $this->get_api_settings($business_id);

        //Create sell line data
        $product_lines = [];

        //For updating sell lines
        $sell_lines = [];
        if (!empty($sell)) {
            $sell_lines = $sell->sell_lines;
        }

        $order = $this->getSingleOrder($business_id,$order->order_id);  

        foreach ($order->products as $product_line) {
            $product = Product::where('business_id', $business_id)
                            ->where('cscart_product_id', $product_line->product_id)
                            ->with(['variations'])
                            ->first();

            $unit_price = $product_line->original_price / $product_line->amount;
            $line_tax = !empty($product_line->tax_value) ? $product_line->tax_value : 0;
            $unit_line_tax = $line_tax / $product_line->amount;
            $unit_price_inc_tax = $unit_price + $unit_line_tax;
            if (!empty($product)) {

                //Set sale line variation;If single product then first variation
                //else search for cscart_variation_id in all the variations
                if ($product->type == 'single') {
                    $variation = $product->variations->first();
                } else {
                    foreach ($product->variations as $v) {
                        if ($v->cscart_variation_id == $product_line->variation_id) {
                            $variation = $v;
                        }
                    }
                }

                if (empty($variation)) {
                    return ['has_error' =>
                            [
                                'error_type' => 'order_product_not_found',
                                'order_number' => $order->order_id,
                                'product' => $product_line->name . ' SKU:' . $product_line->sku
                            ]
                        ];
                    exit;
                }

                //Check if line tax exists append to sale line data
                $tax_id = null;
             /*   if (!empty($product_line->taxes)) {
                    foreach ($product_line->taxes as $tax) {
                        $pos_tax = TaxRate::where('business_id', $business_id)
                        ->where('cscart_tax_rate_id', $tax->id)
                        ->first();

                        if (!empty($pos_tax)) {
                            $tax_id = $pos_tax->id;
                            break;
                        }
                    }
                }
*/
                $product_data = [
                    'product_id' => $product->id,
                    'unit_price' => $unit_price,
                    'unit_price_inc_tax' => $unit_price_inc_tax,
                    'variation_id' => $variation->id,
                    'quantity' => $product_line->amount,
                    'enable_stock' => $product->enable_stock,
                    'item_tax' => $line_tax,
                    'tax_id' => $tax_id,
                    'line_item_id' => $product_line->item_id
                ];
                
                //append transaction_sell_lines_id if update
                if (!empty($sell_lines)) {
                    foreach ($sell_lines as $sell_line) {
                        if ($sell_line->cscart_line_items_id ==
                            $product_line->item_id) {
                            $product_data['transaction_sell_lines_id'] = $sell_line->id;
                        }
                    }
                }

                $product_lines[] = $product_data;
            } else {
                return ['has_error' =>
                        [
                            'error_type' => 'order_product_not_found',
                            'order_number' => $order->order_id,
                            'product' => $product_line->product . ' SKU:' . $product_line->product_code
                        ]
                    ];
                exit;
            }
        }

        //Get customer details
        $order_customer_id = $order->user_id;

        $customer_details = [];

        //If Customer empty skip get guest customer details from billing address
        if (empty($order_customer_id)) {
            $f_name = !empty($order->firstname) ? $order->firstname : '';
            $l_name = !empty($order->lastname) ? $order->lastname : '';
            $customer_details = [
                    'first_name' => $f_name,
                    'last_name' => $l_name,
                    'email' => !empty($order->email) ? $order->email : null,
                    'name' => $f_name . ' ' . $l_name,
                    'mobile' => $order->phone,
                    'address_line_1' => !empty($order->b_address) ? $order->b_address : null,
                    'address_line_2' => !empty($order->b_address_2) ? $order->b_address_2 : null,
                    'city' => !empty($order->b_city) ? $order->b_city : null,
                    'state' => !empty($order->b_state) ? $order->b_state : null,
                    'country' => !empty($order->b_country) ? $order->b_country : null,
                    'zip_code' => !empty($order->b_zipcode) ? $order->b_zipcode : null
                ];
        } else {
            //cscart api client object
            $cscart = $this->woo_client($business_id);
            
           
            $order_customer =  $this->getUser($business_id,$order_customer_id);

            $customer_details = [
                    'first_name' => $order_customer->firstname,
                    'last_name' => $order_customer->lastname,
                    'email' => $order_customer->email,
                    'name' => $order_customer->firstname . ' ' . $order_customer->lastname,
                    'mobile' => $order->phone,
                    'city' => !empty($order->b_city) ? $order->b_city : null,
                    'state' => !empty($order->b_state) ? $order->b_state : null,
                    'country' => !empty($order->b_country) ? $order->b_country : null,
                    'address_line_1' => !empty($order->b_address) ? $order->b_address : null,
                    'address_line_2' => !empty($order->b_address_2) ? $order->b_address_2 : null,
                    'zip_code' => !empty($order->b_zipcode) ? $order->b_zipcode : null
                ];
        }
        
        if (!empty($customer_details['email'])) {
            $customer = Contact::where('business_id', $business_id)
                            ->where('email', $customer_details['email'])
                            ->OnlyCustomers()
                            ->first();
        }
        
        if (empty($order_customer_id) && empty($customer_details['email'])) {
            $contactUtil = new ContactUtil;
         //   $customer = $contactUtil->getWalkInCustomer($business_id, false);
            
            
            
        }
     
                if($customer_details['country'] == 'EG'){ } 
                    
                 
                    
               
                
                
                
                if($customer_details['country'] == 'ZW'){
                    
                    $customer_details['city'] = 'alexandria';
                    
                }elseif($customer_details['country'] == 'TO'){
                    
                    $customer_details['city'] = 'aswan';
                    
                }elseif($customer_details['country'] == 'AE'){
                    
                    $customer_details['city'] = 'Asyut';
                    
                }elseif($customer_details['country'] == 'TR'){
                    
                    $customer_details['city'] = 'Redsea';
                    
                }elseif($customer_details['country'] == 'EG'){
                    
                    $customer_details['city'] = 'Albuhayra';
                    
                }elseif($customer_details['country'] == 'VU'){
                    
                    $customer_details['city'] = 'Bani Sweif';
                    
                }elseif($customer_details['country'] == 'AF'){
                    
                    $customer_details['city'] = 'Cairo';
                    
                }elseif($customer_details['country'] == 'EH'){
                    
                    $customer_details['city'] = 'Dakahlia';
                    
                }elseif($customer_details['country'] == 'BT'){
                    
                    $customer_details['city'] = 'Damiat';
                    
                }elseif($customer_details['country'] == 'WF'){
                    
                    $customer_details['city'] = 'Fayoum';
                    
                }elseif($customer_details['country'] == 'AX'){
                    
                    $customer_details['city'] = 'Al gharbia';
                    
                }elseif($customer_details['country'] == 'ZR'){
                    
                    $customer_details['city'] = 'Giza';
                    
                }elseif($customer_details['country'] == 'TV'){
                    
                    $customer_details['city'] = 'Ismailia';
                    
                }elseif($customer_details['country'] == 'UY'){
                    
                    $customer_details['city'] = 'south sinai';
                    
                }elseif($customer_details['country'] == 'ZM'){
                    
                    $customer_details['city'] = 'Qalyubia';
                    
                }elseif($customer_details['country'] == 'DZ'){
                    
                    $customer_details['city'] = 'Kafr El Sheikh';
                    
                }elseif($customer_details['country'] == 'AL'){
                    
                    $customer_details['city'] = 'Qena';
                    
                }elseif($customer_details['country'] == 'UG'){
                    
                    $customer_details['city'] = 'Luxor';
                    
                }elseif($customer_details['country'] == 'VE'){
                    
                    $customer_details['city'] = 'Minya';
                    
                }elseif($customer_details['country'] == 'AG'){
                    
                    $customer_details['city'] = 'Al Monufia';
                    
                }elseif($customer_details['country'] == 'UA'){
                    
                    $customer_details['city'] = 'Marsa Matrouh';
                    
                }elseif($customer_details['country'] == 'UZ'){
                    
                    $customer_details['city'] = 'Puerto Said';
                    
                }elseif($customer_details['country'] == 'VI'){
                    
                    $customer_details['city'] = 'Souhag';
                    
                }elseif($customer_details['country'] == 'YE'){
                    
                    $customer_details['city'] = 'Alsharqia';
                    
                }elseif($customer_details['country'] == 'EGSIN'){
                    
                    $customer_details['city'] = 'North Sinai';
                    
                }elseif($customer_details['country'] == 'VN'){
                    
                    $customer_details['city'] = 'Suez';
                    
                }elseif($customer_details['country'] == 'VA'){
                    
                    $customer_details['city'] = 'Alwadi Aljadid';
                    
                }
              $customer_details['country'] = 'Egypt';     
        //If customer not found create new
        if (empty($customer)) {
            $ref_count = $this->transactionUtil->setAndGetReferenceCount('contacts', $business_id);
            $contact_id = $this->transactionUtil->generateReferenceNumber('contacts', $ref_count, $business_id);
               
               
          
                
                
                
            $customer_data = [
                'business_id' => $business_id,
                'type' => 'customer',
                'first_name' => $customer_details['first_name'],
                'last_name' => $customer_details['last_name'],
                'name' => $customer_details['name'],
                'email' => $customer_details['email'],
                'contact_id' => $contact_id,
                'mobile' => $customer_details['mobile'],
                'city' => $customer_details['state'],
                'state' => $customer_details['state'],
                'country' => $customer_details['country'],
                'created_by' => $user_id,
                'address_line_1' => !empty($customer_details['address_line_1']) ?  $customer_details['address_line_1']  : $order->shipping->address_1  ,
                'address_line_2' => $customer_details['address_line_2'],
                'zip_code' => $customer_details['zip_code']
            ];

            //if name is blank make email address as name
            if (empty(trim($customer_data['name']))) {
                $customer_data['first_name'] = $customer_details['email'];
                $customer_data['name'] = $customer_details['email'];
            }
            
           
            
            
            
            $customer = Contact::create($customer_data);
            
                 $address =  new Address  ; 
                 $address->contact_id = $customer->id ;
                 $address->business_id = $business_id ;
                 $address->country = $customer->country ;
                 $address->city = $customer->city ;
                 $address->state = $customer->state ;
                 $address->address = $customer_details['address_line_1'] ;
                 $address->name = 'عنوان1 ' ;
                 $address->phone = $customer->landline ;
                 $address->mobile = $customer->mobile ;
                 $address->save() ;  
        }
        if(empty($address)){
            
            
          $address =   Address::where('contact_id',$customer->id)->where('business_id',$business_id)->first();
          if(empty($address)){
              
              
                 $address =  new Address  ; 
                 $address->contact_id = $customer->id ;
                 $address->business_id = $business_id ;
                 $address->country = $customer->country ;
                 $address->city = $customer->city ;
                 $address->state = $customer->state ;
                 $address->address = $customer_details['address_line_1'] ;
                 $address->name = 'عنوان1 ' ;
                 $address->phone = $customer->landline ;
                 $address->mobile = $customer->mobile ;
                 $address->save() ;    
              
              
          }else{
              
             
                
                 $address->country = $customer_details['country'] ;
                 $address->city = $customer_details['state'];
                 $address->state = $customer_details['state'] ;
                 $address->address = $customer_details['address_line_1'] ;
              
                 $address->mobile = $customer_details['mobile'] ;
                 $address->save() ;    
              
              
          }
            
            
        }
     

        $sell_status = $this->cscartOrderStatusToPosSellStatus($order->status, $business_id);
        $shipping_status = $this->cscartOrderStatusToPosShippingStatus($order->status, $business_id);
        $shipping_address = [];
        if (!empty($order->firstname)) {
            $shipping_address[] = $order->firstname . ' ' . $order->lastname;
        }
        if (!empty($order->company)) {
            $shipping_address[] = $order->company;
        }
        if (!empty($order->b_address)) {
            $shipping_address[] = $order->b_address;
        }
        if (!empty($order->b_address_2)) {
            $shipping_address[] = $order->b_address_2;
        }
        if (!empty($order->b_city)) {
            $shipping_address[] = $order->b_city;
        }
        if (!empty($order->sb_state)) {
            $shipping_address[] = $order->b_state;
        }
        if (!empty($order->b_country)) {
            $shipping_address[] = $order->b_country;
        }
        if (!empty($order->b_zipcode)) {
            $shipping_address[] = $order->b_zipcode;
        }
        $addresses['shipping_address'] = [
            'shipping_name' => $order->firstname . ' ' . $order->lastname,
            'company' => $order->company,
            'shipping_address_line_1' => $order->b_address,
            'shipping_address_line_2' => $order->b_address_2,
            'shipping_city' => $order->b_city,
            'shipping_state' => $order->b_state,
            'shipping_country' => $order->b_country,
            'shipping_zip_code' => $order->b_zipcode
        ];
        $addresses['billing_address'] = [
            'billing_name' => $order->firstname . ' ' . $order->lastname,
            'company' => $order->company,
            'billing_address_line_1' => $order->b_address,
            'billing_address_line_2' => $order->b_address_2,
            'billing_city' => $order->b_city,
            'billing_state' => $order->b_state,
            'billing_country' => $order->b_country,
            'billing_zip_code' => $order->b_zipcode
        ];

        $shipping_lines_array = [];
        if (!empty($order->shipping)) {
          foreach ($order->shipping as $shipping_lines) { 
                $shipping_lines_array[] = $shipping_lines->shipping;
           }
        }
  // \Log::info(json_encode($customer));
        $new_sell_data = [
            'business_id' => $business_id,
            'location_id' => $cscart_api_settings->location_id,
            'contact_id' => $customer->id,
            'discount_type' => 'fixed',
            'discount_amount' => $order->subtotal_discount,
          
            'final_total' => $order->total,
            'created_by' => $user_id,
            'address_id' => !empty($address) ? $address->id : null,
            'status' => $sell_status == 'quotation' ? 'draft' : $sell_status,
            'is_quotation' => $sell_status == 'quotation' ? 1 : 0,
            'sub_status' => $sell_status == 'quotation' ? 'quotation' : null,
            'payment_status' => 'paid',
            'additional_notes' => $order->notes,
            'transaction_date' => date('Y-m-d H:i:s', strtotime(gmdate("Y-m-d\TH:i:s\Z", $order->timestamp))),
            'customer_group_id' => $customer->customer_group_id,
            'tax_rate_id' => null,
            'sale_note' => null,
            'commission_agent' => null,
            'invoice_no' => $order->order_id,
            'order_addresses' => json_encode($addresses),
            'shipping_charges' => !empty($order->shipping_cost) ? $order->shipping_cost : 0,
            'shipping_details' => !empty($shipping_lines_array) ? implode(', ', $shipping_lines_array) : '',
            'shipping_status' => $shipping_status,
            'shipping_address' => implode(', ', $shipping_address)
        ];

        $payment = [
            'amount' => $order->total,
            'method' => 'cash',
            'card_transaction_number' => '',
            'card_number' => '',
            'card_type' => '',
            'card_holder_name' => '',
            'card_month' => '',
            'card_security' => '',
            'cheque_number' =>'',
            'bank_account_number' => '',
            'note' => $order->payment_method->instructions,
            'paid_on' => date('Y-m-d H:i:s', strtotime(gmdate("Y-m-d\TH:i:s\Z", $order->timestamp)))
        ];

        if (!empty($sell) && count($sell->payment_lines) > 0) {
            $payment['payment_id'] = $sell->payment_lines->first()->id;
        }

        $new_sell_data['products'] = $product_lines;
        $new_sell_data['payment'] = [$payment];

        return $new_sell_data;
    }

    /**
     * Updates existing sale
     * @param id $business_id
     * @param id $user_id
     * @param obj $order
     * @param obj $sell
     * @param array $business_data
     */
    public function updateSaleFromOrder($business_id, $user_id, $order, $sell, $business_data)
    {
        $input = $this->formatOrderToSale($business_id, $user_id, $order, $sell);

        if (!empty($input['has_error'])) {
            return $input['has_error'];
        }

        $invoice_total = [
            'total_before_tax' => $order->total,
            'tax' => 0,
        ];

        $status_before = $sell->status;

        DB::beginTransaction();
        $transaction = $this->transactionUtil->updateSellTransaction($sell, $business_id, $input, $invoice_total, $user_id, false, false);

        //Update Sell lines
        $deleted_lines = $this->transactionUtil->createOrUpdateSellLines($transaction, $input['products'], $input['location_id'], true, $status_before, [], false);

        $this->transactionUtil->createOrUpdatePaymentLines($transaction, $input['payment'], null, null, false);

        //Update payment status
        $transaction->payment_status = 'due';
        $transaction->save();

        //Update product stock
        $this->productUtil->adjustProductStockForInvoice($status_before, $transaction, $input, false);

        try {
            $this->transactionUtil->adjustMappingPurchaseSell($status_before, $transaction, $business_data, $deleted_lines);
        } catch (PurchaseSellMismatch $e) {
            DB::rollBack();
            return [
                'error_type' => 'order_insuficient_product_qty',
                'order_number' => $order->order_id,
                'msg' => $e->getMessage()
            ];
        }

        DB::commit();

        return true;
    }

    /**
     * Creates sync log in the database
     * @param id $business_id
     * @param id $user_id
     * @param string $type
     * @param array $errors = null
     */
    public function createSyncLog($business_id, $user_id, $type, $operation = null, $data = [], $errors = null)
    {
        CscartSyncLog::create([
            'business_id' => $business_id,
            'sync_type' => $type,
            'created_by' => $user_id,
            'operation_type' => $operation,
            'data' => !empty($data) ? json_encode($data) : null,
            'details' => !empty($errors) ? json_encode($errors) : null
        ]);
    }

    /**
     * Retrives last synced date from the database
     * @param id $business_id
     * @param string $type
     * @param bool $for_humans = true
     */
    public function getLastSync($business_id, $type, $for_humans = true)
    {
        $last_sync = CscartSyncLog::where('business_id', $business_id)
                            ->where('sync_type', $type)
                            ->max('created_at');

        //If last reset present make last sync to null
        $last_reset = CscartSyncLog::where('business_id', $business_id)
                            ->where('sync_type', $type)
                            ->where('operation_type', 'reset')
                            ->max('created_at');
        if (!empty($last_reset) && !empty($last_sync) && $last_reset >= $last_sync) {
            $last_sync = null;
        }

        if (!empty($last_sync) && $for_humans) {
            $last_sync = \Carbon::createFromFormat('Y-m-d H:i:s', $last_sync)->diffForHumans();
        }
        return $last_sync;
    }

    public function cscartOrderStatusToPosSellStatus($status, $business_id)
    {
        $default_status_array = [
            	'F' => 'draft',
        			'D' => 'draft',
        			'B' => 'draft',
        			'I' => 'draft',
        			'P' => 'final',
        			'H' => 'final',
        			'A' => 'final',
        			'C' => 'final',
        			'G' => 'final',
        			'E' =>'final',
        			'J' => 'final',
        			'O' => 'final',
        			'Y' => 'final'
        ];

        $api_settings = $this->get_api_settings($business_id);

        $status_settings = $api_settings->order_statuses ?? null;

        $sale_status = !empty($status_settings) ? $status_settings->$status : null;
        $sale_status = empty($sale_status) && array_key_exists($status, $default_status_array) ? $default_status_array[$status] : $sale_status;
        $sale_status = empty($sale_status) ? 'final' : $sale_status;


        return $sale_status;
    }

    public function cscartOrderStatusToPosShippingStatus($status, $business_id)
    {
        $api_settings = $this->get_api_settings($business_id);

        $status_settings = $api_settings->shipping_statuses ?? null;

        $shipping_status = !empty($status_settings) ? $status_settings->$status : 'pending';

        return $shipping_status;
    }

    /**
     * Splits response to list of 100 and merges all
     * @param int $business_id
     * @param string $endpoint
     * @param array $params = []
     *
     * @return array
     */

    /**
     * Retrives all tax rates from cscart api
     * @param id $business_id
     *
     * @param obj $tax_rates
     */
    public function getTaxRates($business_id)
    {
        $tax_rates = '';
        return $tax_rates;
    }

    public function getLastStockUpdated($location_id, $product_id)
    {
        $last_updated = VariationLocationDetails::where('location_id', $location_id)
                                    ->where('product_id', $product_id)
                                    ->max('updated_at');

        return $last_updated;
    }

    private function formatDecimalPoint($number, $type = 'currency') {

        $precision = 4;
        $currency_precision = config('constants.currency_precision');
        $quantity_precision = config('constants.quantity_precision');

        if ($type == 'currency' && !empty($currency_precision)) {
            $precision = $currency_precision;
        }
        if ($type == 'quantity' && !empty($quantity_precision)) {
            $precision = $quantity_precision;
        }

        return number_format((float) $number, $precision, ".", "");
    }

    public function isValidImage($path)
    {
        $valid_extenstions = ['jpg', 'jpeg', 'png', 'gif'];

        return !empty($path) && file_exists($path) && in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), $valid_extenstions);
    }
}
