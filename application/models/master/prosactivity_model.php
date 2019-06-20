<?php
class Prosactivity_model extends Model {

    function Prosactivity_model()
    {
        parent::Model();
    }

	function getAllProsactivityList($ProsactivityInfo)
	{
		if($ProsactivityInfo['pacckdcoy'] != null && $ProsactivityInfo['pacckdcoy'] != "")
		$this->db->where('pacckdcoy', $ProsactivityInfo);
		return $this->db->get('dtbprosactivity')->row();
	}
	
	function countAllProsactivitySearch($ProsactivityInfo)
	{
		if($ProsactivityInfo['pacckdcoy'] != "") {
		
			$this->db->where('nkd_del', 0);
			$this->db->like('pacckdcoy', $ProsactivityInfo['pacckdcoy']);
			$this->db->orderby('pacckdcoy', 'asc');
			$query = $this->db->get('dtbprosactivity');
			return $query->num_rows();
			
		} else
			//return $this->Prosactivity_model->countAllProsactivity();
			return $this->countAllProsactivity();
	}

	function getAllProsactivityPagingSearch($ProsactivityInfo, $num, $offset)
	{

		if($ProsactivityInfo['pacckdcoy'] != "") {
		
			$this->db->where('nkd_del', 0);
			$this->db->like('pacckdcoy', $ProsactivityInfo['pacckdcoy']);
			$this->db->orderby('pacckdcoy', 'asc');
			return $this->db->get('dtbprosactivity', $num, $offset);

		} else
			//return $this->Prosactivity_model->getAllProsactivityPaging($num, $offset);
			return Prosactivity_model::getAllProsactivityPaging($num,$offset);		

	}

	function getAllProsactivityInfo($id)
	{
		$this->db->where('pacckdcoy', $id);
		return $this->db->get('dtbprosactivity')->row();
    }

	function addProsactivity($ProsactivityInfo)
	{
		$this->db->insert('dtbprosactivity', $ProsactivityInfo);
		return TRUE;
	}

	function updateProsactivity($ProsactivityInfo)
	{
		$this->db->where('pacckdcoy', $ProsactivityInfo['pacckdcoy']);
		$this->db->update('dtbprosactivity', $ProsactivityInfo);
		return TRUE;
	}
	
	function deleteProsactivity($Prosactivity_id, $ProsactivityInfo)
	{
		// Don't allow the admin to be nkd_del this way				
		if ($Prosactivity_id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('pacckdcoy', $Prosactivity_id);
			$this->db->update('dtbprosactivity', $ProsactivityInfo);
			return TRUE;
		}
	}
	

	
	
	//Android by Dian on 2017-03-08
	function getProsactivityKd($name,$coy)
	{
		if(!empty($name)){
		$this->db->select('pacckdprosac');
		$this->db->where('pacckdcoy',$coy);
		$this->db->where('paccnmprosac',$name);		
		$kd = $this->db->get('dtbprosactivity')->row();
		return isset($kd->pacckdprosac)?$kd->pacckdprosac:$name;
		}else return '';
	}

	//Android by Dian on 2017-03-08
	function getProsactivityName($kd,$coy)
	{
		if(!empty($kd)){
		$this->db->select('paccnmprosac');
		$this->db->where('pacckdcoy',$coy);
		$this->db->where('pacckdprosac',$kd);		
		$nama = $this->db->get('dtbprosactivity')->row();
		return isset($nama->paccnmprosac)?$nama->paccnmprosac:$kd;
		}else return '';
	}
	
	//Android by Dian on 2017-03-08
	function getAllProsactivityLabelValue($coy)
	{
		$this->db->select('pacckdprosac, paccnmprosac');
		$this->db->where('nkd_del', 0);
		$this->db->where('pacckdcoy',$coy);
		$this->db->orderby('pacckdcoy', 'asc');
		return $this->db->get('dtbprosactivity');
	}	
	
	
}
?>