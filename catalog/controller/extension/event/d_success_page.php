<?php
class ControllerExtensionEventDSuccessPage extends Controller
{
    private $codename = 'd_success_page';

    private $route = 'extension/module/d_success_page';

    public function __construct($registry)
    {
        parent::__construct($registry);
        
        // $this->load->language($this->route);
        // $this->load->model($this->route);
    }

    public function view_checkout_success(&$view, &$data, &$output)
    {       
            $this->load->model('setting/setting');
            $this->load->model('checkout/order');

            if(!isset($data['order_id']) || empty ($data['order_id'])){
                $info['order_id']= 678;
                $info['firstname']= 'Frank';
                $info['lastname']= 'Sinatra';
                $info['email']= 'frank.senatra@gmail.com';
                $info['telephone']= '75413873';
                $info['payment_address_1']= 'montro-street 12b';
                $info['payment_postcode']= '07030';
                $info['payment_city']= 'Hoboken';
                $info['payment_country']= 'United States';
                $info['payment_method']= 'Cash on Delivery';
                $info['shipping_method']= 'Flat rate';
                $info['shipping_address_1']= '5th Avenu 12b';
                $info['shipping_postcode']= '10001';
                $info['shipping_city']= 'New York';
                $info['shipping_country']= 'United States';
                $info['date_added']='22/03/2018';
            }else{
                $info = $this->model_checkout_order->getOrder($data['order_id']);
            }

            $this->session->data['order_information'] = $info;
            $data['settings'] = $setting = $this->model_setting_setting->getSetting($this->codename);
            if($data['settings']['d_success_page_status']==1){
                $data['heading_title'] = '';
                $data['text_message'] = html_entity_decode($data['settings']['d_success_page_description'][(int)$this->config->get('config_language_id')]['description']);
                if(isset($data['text_message'])){
                $designer_data = array(
                'config' => 'success_page',
                'content' => $data['text_message'],
                'field_name' => 'd_success_page_description['.(int)$this->config->get('config_language_id').'][description]',
                'id' => 1
                );
                
                $data['text_message'] = $this->load->controller('extension/d_visual_designer/designer', $designer_data);
                $data['text_message'] = html_entity_decode($data['text_message'], ENT_QUOTES, 'UTF-8');
                }      
            }
    }
}