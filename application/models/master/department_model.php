<?php
class Department_model extends Model {

    function Department_model()
    {
        parent::Model();
    }

	function countAllDepartment()
	{
		$this->db->where('nkd_del', 0);
		$query = $this->db->get("dtbdept");
		return $query->num_rows();
	}

	function countAllDepartmentSearch($departmentInfo,$allowedcoy=array())
	{
		if($departmentInfo['depckddep'] == "") $departmentInfo['depckddep']='%';
		$sql = "SELECT * FROM (dtbdept) WHERE nkd_del = 0 AND depcstatus='00' AND" .
				" depckddep LIKE '%".$departmentInfo['depckddep']."%'";
				
		if($departmentInfo['depckdcoy'] == "-"){
			$coylist='';
			foreach($allowedcoy as $coy):
				if($coylist=='')$coylist=$coy->coyckdcoy; else $coylist = $coylist.','.$coy->coyckdcoy;
			endforeach; 
			$sql .= " AND depckdcoy IN (".$coylist.")";
		} else $sql .= " AND depckdcoy = '".$departmentInfo['depckdcoy']."'"; 

		$query = $this->db->query($sql);
		$row = $query->num_rows();
		return empty($row)?0:$row; 		
	}

	function getAllDepartment()
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('depcnmdep', 'asc');		
		return $this->db->get('dtbdept');

	}
	
	function getDepartmentName($id,$coy='100')
	{
		if(!empty($id)){
		$this->db->select('depcnmdep');
		$this->db->where('depckdcoy', $coy);
		$this->db->where('depckddep', $id);
		$nama = $this->db->get('dtbdept')->row();
		return isset($nama->depcnmdep)?$nama->depcnmdep:$id;
		}else return '';	
	}
	
	// tri @08122011
	function getDepartmentInit($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('depcinit');
		$this->db->where('depckdcoy',$coy);
		$this->db->where('depckddep',$kd);		
		$init = $this->db->get('dtbdept')->row();
		return isset($init->depcinit)?$init->depcinit:$kd;
		}else return '';
	}
	
	function getAllDepartmentLabelValueCoyCab($supervisorInfo)
	{
		$this->db->select('depckddep, depcnmdep');
		$this->db->where('nkd_del', 0);
		$this->db->where('depckdcoy', $supervisorInfo['depckdcoy']);
		$this->db->orderby('depckddep', 'asc');
		$res = $this->db->get("dtbdept")->result_array();
		$slm = array();
		foreach($res as $a=>$b):
			$slm[$b['depckddep']]=$b['depcnmdep'];
		endforeach; 
		return $slm;
	}
	
	function getAllDepartmentLabelValueByCoy($coy=100)
	{
		$this->db->select('depckdcoy, depckddep, depcnmdep');
		$this->db->where('nkd_del', 0);
		$this->db->where('depcstatus','00');
		$this->db->where('depckdcoy', $coy);
		$this->db->orderby('depckddep', 'asc');		
		return $this->db->get('dtbdept');
	}
	
	function getAllDepartmentLabelValue()
	{
		$this->db->select('depckddep, depcnmdep');
		$this->db->where('nkd_del', 0);
		$this->db->where('depcstatus','00');
		$this->db->orderby('depckddep', 'asc');
		return $this->db->get('dtbdept');
	}
	
	function getAllDepartmentLabelValueWithParam($coy=100)
	{
		$this->db->select('depckddep, depcnmdep');
		$this->db->where('nkd_del', 0);
		$this->db->where('depcstatus','00');
		$this->db->where('depckdcoy',$coy);
		
		$this->db->orderby('depcnmdep', 'asc');
		return $this->db->get('dtbdept');
	}

	function getAllDepartmentPaging($num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('depckddep', 'asc');
		
		return $this->db->get('dtbdept', $num, $offset);
		
	}

	function getAllDepartmentPagingSearch($departmentInfo, $num, $offset,$allowedcoy=array())
	{

		if($departmentInfo['depckddep'] == "") $departmentInfo['depckddep']='%';
		if(empty($offset)) $offset = 0; 
		
		$sql = "SELECT * FROM (dtbdept) WHERE nkd_del = 0 AND" .
				" depckddep LIKE '%".$departmentInfo['depckddep']."%'";
				
		if($departmentInfo['depckdcoy'] == "-"){
			$coylist='';
			foreach($allowedcoy as $coy):
				if($coylist=='')$coylist=$coy->coyckdcoy; else $coylist = $coylist.','.$coy->coyckdcoy;
			endforeach; 
			$sql .= " AND depckdcoy IN (".$coylist.")";
		} else $sql .= " AND depckdcoy = '".$departmentInfo['depckdcoy']."'"; 
		$sql .= " ORDER BY depckdcoy asc, depckddep asc";
		$sql .= " LIMIT ".$offset.",".$num;
		
		return $this->db->query($sql);
	}

	function getAllDepartmentInfo($id,$coy=null)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('depckddep', $id);
		if($coy!=null)$this->db->where('depckdcoy', $coy);
		return $this->db->get('dtbdept')->row();
    }

	function addDepartment($departmentInfo)
	{
		return $this->db->insert('dtbdept', $departmentInfo);
	}

	function updateDepartment($departmentInfo)
	{
		$this->db->where('depckddep', $departmentInfo['depckddep']);
		return $this->db->update('dtbdept', $departmentInfo);
	}
	
	function deleteDepartment($departmentInfo)
	{
		// Update nkd_del field = 1
		$this->db->where('depckddep', $departmentInfo['depckddep']);
		$this->db->where('depckdcoy', $departmentInfo['depckdcoy']);
		return $this->db->update('dtbdept', $departmentInfo);
	}

	
	
	
	
	
	
	
	
	function getAllDeptLabelValueByCoy($coy){
		$this->db->select('depckddep, depcnmdep');
		$this->db->where('nkd_del', 0);
		$this->db->where('depckdcoy', $coy);
		return $this->db->get('dtbdept');
	}
	
	function getAllDeptLabelValueByCoy_count($coy){
		$this->db->select('depckddep, depcnmdep');
		$this->db->where('nkd_del', 0);
		$this->db->where('depckdcoy', $coy);
		$query = $this->db->get('dtbdept');
		return $query->num_rows();
	}
	
}
?>