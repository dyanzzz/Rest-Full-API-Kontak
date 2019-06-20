<?php
class SalesFrom_model extends Model {

    function SalesFrom_model()
    {
        parent::Model();
    }

	function countAllSalesFromSearch($salesfromInfo)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('ckd_slmfr', $salesfromInfo['ckd_slmfr']);
		$this->db->orderby('ckd_slmfr', 'asc');
		$query = $this->db->get('dtbslmfr');
		return $query->num_rows();
	}
	
	function getAllSalesFollowUpValue($nfollowup=1,$nviewparts=0)
	{
		$this->db->select('ckd_slmfr, cnm_slmfr');
		$this->db->where('nkd_del', 0);
		if($nfollowup==1)$this->db->where('nfollowup', $nfollowup);
		if($nviewparts==1)$this->db->where('nviewusparts', $nviewparts);
		$this->db->orderby('cnm_slmfr', 'asc');
		return $this->db->get('dtbslmfr');
	}

	function getAllSalesFromPagingSearch($salesfromInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('ckd_slmfr', $salesfromInfo['ckd_slmfr']);
		$this->db->orderby('ckd_slmfr', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		return $this->db->get('dtbslmfr');
	}

	function getAllSalesFromInfo($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('dtbslmfr')->row();
    	}

	function addSalesFrom($salesfromInfo)
	{
		$this->db->insert('dtbslmfr', $salesfromInfo);
		return TRUE;
	}

	function updateSalesFrom($salesfromInfo)
	{
		$this->db->where('id', $salesfromInfo['id']);
		$this->db->update('dtbslmfr', $salesfromInfo);
		return TRUE;
	}
	
	function deleteSalesFrom($salesfrom_id, $salesfromInfo)
	{
		// Don't allow the admin to be nkd_del this way				
		if ($salesfrom_id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('id', $salesfrom_id);
			$this->db->update('dtbslmfr', $salesfromInfo);
			return TRUE;
		}
	}
	
	
	
	
	
	
	//Android by Dian on 2017-03-08
	function getSalesFromKd($name)
	{
		if(!empty($name)){
			$this->db->select('ckd_slmfr, cnm_slmfr');
			$this->db->where('cnm_slmfr',trim($name));		
			$kd = $this->db->get('dtbslmfr')->row();
			return isset($kd->ckd_slmfr)?$kd->ckd_slmfr:$name;
		}else return '';
	}
	
	//Android by Dian on 2017-03-08
	function getAllSalesFromLabelValue()
	{
		$this->db->select('ckd_slmfr, cnm_slmfr');
		$this->db->where('nkd_del', 0);
		$this->db->orderby('cnm_slmfr', 'asc');
		return $this->db->get('dtbslmfr');
	}
	
	//Android by Dian on 2017-03-08
	function getSalesFromName($kd)
	{
		if(!empty($kd)){
		$this->db->select('ckd_slmfr,cnm_slmfr');
		$this->db->where('ckd_slmfr',trim($kd));		
		$nama = $this->db->get('dtbslmfr')->row();
		return isset($nama->cnm_slmfr)?$nama->cnm_slmfr:$kd;
		}else return '';
	}

	//Android by Dian on 2017-08-03
	function getDefaultSalesFrom()
	{
		$this->db->select('ckd_slmfr');
		$this->db->select('cnm_slmfr');
		$this->db->where('nkd_del', 0);
		$this->db->where('ckd_slmfr', 'CIN');
		//$this->db->orderby('cnm_slmfr', 'asc');
		$result = $this->db->get('dtbslmfr')->row();
		return $result;
	}
	
	function countAllSalesFromSearchAndroidInput()
	{
		$this->db->where('nkd_del', 0);
		$query = $this->db->get('dtbslmfr');
		return $query->num_rows();
	}

}
?>
