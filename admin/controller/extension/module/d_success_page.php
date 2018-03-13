<?php
/*
 *	location: admin/controller
 */

class ControllerExtensionModuleDSuccessPage extends Controller{
    private $codename = 'd_success_page';
    private $route = 'extension/module/d_success_page';
    private $extension = '';
    private $config_file = '';
    private $store_id = 0;
    
    private $error = array();

    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->load->language($this->route);
        $this->load->model($this->route);
        $this->d_shopunity = (file_exists(DIR_SYSTEM.'library/d_shopunity/extension/d_shopunity.json'));
        $this->d_opencart_patch = (file_exists(DIR_SYSTEM.'library/d_shopunity/extension/d_opencart_patch.json'));
        $this->d_twig_manager = (file_exists(DIR_SYSTEM.'library/d_shopunity/extension/d_twig_manager.json'));
        $this->d_event_manager = (file_exists(DIR_SYSTEM.'library/d_shopunity/extension/d_event_manager.json'));
        $this->extension = json_decode(file_get_contents(DIR_SYSTEM.'library/d_shopunity/extension/d_success_page.json'), true);
        
    }

    public function index()
    {
        if($this->d_twig_manager){
            $this->load->model('extension/module/d_twig_manager');
            $this->session->data['success'] = $this->language->get('success_twig_compatible');
            $this->model_extension_module_d_twig_manager->installCompatibility();
        }

        if ($this->d_event_manager) {
            $this->load->model('extension/module/d_event_manager');
            $this->model_extension_module_d_event_manager->installCompatibility();
        }

        if($this->d_shopunity){
            $this->load->model('extension/d_shopunity/mbooth');
            $this->model_extension_d_shopunity_mbooth->validateDependencies($this->codename);
        }

        $this->load->model('setting/setting');
        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model('extension/d_opencart_patch/store');
        $this->load->model('extension/d_opencart_patch/setting');
        $this->load->model('extension/d_opencart_patch/load');
        $this->load->model('extension/d_opencart_patch/user');

        $this->document->addScript('view/javascript/d_bootstrap_switch/js/bootstrap-switch.min.js');
        $this->document->addStyle('view/javascript/d_bootstrap_switch/css/bootstrap-switch.css');
        $this->document->addStyle('view/javascript/d_success_page/d_design.css');

        $data=array();
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_extension_module_d_success_page->addInformation($this->request->post);
            
            if (VERSION >= '3.0.0.0') {
                $dsp_post_array = array();
                
                if ($this->request->post[$this->codename.'_status'] == 0) {
                    $dsp_post_array['module_'.$this->codename.'_status'] = 0;
                } elseif ($this->request->post[$this->codename.'_status'] == 1) {
                    $dsp_post_array['module_'.$this->codename.'_status'] = 1;
                }
                
                $this->model_setting_setting->editSetting('module_'.$this->codename, $dsp_post_array);
            }
            
            $this->model_setting_setting->editSetting($this->codename, $this->request->post);
            // print_r($this->request->post);exit;
            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->model_extension_d_opencart_patch_url->getExtensionLink('module'));
        }

        if ($this->model_setting_setting->getSetting($this->codename)) {
            $data['setting'] = $this->model_setting_setting->getSetting($this->codename);
        }else{
             $data['setting']=array();
        }

        if (isset($this->request->post[$this->codename.'_status'])) {
            $data[$this->codename.'_status'] = $this->request->post[$this->codename.'_status'];
        }else if (!isset($data['setting'][$this->codename.'_status'])) {
             $data[$this->codename.'_status']=0;
        } else {
            $data[$this->codename.'_status'] = $data['setting'][$this->codename.'_status'];
        }

        if (isset($this->request->post['success_page'])) {
			$data['d_success_page_description'] = $this->request->post['d_success_page_description'];
		} else if(isset($data['setting']['d_success_page_description'])){
			$data['d_success_page_description'] = $data['setting']['d_success_page_description'];
		}else{
            $data['d_success_page_description']='';
        }

        $url_params = array();
        
        if (isset($this->response->get['store_id'])) {
            $url_params['store_id'] = $this->store_id;
        }
        
        $url = ((!empty($url_params)) ? '&' : '') . http_build_query($url_params);

        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->model_extension_d_opencart_patch_url->link('common/home')
            );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'),
            'href' => $this->model_extension_d_opencart_patch_url->link('marketplace/extension', $url)
        );
        
        $this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();


        // Notification
        foreach ($this->error as $key => $error) {
            $data['error'][$key] = $error;
        }
        
        // Heading
        $data['heading_title'] = $this->language->get('heading_title_main');
        $data['text_edit'] = $this->language->get('text_edit');
        
        // Variable
        $data['codename'] = $this->codename;
        $data['route'] = $this->route;
        $data['store_id'] = $this->store_id;
        $data['stores'] = $this->model_extension_d_opencart_patch_store->getAllStores();        
        $data['extension'] = $this->extension;
        $data['version'] = $this->extension['version'];

        //action
        $data['module_link'] = $this->model_extension_d_opencart_patch_url->link('extension/module/'.$this->codename);
        
        $data['action'] = $this->model_extension_d_opencart_patch_url->link($this->route);
        
        $data['cancel'] =$this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->model_extension_d_opencart_patch_load->view($this->route, $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', $this->route)) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (isset($this->request->post['config'])) {
            return false;
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function install()
    {
        if ($this->d_shopunity) {
            $this->load->model('extension/d_shopunity/mbooth');
            $this->model_extension_d_shopunity_mbooth->installDependencies($this->codename);
        }
        if ($this->d_event_manager) {
            $this->load->model('extension/module/d_event_manager');
            $this->model_extension_module_d_event_manager->addEvent($this->codename, 'catalog/view/common/success/before', 'extension/event/d_success_page/view_checkout_success');
            $this->model_extension_module_d_event_manager->addEvent($this->codename, 'admin/view/extension/module/d_success_page/after', 'extension/event/d_success_page/view_extension_module_d_success_page_after');
            $this->model_extension_module_d_event_manager->addEvent($this->codename, 'admin/model/extension/module/d_success_page/addInformation/after', 'extension/event/d_success_page/model_extension_module_d_success_page_addInformation_after');
        }
        $this->model_extension_module_d_success_page->instalDatabase();
        $this->load->model('extension/d_opencart_patch/user');
        $this->load->model('extension/d_opencart_patch/modification');
        $this->load->model('user/user_group');
        $this->model_extension_d_opencart_patch_modification->setModification('d_success_page.xml', 1);
        $this->model_extension_d_opencart_patch_modification->refreshCache();
        $this->model_user_user_group->addPermission($this->model_extension_d_opencart_patch_user->getGroupId(), 'access', 'extension/'.$this->codename);
        $this->model_user_user_group->addPermission($this->model_extension_d_opencart_patch_user->getGroupId(), 'modify', 'extension/'.$this->codename);

    }

    public function uninstall()
    {
        if (file_exists(DIR_APPLICATION . 'model/extension/module/d_event_manager.php')) {
            $this->load->model('extension/module/d_event_manager');            
            $this->model_extension_module_d_event_manager->deleteEvent($this->codename);
        }
        $this->load->model('extension/d_opencart_patch/modification');
        $this->model_extension_d_opencart_patch_modification->setModification('d_success_page.xml', 0);
        $this->model_extension_d_opencart_patch_modification->refreshCache();
        $this->model_extension_module_d_success_page->dropDatabase();
    }
}