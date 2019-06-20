<?php
class Branch_model extends Model {

    function Branch_model()
    {
        parent::Model();
    }

	function countAllBranch()
	{
		$this->db->where('nkd_del', 0);
		$query = $this->db->get("dtbcab");
		return $query->num_rows();
	}

	function getAllBranchList($branchInfo)
	{
		if($branchInfo['cabckdcab'] != null && $branchInfo['cabckdcab'] != "")
		$this->db->where('cabckdcab', $branchInfo);
		return $this->db->get('dtbcab')->row();
	}

	function countAllBranchSearch($branchInfo)
	{
		$this->db->where('cabckdcoy', $branchInfo['cabckdcoy']);
		$this->db->where('nkd_del', 0);
		$this->db->like('cabckdcab', $branchInfo['cabckdcab']);
		$query = $this->db->get('dtbcab');
		return $query->num_rows();
	}
	
	function getAllBranchLabelValueCoyCab($supervisorInfo)
	{
		$this->db->select('cabckdcab, cabcnmcab');
		$this->db->where('nkd_del', 0);
		$this->db->where('cabckdcoy', $supervisorInfo['cabckdcoy']);
		$res = $this->db->get("dtbcab")->result_array();
		$slm = array();
		foreach($res as $a=>$b):
			$slm[$b['cabckdcab']]=$b['cabcnmcab'];
		endforeach; 
		return $slm;
	}
	
	function getAllBranch()
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('cabckdcab', 'asc');
		return $this->db->get('dtbcab');
	}
	
	function getAllBranchInvoice($branchInfo)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('cabckdcoy', $branchInfo['cabckdcoy']);
		$this->db->where('cabckdcab', $branchInfo['cabckdcab']);
		return $this->db->get('dtbcab')->row();
	}

	function getBranchName($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('cabcnmcab');
		$this->db->where('cabckdcoy',$coy);
		$this->db->where('cabckdcab',$kd);		
		$nama = $this->db->get('dtbcab')->row();
		return isset($nama->cabcnmcab)?$nama->cabcnmcab:$kd;
		}else return '';
	}
	
	function getBranchInitParts($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('cabcinitpart');
		$this->db->where('cabckdcoy',$coy);
		$this->db->where('cabckdcab',$kd);		
		$nama = $this->db->get('dtbcab')->row();
		return isset($nama->cabcinitpart)?$nama->cabcinitpart:$kd;
		}else return '';
	}
	
	function getBranchArea($cab,$coy='100')
	{
		if(!empty($cab)){
			$this->db->select('cabckdoprarea');
			$this->db->where('cabckdcoy',$coy);
			$this->db->where('cabckdcab',$cab);		
			$nama = $this->db->get('dtbcab')->row();
			return isset($nama->cabckdarea)?$nama->cabckdarea:$cab;
		}else return '';
	}
	
	function getBranchOpArea($cab,$coy='100')
	{
		if(!empty($cab)){
			$this->db->select('cabckdoprarea');
			$this->db->where('cabckdcoy',$coy);
			$this->db->where('cabckdcab',$cab);		
			$nama = $this->db->get('dtbcab')->row();
			return isset($nama->cabckdoprarea)?$nama->cabckdoprarea:$cab;
		}else return '';
	}
	
	function getBranchByField($cab,$coy='100',$field)
	{
		if(!empty($cab)){
			$this->db->select($field);
			$this->db->where('cabckdcoy',$coy);
			$this->db->where('cabckdcab',$cab);		
			$nama = $this->db->get('dtbcab')->row();
			return isset($nama->$field)?$nama->$field:$cab;
		}else return '';
	}
	
	function getBranchInit($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('cabcinit');
		$this->db->where('cabckdcoy',$coy);
		$this->db->where('cabckdcab',$kd);		
		$nama = $this->db->get('dtbcab')->row();
		return isset($nama->cabcinit)?$nama->cabcinit:$kd;
		}else return '';
	}
	
	function getAllBranchLabelValue($branchInfo)
	{
		$this->db->select('cabckdcab, cabcnmcab');
		$this->db->where('nkd_del', 0);
		$this->db->where('cabcstatus', '00');
		if(!empty($branchInfo['cabckdcoy']))$this->db->where('cabckdcoy', $branchInfo['cabckdcoy']);
		if(!empty($branchInfo['cabckdcab']))$this->db->where('cabckdcab', $branchInfo['cabckdcab']);
		if(!empty($branchInfo['cabnslubranch']))$this->db->where('cabnslubranch', $branchInfo['cabnslubranch']);
		if(!empty($branchInfo['cabckdoprarea']))$this->db->where('cabckdoprarea', $branchInfo['cabckdoprarea']);
		if(!empty($branchInfo['cabnviewslsbrchmi']))$this->db->where('cabnviewslsbrchmi', 1);
		$this->db->orderby('cabckdcab', 'asc');
		return $this->db->get('dtbcab');
	}

	function getAllBranchLabelValueNoParam()
	{
		$this->db->select('cabckdcab, cabcnmcab');
		$this->db->where('nkd_del', 0);
		$this->db->where('cabcstatus', '00');
		$this->db->orderby('cabckdcab', 'asc');
		return $this->db->get('dtbcab');
	}
	
	#2009-06-19 get Only Branch or HeadOffice | Branch==1  HeadOffice == 0
	function getAllBranchOrHOF($coyckdcoy='100',$cabnstsbrc=1)
	{
		$this->db->select('cabckdcab, cabcnmcab');
		if($coyckdcoy!='-')$this->db->where('cabckdcoy', $coyckdcoy);
		$this->db->where('cabnstsbrc', $cabnstsbrc);
		$this->db->where('nkd_del', 0);
		$this->db->where('cabcstatus', '00');
		$this->db->orderby('cabckdcab', 'asc');
		return $this->db->get('dtbcab')->result();
	}
	
	function getAllBranchPaging($num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('cabckdcab', 'asc');
		return $this->db->get('dtbcab', $num, $offset);
	}

	function getAllBranchPagingSearch($branchInfo, $num, $offset)
	{
		$this->db->like('cabckdcoy', $branchInfo['cabckdcoy']);
		$this->db->where('nkd_del', 0);
		$this->db->like('cabckdcab', $branchInfo['cabckdcab']);
		$this->db->orderby('cabckdcab', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		return $this->db->get('dtbcab');
	}

	function getAllBranchInfo($id,$coy='100')
	{
		$this->db->where('cabckdcab', $id);
		$this->db->where('cabckdcoy', $coy);
		return $this->db->get('dtbcab')->row();
		//print_r($this->db->last_query());
    }
    
 	function addBranch($branchInfo)
	{
		return $this->db->insert('dtbcab', $branchInfo);
	}

	function updateBranch($branchInfo)
	{
		$this->db->where('cabckdcoy', $branchInfo['cabckdcoy']);
		$this->db->where('cabckdcab', $branchInfo['cabckdcab']);
		return $this->db->update('dtbcab', $branchInfo);
	}
	
	function deleteBranch($branch_id, $branchInfo)
	{
		// Don't allow the admin to be nkd_del this way				
		if ($branch_id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('cabckdcab', $branch_id);
			return $this->db->update('dtbcab', $branchInfo);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	function getAllBranchLabelValueByCoy($coy){
		$this->db->select('cabckdcab, cabcnmcab');
		$this->db->where('nkd_del', 0);
		$this->db->where('cabckdcoy', $coy);
		return $this->db->get('dtbcab');
	}
	
	function getAllBranchLabelValueByCoy_count($coy){
		$this->db->where('nkd_del', 0);
		$this->db->where('cabckdcoy', $coy);
		$query	= $this->db->get('dtbcab');
		return $query->num_rows();
	}

}
?>