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
        $info_order = $this->session->data['order_information'];
        $info_order['date_added'] = date($this->language->get('date_format_short'), strtotime($info_order['date_added']));
        // echo "<pre>"; print_r($info_order); echo "</pre>";
        $data['text'] = html_entity_decode(htmlspecialchars_decode($setting['text']), ENT_QUOTES, 'UTF-8');
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
        </tbody>
      </table>'), ENT_QUOTES, 'UTF-8');
        return $data;
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
