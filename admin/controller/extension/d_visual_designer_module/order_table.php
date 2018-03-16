<?php
/*
 *  location: admin/controller
 */

class ControllerExtensionDVisualDesignerModuleOrderTable extends Controller
{
    private $codename = 'order_table';
    private $route = 'extension/d_visual_designer_module/order_table';

    public function __construct($registry)
    {
        parent::__construct($registry);
        
        $this->load->language($this->route);
        $this->load->model('extension/d_opencart_patch/load');
    }
    
    public function index($setting)
    {   
        $data['text'] = html_entity_decode(htmlspecialchars_decode($setting['text']), ENT_QUOTES, 'UTF-8');
        $data['order_id'] = $setting["order_id"];
        $data['name'] = $setting['name'];
        $data['email'] = $setting['email'];
        $data['payment_method'] = $setting['payment_method'];
        $data['shipping_method'] = $setting['shipping_method'];
        $data['date_added'] = $setting["date_added"];
        $data['payment_address_1']=$setting['payment_address_1'];
        $data['payment_country']=$setting['payment_country'];
        $data['payment_city']=$setting['payment_city'];
        $data['payment_postcode']=$setting['payment_postcode'];
        $data['shipping_address_1']=$setting['shipping_address_1'];
        $data['shipping_country']=$setting['shipping_country'];
        $data['shipping_city']=$setting['shipping_city'];
        $data['shipping_postcode']=$setting['shipping_postcode'];
        return $data;
    }
    
    public function setting($setting)
    {
        $data['text'] = html_entity_decode(htmlspecialchars_decode($setting['text']), ENT_QUOTES, 'UTF-8');
        $data['order_id'] = $setting["order_id"];
        $data['name'] = $setting['name'];
        $data['email'] = $setting['email'];
        $data['payment_method'] = $setting['payment_method'];
        $data['shipping_method'] = $setting['shipping_method'];
        $data['date_added'] = $setting["date_added"];
        $data['payment_address_1'] = $setting['payment_address_1'];
        $data['payment_country'] = $setting['payment_country'];
        $data['payment_city'] = $setting['payment_city'];
        $data['payment_postcode'] = $setting['payment_postcode'];
        $data['shipping_address_1'] = $setting['shipping_address_1'];
        $data['shipping_country'] = $setting['shipping_country'];
        $data['shipping_city'] = $setting['shipping_city'];
        $data['shipping_postcode'] = $setting['shipping_postcode'];

        return $data;
    }

    public function local()
    {
        $data = array();

        $data['entry_text'] = $this->language->get('entry_text');
        $data['order_id'] = $this->language->get('order_id');
        $data['name'] = $this->language->get('name');
        $data['email'] = $this->language->get('email');
        $data['payment_method'] = $this->language->get('payment_method');
        $data['shipping_method'] = $this->language->get('shipping_method');
        $data['date_added'] = $this->language->get('date_added');
        $data['payment_address_1'] = $this->language->get('payment_address_1');
        $data['payment_country'] = $this->language->get('payment_country');
        $data['payment_city'] = $this->language->get('payment_city');
        $data['payment_postcode'] = $this->language->get('payment_postcode');
        $data['shipping_address_1' ]= $this->language->get('shipping_address_1');
        $data['shipping_country'] = $this->language->get('shipping_country');
        $data['shipping_city' ]= $this->language->get('shipping_city');
        $data['shipping_postcode'] = $this->language->get('shipping_postcode');
        $data['product'] = $this->language->get('product');
        $data['model'] = $this->language->get('model');
        $data['quantity'] = $this->language->get('quantity');
        $data['price'] = $this->language->get('price');
        $data['total'] = $this->language->get('total');

        return $data;
    }

    public function text($setting){
        $data['text'] = html_entity_decode(htmlspecialchars_decode($setting['text']), ENT_QUOTES, 'UTF-8');
        return $this->model_extension_d_opencart_patch_load->view($this->route, $data);
    }
}
