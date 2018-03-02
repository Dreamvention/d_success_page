<?php

class ControllerExtensionEventDSuccessPage extends Controller
{
    private $codename = 'd_visual_designer';
    private $setting_module = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model('extension/'.$this->codename.'/designer');

        $this->load->model('setting/setting');
        $this->setting_module = $this->model_setting_setting->getSetting($this->codename);

        if (!empty($this->setting_module[$this->codename.'_setting'])) {
            $this->setting_module = $this->setting_module[$this->codename.'_setting'];
        } else {
            $this->setting_module = $this->config->get($this->codename.'_setting');
        }
    }

    public function view_extension_module_d_success_page_after(&$route, &$data, &$output)
    {
        $html_dom = new d_simple_html_dom();
        $html_dom->load($output, $lowercase = true, $stripRN = false, $defaultBRText = DEFAULT_BR_TEXT);

        $this->load->model('localisation/language');

        $languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $language) {
            $html_dom->find('textarea[name^="d_success_page_description['.$language['language_id'].'][description]"]', 0)->class .=' d_visual_designer';
        }

        $designer_data = array(
            'config' => 'information',
            'id' => !empty($this->request->get['information_id']) ? $this->request->get['information_id']:false
            );

        $html_dom->find('body', 0)->innertext .= $this->load->controller('extension/'.$this->codename.'/designer', $designer_data);

        $output = (string)$html_dom;
    }

    public function model_extension_module_d_success_page_addInformation_after(&$route, &$data, &$output)
    {
        foreach ($data[0]['vd_content'] as $field_name => $setting_json) {
            $setting = json_decode(html_entity_decode($setting_json, ENT_QUOTES, 'UTF-8'), true);
            $content = $this->{'model_extension_'.$this->codename.'_designer'}->parseSetting($setting);
            // print_r($content);
            $this->{'model_extension_'.$this->codename.'_designer'}->saveContent($content, 'information', $output, rawurldecode($field_name));
        }
    }

    public function model_extension_module_d_success_page_editInformation_after(&$route, &$data, &$output)
    {
        foreach ($data[1]['vd_content'] as $field_name => $setting_json) {
            $setting = json_decode(html_entity_decode($setting_json, ENT_QUOTES, 'UTF-8'), true);
            $content = $this->{'model_extension_'.$this->codename.'_designer'}->parseSetting($setting);
            $this->{'model_extension_'.$this->codename.'_designer'}->saveContent($content, 'information', $data[0], rawurldecode($field_name));
        }
    }
    
            //end of success page ##################################################################################################################################

}