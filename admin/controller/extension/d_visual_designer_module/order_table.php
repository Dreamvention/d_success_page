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
        
        return $data;
    }
    
    public function setting($setting)
    {
        $data['text'] = html_entity_decode(htmlspecialchars_decode($setting['text']), ENT_QUOTES, 'UTF-8');

        return $data;
    }

    public function local()
    {
        $data = array();

        $data['entry_text'] = $this->language->get('entry_text');


        return $data;
    }

    public function text($setting){
        $data['text'] = html_entity_decode(htmlspecialchars_decode($setting['text']), ENT_QUOTES, 'UTF-8');
        return $this->model_extension_d_opencart_patch_load->view($this->route, $data);
    }
}
