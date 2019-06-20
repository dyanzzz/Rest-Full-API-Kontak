<?php
class SalesProblem_model extends Model {

    function SalesProblem_model()
    {
        parent::Model();
    }

	function countAllSalesProblemSearch($salesproblemInfo)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('ckd_prbsl', $salesproblemInfo['ckd_prbsl']);
		$this->db->orderby('ckd_prbsl', 'asc');
		$query = $this->db->get('dtbprbsl');
		return $query->num_rows();
	}

	function getAllSalesProblemPagingSearch($salesproblemInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('ckd_prbsl', $salesproblemInfo['ckd_prbsl']);
		$this->db->orderby('ckd_prbsl', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		return $this->db->get('dtbprbsl');
	}

	function getAllSalesProblemInfo($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('dtbprbsl')->row();
    	}

	function addSalesProblem($salesproblemInfo)
	{
		$this->db->insert('dtbprbsl', $salesproblemInfo);
		return TRUE;
	}

	function updateSalesProblem($salesproblemInfo)
	{
		$this->db->where('id', $salesproblemInfo['id']);
		$this->db->update('dtbprbsl', $salesproblemInfo);
		return TRUE;
	}
	
	function deleteSalesProblem($salesproblem_id, $salesproblemInfo)
	{
		// Don't allow the admin to be nkd_del this way				
		if ($salesproblem_id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('id', $salesproblem_id);
			$this->db->update('dtbprbsl', $salesproblemInfo);
			return TRUE;
		}
	}
	
	
	
	
	//Android by Dian on 2017-03-08
	function getSalesProblemKd($name){
		if(!empty($name)){$this->db->select('ckd_prbsl, cnm_prbsl');
			$this->db->where('cnm_prbsl', $name);
			$kd = $this->db->get('dtbprbsl')->row();
			return isset($kd->ckd_prbsl)?$kd->ckd_prbsl:$name;
		}else return $name;
	}

	//Android by Dian on 2017-03-08
	function getSalesProblemName($id)
	{
		if(!empty($id)){$this->db->select('ckd_prbsl,cnm_prbsl');
			$this->db->where('ckd_prbsl', $id);
			$hobby = $this->db->get('dtbprbsl')->row();
			return isset($hobby->cnm_prbsl)?$hobby->cnm_prbsl:$id;
		}else return $id;
	}
	
	//Android by Dian on 2017-03-08
 	function getAllSalesProblemLabelValue()
	{
		$this->db->select('ckd_prbsl, cnm_prbsl');
		$this->db->where('nkd_del', 0);
		$this->db->orderby('ckd_prbsl', 'asc');
		return $this->db->get('dtbprbsl');
	}
}
?>
