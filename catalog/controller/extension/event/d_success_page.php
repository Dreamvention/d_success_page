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
            $data['settings'] = $setting = $this->model_setting_setting->getSetting($this->codename);
            if($data['settings']['d_success_page_status']==1){
                $data['heading_title'] = $data['settings']['d_success_page_description'][(int)$this->config->get('config_language_id')]['title'];
                $data['text_message'] = html_entity_decode($data['settings']['d_success_page_description'][(int)$this->config->get('config_language_id')]['description']);
                if(isset($data['text_message'])){
                $designer_data = array(
                'config' => 'success_page',
                'content' => $data['text_message'],
                'field_name' => 'd_success_page_description['.(int)$this->config->get('config_language_id').'][description]',
                'id' => false
                );
                
                $data['text_message'] = $this->load->controller('extension/d_visual_designer/designer', $designer_data);
                $data['text_message'] = html_entity_decode($data['text_message'], ENT_QUOTES, 'UTF-8');
                }      
            }
    }
}