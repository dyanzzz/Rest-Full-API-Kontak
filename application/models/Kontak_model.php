<?php
	class Kontak_model extends CI_Model
	{
		public function getKontak($id=null)
		{
			if($id == ''){
				return $this->db->get('telepon')->result();
			}else{
				$this->db->where("id", $id);
				return $this->db->get('telepon')->result();
				//return $this->db->get('telepon', ['id'=>$id])->result_array();
			}
		}

		public function deleteKontak($id){
			$this->db->where('id',$id);
			$delete = $this->db->delete('telepon');
			return $delete;
			
			
		}

		public function createKontak($data){
			$this->db->insert("telepon", $data);
			return $this->db->affected_rows();
		}

		public function updateKontak($data, $id){
			$this->db->update('telepon', $data, ['id'=>$id]);
			return $this->db->affected_rows();
		}
	}
?>