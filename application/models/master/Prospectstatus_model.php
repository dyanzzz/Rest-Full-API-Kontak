<?php
class ProspectStatus_model extends Model {

    function ProspectStatus_model()
    {
        parent::Model();
    }

	function countAllProspectStatus()
	{
		$this->db->where('nkd_del', 0);
		$query = $this->db->get("dtbstprp");
		return $query->num_rows();
	}

	function countAllProspectStatusSearch($prospectstatusInfo)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('ckd_stprp', $prospectstatusInfo['ckd_stprp']);
		$this->db->orderby('ckd_stprp', 'asc');
		$query = $this->db->get('dtbstprp');
		return $query->num_rows();
	}

	function getAllProspectStatus()
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('ckd_stprp', 'asc');
		return $this->db->get('dtbstprp');
	}
	
	function getAllProspectStatusCount()
	{
		$sql = "SELECT *,(SELECT COUNT(*) FROM dtbslmach) AS COUNT FROM dtbstprp ORDER BY nsort ASC";
		return $this->db->query($sql);
	}
 
	function getAllProspectStatusPaging($num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('ckd_stprp', 'asc');
		return $this->db->get('dtbstprp', $num, $offset);
	}

	function getAllProspectStatusPagingSearch($prospectstatusInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('ckd_stprp', $prospectstatusInfo['ckd_stprp']);
		$this->db->orderby('ckd_stprp', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		return $this->db->get('dtbstprp');
	}

	function getAllProspectStatusInfo($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('dtbstprp')->row();
    	}

	function addProspectStatus($prospectstatusInfo)
	{
		$this->db->insert('dtbstprp', $prospectstatusInfo);
		return TRUE;
	}

	function updateProspectStatus($prospectstatusInfo)
	{
		$this->db->where('id', $prospectstatusInfo['id']);
		$this->db->update('dtbstprp', $prospectstatusInfo);
		return TRUE;
	}
	
	function deleteProspectStatus($prospectstatus_id, $prospectstatusInfo)
	{
		// Don't allow the admin to be nkd_del this way				
		if ($prospectstatus_id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('id', $prospectstatus_id);
			$this->db->update('dtbstprp', $prospectstatusInfo);
			return TRUE;
		}
	}
	
	
	
	
	//Android by Dian on 2017-03-08
	function getProspectStatusKd($name){
		if(!empty($name)){
		$this->db->select('ckd_stprp, cnm_stprp');
		$this->db->where('cnm_stprp',$name);
		$kd = $this->db->get('dtbstprp')->row();
		return isset($kd->ckd_stprp)?$kd->ckd_stprp:$name;
		}else return '';
	}

	//Android by Dian on 2017-03-08
	function getProspectStatusName($kd)
	{
		if(!empty($kd)){
		$this->db->select('ckd_stprp,cnm_stprp');
		$this->db->where('ckd_stprp',$kd);
		$nama = $this->db->get('dtbstprp')->row();
		return isset($nama->cnm_stprp)?$nama->cnm_stprp:$kd;
		}else return '';
	}
	
	//Android by Dian on 2017-03-08
	function getAllProspectStatusLabelValue($nview=1)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('nviewtran', $nview);
		$this->db->where('status', '00');
		$this->db->orderby('nsort', 'asc');
		return $this->db->get('dtbstprp');
	}
	
	//Android by Dian on 2017-08-03
	function getDefaultProspectStatus()
	{
		$this->db->select('ckd_stprp');
		$this->db->select('cnm_stprp');
		$this->db->where('nkd_del', 0);
		$this->db->where('ckd_stprp', 'PRA');
		//$this->db->orderby('cnm_exib', 'asc');
		$result = $this->db->get('dtbstprp')->row();
		return $result;
	}
	
}
?>
