<?php
class ModelExtensionModuleDSuccessPage extends Model {


	public function addInformation($data) {
		foreach ($data['d_success_page_description'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "d_success_page SET language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
        }
        
        $description = $this->db->getLastId();
		return $description;
    }

	public function instalDatabase(){
		$this->db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX."d_success_page (
         `success_id` INT(11) NOT NULL AUTO_INCREMENT,
         `language_id` INT(11) NOT NULL,
         `title` TEXT NOT NULL,
         `description` LONGTEXT NOT NULL,
         PRIMARY KEY (`success_id`)
         )
         COLLATE='utf8_general_ci' ENGINE=MyISAM;");
	}

	public function dropDatabase()
    {
		$this->db->query("DROP TABLE IF EXISTS ".DB_PREFIX."d_success_page");
		$this->db->query("DELETE FROM " . DB_PREFIX . "visual_designer_content WHERE route = 'success_page'");
    }
}