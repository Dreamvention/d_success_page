<?php
//Название конфига
$_['name']              = 'Success Page';
//Статус Frontend редатора
$_['frontend_status']   = '1';
//GET параметр route в админке 
$_['backend_route']     = 'extension/module/d_success_page';
//REGEX для GET параметров route в админке
$_['backend_route_regex'] = 'extension/module/d_success_page/*';
//GET параметр route на Frontend
$_['frontend_route']    = 'checkout/success';
//GET параметр содержащий id страницы в админке
$_['backend_param']     = 'success_page';
//GET параметр содержащий id страницы на Frontend
$_['frontend_param']    = 'success_page';
//Путь для сохранения описания на Frontend
$_['edit_route']        = 'extension/d_visual_designer/designer/saveInformation';
//События необходимые для работы данного route
$_['events']            = array(
    'admin/view/extension/module/d_success_page/after' => 'extension/event/d_success_page/view_extension_module_d_success_page_after',
    'admin/model/extension/module/d_success_page/addInformation/after' => 'extension/event/d_success_page/model_extension_module_d_success_page_addInformation_after'
);