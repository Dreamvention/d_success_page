<?php
/*
 *  location: catalog/controller
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
        $this->load->model('checkout/order');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        if($this->request->get['route']=='checkout/success'){
            
            $info_order = $this->session->data['order_information'];
            $info_order['date_added'] = date($this->language->get('date_format_short'), strtotime($info_order['date_added']));
            $products = $this->getOrderProducts($info_order['order_id']);

            foreach ($products as $product) {
            $product_info = $this->model_catalog_product->getProduct($product['product_id']);
				$data['order_products'][] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
                    'model'      => $product['model'],
                    'image'      => isset($product_info['image']) && !empty($product_info['image']) ? $this->model_tool_image->resize($product_info['image'], 100, 100) : '',
                    'option'     => $this->getOrderOptions($info_order['order_id'], $product['order_product_id']),
                    'href'       => $this->url->link('product/product', 'product_id=' . $product['product_id']),
					'quantity'   => $product['quantity'],
					'price'      => $this->currency->format($product['price'] , $this->session->data['currency']),
					'total'      => $this->currency->format($product['price'] , $this->session->data['currency']),
					'reward'     => $product['reward']
				);
            }

            $data['order_id'] = $info_order["order_id"];
            $data['name'] = $setting['name'] ? $info_order["firstname"].' '.$info_order["lastname"]  : '';
            $data['email'] = $setting['email'] ? $info_order["email"] : '';
            $data['payment_method'] = $setting['payment_method'] ? $info_order["payment_method"] : '';
            $data['shipping_method'] = $setting['shipping_method'] ? $info_order["shipping_method"] : '';
            $data['date_added'] = $setting['date_added'] ?  $info_order["date_added"] : '';
            $data['payment_address_1'] = $setting['payment_address_1'] ?  $info_order['payment_address_1'] : '';
            $data['payment_country'] = $setting['payment_country'] ?  $info_order['payment_country'] : '';
            $data['payment_city'] = $setting['payment_city'] ?  $info_order['payment_city'] : '';
            $data['payment_postcode'] = $setting['payment_postcode'] ?  $info_order['payment_postcode'] : '';
            $data['shipping_address_1'] = $setting['shipping_address_1'] ?  $info_order['shipping_address_1'] : '';
            $data['shipping_country'] = $setting['shipping_country'] ?  $info_order['shipping_country'] : '';
            $data['shipping_city'] = $setting['shipping_city'] ?  $info_order['shipping_city'] : '';
            $data['shipping_postcode'] = $setting['shipping_postcode'] ?  $info_order['shipping_postcode'] : '';

        }
        
        $data['text'] = html_entity_decode(htmlspecialchars_decode($setting['text']), ENT_QUOTES, 'UTF-8');
        return $data;
    }

    public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		
		return $query->rows;
    }
    
    public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");
		
		return $query->rows;
	}
    
    public function setting($setting)
    {
        $data['text'] = html_entity_decode(htmlspecialchars_decode($setting['text']), ENT_QUOTES, 'UTF-8');
        
        return $data;
    }

    public function local($permission)
    {
        $data = array();
        if($permission){
            $data['entry_text'] = $this->language->get('entry_text');
        }

        $data['name'] = $this->language->get('name');
        $data['email'] = $this->language->get('email');
        $data['order_id'] = $this->language->get('order_id');
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
        $data['order_details'] = $this->language->get('order_details');
        $data['payment_details'] = $this->language->get('payment_details');
        $data['shipping_details'] = $this->language->get('shipping_details');
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
