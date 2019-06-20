<?php
class CusProspek_model extends Model {

    function CusProspek_model()
    {
        parent::Model();
    }

	function countAllCusProspek()
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('cprcstatus','00');
		$query = $this->db->get("dtbcuspr");
		return $query->num_rows();
	}

	
	
	/* perubahan list cusomer berdasarkan code salesman -> cabang depok user keshia.taurina*/
	function countAllCusProspekSearchName($cusprospekInfo)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('cprckdcoy', $cusprospekInfo['cprckdcoy']);
		if(!empty($cusprospekInfo['cprckdcab']))$this->db->where('cprckdcab', $cusprospekInfo['cprckdcab']);
		if(!empty($cusprospekInfo['cprckdsls']) && $cusprospekInfo['acclevel']==19 ||  $cusprospekInfo['acclevel']==15 || $cusprospekInfo['acclevel']==4  || $cusprospekInfo['acclevel']==2)$this->db->where('cprckdsls', $cusprospekInfo['cprckdsls']);
		if($cusprospekInfo['cprcnmcust']!=='-')
		$this->db->like('cprcnmcust', $cusprospekInfo['cprcnmcust']);
		$this->db->orderby('cprckdcust', 'asc');
		$query = $this->db->get('dtbcuspr');
		return $query->num_rows();
	}

	function getCusProspekName($kd)
	{
		if(!empty($kd)){
		$this->db->select('cprcnmcust');
		$this->db->where('cprckdcust',$kd);		
		$nama = $this->db->get('dtbcuspr')->row();
		return isset($nama->cprcnmcust)?$nama->cprcnmcust:$kd;
		}else return '';
	}

	function getAllCusProspek()
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('cprcnmcust', 'asc');
		return $this->db->get('dtbcuspr');
	}

	function getAllCusProspekLabelValue()
	{
		$this->db->select('cprckdcust, cprcnmcust');
		$this->db->where('nkd_del', 0);
		$this->db->where('cprcstatus', '00');
		$this->db->orderby('cprcnmcust', 'asc');
		return $this->db->get('dtbcuspr');
	}

	function getAllCusProspekPaging($num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('cprckdcust', 'asc');
		return $this->db->get('dtbcuspr', $num, $offset);
	}

	function getAllCusProspekPagingSearch($cusprospekInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('cprckdcoy', $cusprospekInfo['cprckdcoy']);
		if(!empty($cusprospekInfo['cprckdcab']))$this->db->where('cprckdcab', $cusprospekInfo['cprckdcab']);
		if(!empty($cusprospekInfo['cprckdsls']) && $cusprospekInfo['acclevel']==19 ||  $cusprospekInfo['acclevel']==15 || $cusprospekInfo['acclevel']==4  || $cusprospekInfo['acclevel']==2)$this->db->where('cprckdsls', $cusprospekInfo['cprckdsls']);
		$this->db->like('cprckdcust', $cusprospekInfo['cprckdcust']);
		$this->db->orderby('cprckdcust', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		$sql = $this->db->get('dtbcuspr');
		return $sql;	
	}
	
	function getAllCusProspekPagingSearchName($cusprospekInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('cprckdcoy', $cusprospekInfo['cprckdcoy']);
		if(!empty($cusprospekInfo['cprckdcab']))$this->db->where('cprckdcab', $cusprospekInfo['cprckdcab']);
		if(!empty($cusprospekInfo['cprckdsls']) && $cusprospekInfo['acclevel']==19 ||  $cusprospekInfo['acclevel']==15 || $cusprospekInfo['acclevel']==4  || $cusprospekInfo['acclevel']==2)$this->db->where('cprckdsls', $cusprospekInfo['cprckdsls']);
		if($cusprospekInfo['cprcnmcust']!=='-')$this->db->like('cprcnmcust', $cusprospekInfo['cprcnmcust']);
		$this->db->orderby('cprckdcust', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		$sql = $this->db->get('dtbcuspr');
		return $sql;	
	}
	
	function getCusProspekBySales($id)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('ckd_sls',$id);
		return $this->db->get('dtbcuspr');
	}
	
    function getAllCusProspekInfoByCustSlm($id)
	{
		$this->db->where('cprckdcoy', $id['cprckdcoy']);
		$this->db->where('cprckdcab', $id['cprckdcab']);
		$this->db->where('cprckdcust', $id['cprckdcust']);
		$this->db->where('cprckdsls', $id['cprckdsls']);
		return $this->db->get('dtbcuspr')->row();
    }

	function updateCusProspek($cusprospekInfo)
	{
		$this->db->where('cprckdcoy', $cusprospekInfo['cprckdcoy']);
		$this->db->where('cprckdcab', $cusprospekInfo['cprckdcab']);
		$this->db->where('cprckdcust', $cusprospekInfo['cprckdcust']);
		return $this->db->update('dtbcuspr', $cusprospekInfo);
	}
	
	function deleteCusProspek($cusprospek_id, $cusprospekInfo)
	{
		// Don't allow the admin to be nkd_del this way
		if ($cusprospek_id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('id', $cusprospek_id);
			$this->db->update('dtbcuspr', $cusprospekInfo);
			return TRUE;
		}
	}

	
	
	
	//Android
	function addCusProspek($cusprospekInfo)
	{
		return $this->db->insert('dtbcuspr', $cusprospekInfo);
	}
	
	//Android
	function getAllCusProspekInfo($id)
	{
		$this->db->where('cprckdcoy', $id['cprckdcoy']);
		if(!empty($id['cprckdcab']))$this->db->where('cprckdcab', $id['cprckdcab']);
		$this->db->where('cprckdcust', $id['cprckdcust']);
		return $this->db->get('dtbcuspr')->row();
    }
	
	//Android by Dian on 2017-03-08
	function getAllCustomer($cusprospekInfo, $offset, $limit, $search_value)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('cprckdcoy', $cusprospekInfo['cprckdcoy']);
		if(!empty($cusprospekInfo['cprckdcab']))$this->db->where('cprckdcab', $cusprospekInfo['cprckdcab']);
		if(!empty($cusprospekInfo['cprckdsls']) && $cusprospekInfo['acclevel']==19 ||  $cusprospekInfo['acclevel']==15 || $cusprospekInfo['acclevel']==4  || $cusprospekInfo['acclevel']==2)$this->db->where('cprckdsls', $cusprospekInfo['cprckdsls']);
		if($cusprospekInfo['cprcnmcust']!=='-')$this->db->like('cprcnmcust', $search_value);
		$this->db->orderby('cprcnmcust', 'asc');
		$this->db->offset($offset);
		$this->db->limit($limit);
		$sql = $this->db->get('dtbcuspr');
		return $sql;
	}
	
	function countAllCusProspekSearch($cusprospekInfo, $offset, $limit, $search_value)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('cprckdcoy', $cusprospekInfo['cprckdcoy']);
		if(!empty($cusprospekInfo['cprckdcab']))$this->db->where('cprckdcab', $cusprospekInfo['cprckdcab']);
		if(!empty($cusprospekInfo['cprckdsls']) && $cusprospekInfo['acclevel']==19 ||  $cusprospekInfo['acclevel']==15 || $cusprospekInfo['acclevel']==4  || $cusprospekInfo['acclevel']==2)$this->db->where('cprckdsls', $cusprospekInfo['cprckdsls']);
		$this->db->like('cprcnmcust', $search_value);
		$this->db->orderby('cprckdcust', 'asc');
		$this->db->offset($offset);
		$this->db->limit($limit);
		$query = $this->db->get('dtbcuspr');
		return $query->num_rows();
	}
	
}
?>