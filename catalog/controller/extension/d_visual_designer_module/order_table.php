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
            
            $data['table']  = html_entity_decode(htmlspecialchars_decode('<table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-left" >Order Details</td>
                <td class="text-left" >Payment Details</td>
                <td class="text-left" >Shipping Details</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-left" style="width: 50%;">
                <b>Order ID: </b> '.$info_order["order_id"].'<br />
                <b>First name: </b>'.$info_order["firstname"].'<br />
                <b>Last name: </b>'.$info_order["lastname"].'<br />
                <b>Email : </b>'.$info_order["email"].'<br />
                <b>Date Added: </b>'.$info_order["date_added"].'<br />
                </td>
                <td class="text-left">
                    <b>Payment Method: </b>'.$info_order["payment_method"].'<br />
                    <b>Payment address: </b> #'.$info_order["payment_address_1"].'<br />
                    <b>Country: </b> '.$info_order["payment_country"].'<br />
                    <b>City: </b> '.$info_order["payment_city"].'<br />
                    <b>Post code</b> '.$info_order["payment_postcode"].'<br />
                </td>
                <td class="text-left">
                    <b>Shipping Method: </b>'.$info_order["shipping_method"].'<br />
                    <b>Shipping address: </b> '.$info_order["shipping_address_1"].'<br />
                    <b>Country: </b> '.$info_order["shipping_country"].'<br />
                    <b>City: </b> '.$info_order["shipping_city"].'<br />
                    <b>Post code</b> '.$info_order["shipping_postcode"].'<br />
                </td>
            </tr>
            </tbody>'), ENT_QUOTES, 'UTF-8');
            $product_table='</table>
                <table class="table table-bordered">
                        <thead>
                            <tr>
                            <td class="text-left">Product</td>
                            <td class="text-left">Model</td>
                            <td class="text-right">Quantity</td>
                            <td class="text-right">Price</td>
                            <td class="text-right">Total</td>
                            </tr>
                        </thead>
                        <tbody id="cart">';
                foreach ($data['order_products'] as $key => $product) {
                    $product_table .='<tr><td><a href="'.$product['href'].'">'.'<img src="'.$product['image'].'"/> '.$product['name'].'</a> ';
                    // $product_table .='<img src="'.$product['image'].'"/></a>  ';
                    if(!empty($product['option'])){
                        foreach ($product['option'] as $key => $option) {
                            $product_table .='<small>'.$option['name'].' : '.$option['value'].'</small><br />';
                        }
                    }
                    $product_table .='</td><td>'.$product['model'].'</td>
                                    <td>'.$product['quantity'].'</td>
                                    <td>'.$product['price'].'</td>
                                    <td>'.$product['total'].'</td>
                                    </tr>';
                }
                $product_table .='<tr>                     
                            </tr>
                        </tbody>
                        </table>';
                $data['table'] .= $product_table;
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

        return $data;
    }

    public function text($setting){
        
        $data['text'] = html_entity_decode(htmlspecialchars_decode($setting['text']), ENT_QUOTES, 'UTF-8');
        return $this->model_extension_d_opencart_patch_load->view($this->route, $data);
    }
}
