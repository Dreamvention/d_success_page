<?php
class ModelExtensionModuleDSuccessPage extends Model {


	public function addInformation($data) {
		foreach ($data['d_success_page_description'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "d_success_page SET language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
        }
        
        $information_id = $this->db->getLastId();
		return $information_id;
    }

    public function editInformation($information_id, $data) {
		
		// $this->db->query("DELETE FROM " . DB_PREFIX . "d_success_page_description WHERE information_id = '" . (int)$information_id . "'");

		foreach ($data['d_success_page_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "d_success_page SET language_id = '" . (int)$language_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
        }
        
		$this->cache->delete('information');
	}
}