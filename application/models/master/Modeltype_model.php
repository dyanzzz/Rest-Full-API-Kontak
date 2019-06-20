<?php
class modeltype_model extends Model {

    function modeltype_model()
    {
        parent::Model();
    }

	function countAllModelType()
	{
		$this->db->where('nkd_del', 0);
		$query = $this->db->get("dtbtipe");
		return $query->num_rows();
	}

	function getAllModelType()
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('tpecnmtipe', 'asc');
		return $this->db->get('dtbtipe');
	}
	
	function getAllUserModelType($usercode,$companycode)
    {
		$sql = "SELECT tpeckdtipe, tpecnmtipe "
			."FROM dtbtipe "
			."WHERE nkd_del=0 AND tpeckdcoy='$companycode'";
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getModelTypeOptional($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('tpecnmoption');
		$this->db->where('tpeckdcoy',$coy);
		$this->db->where('tpeckdtipe',$kd);		
		$nama = $this->db->get('dtbtipe')->row();
		return isset($nama->tpecnmoption)?$nama->tpecnmoption:'-';
		}else return '';
	}
	
	function getModelTypePoint($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('tpenpointsls');
		$this->db->where('tpeckdcoy',$coy);
		$this->db->where('tpeckdtipe',$kd);		
		$nama = $this->db->get('dtbtipe')->row();
		return isset($nama->tpenpointsls)?$nama->tpenpointsls:1;
		}else return '';
	}
	
	function getModelTypeInit($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('tpecinit');
		$this->db->where('tpeckdcoy',$coy);
		$this->db->where('tpeckdtipe',$kd);
		$nama = $this->db->get('dtbtipe')->row();
		return isset($nama->tpecinit)?$nama->tpecinit:$kd;
		}else return '';
	}
	
	function getSubModelType($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('tpeckdsubtipe');
		$this->db->where('tpeckdcoy',$coy);
		$this->db->where('tpeckdtipe',$kd);		
		$nama = $this->db->get('dtbtipe')->row();
		return isset($nama->tpeckdsubtipe)?$nama->tpeckdsubtipe:'?';
		}else return '';
	}
	
	function getSubGouptType($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('tpeckdsgroup');
		$this->db->where('tpeckdcoy',$coy);
		$this->db->where('tpeckdtipe',$kd);		
		$nama = $this->db->get('dtbtipe')->row();
		return isset($nama->tpeckdsgroup)?$nama->tpeckdsgroup:'?';
		}else return '';
	}
	
	/**
	 * This function is view nviewsls,nviewtsvc,nviewtrgsls,nviewspk
	 * nviewsls -> view sales 
	 * nviewtsvc -> view service 
	 * nviewtrgsls -> view target sales
	 * nviewspk ->  view spk
	 */
	
	function getAllModelTypeLabelValueNew($nviewsls=0,$nviewtsvc=0,$nviewtrgsls=0,$nviewspk=0,$tpenviewpurchase=0,$coy='100',$tpenprodplan=0, $tpenviewucar=0,$tpeckdsgroup)
	{
		$this->db->select('tpeckdcoy, tpeckdtipe, tpecnmtipe, tpeckdsgroup, tpecoa');
		if($nviewsls==1)$this->db->where('tpenviewsales', $nviewsls);
		if($nviewtsvc==1)$this->db->where('tpenviewsvc', $nviewtsvc);
		if($nviewtrgsls==1)$this->db->where('tpenviewtrgsls', $nviewtrgsls);
		if($nviewspk==1)$this->db->where('tpenviewspk', $nviewspk);
		if($tpenviewpurchase==1)$this->db->where('tpenviewpurchase', $tpenviewpurchase);
		if($tpenprodplan==1)$this->db->where('tpenprodplan', $tpenprodplan);
		if($tpenviewucar==1)$this->db->where('tpenviewucar', $tpenviewucar);
		$this->db->where('tpeckdcoy',$coy);
		$this->db->where('tpeckdsgroup',$tpeckdsgroup);
		$this->db->where('nkd_del', 0);
		$this->db->where('tpecstatus','00');
		$this->db->orderby('tpeckdtipe', 'asc');
		return $this->db->get('dtbtipe');
	}
	
	function getAllModelTypeValueByAlias($nviewsls=0,$nviewtsvc=0,$nviewtrgsls=0,$nviewspk=0,$tpenviewpurchase=0,$coy='100',$tpenprodplan=0, $tpenviewucar=0)
	{
		$this->db->select('tpeckdtipe AS tipe');
		if($nviewsls==1)$this->db->where('tpenviewsales', $nviewsls);
		if($nviewtsvc==1)$this->db->where('tpenviewsvc', $nviewtsvc);
		if($nviewtrgsls==1)$this->db->where('tpenviewtrgsls', $nviewtrgsls);
		if($nviewspk==1)$this->db->where('tpenviewspk', $nviewspk);
		if($tpenviewpurchase==1)$this->db->where('tpenviewpurchase', $tpenviewpurchase);
		if($tpenprodplan==1)$this->db->where('tpenprodplan', $tpenprodplan);
		if($tpenviewucar==1)$this->db->where('tpenviewucar', $tpenviewucar);
		$this->db->where('tpeckdcoy',$coy);
		$this->db->where('nkd_del', 0);
		$this->db->where('tpecstatus','00');
		$this->db->orderby('tpeckdtipe', 'asc');
		return $this->db->get('dtbtipe');
	}
	
	function getAllModelTypeLabelValueBySvc($coy='100')
	{
		$this->db->select('tpeckdtipe, tpecnmtipe, tpeckdsgroup, tpeckdgroup');
		$this->db->where('nkd_del', 0);
		$this->db->where('tpenviewsvc',1);
		$this->db->where('tpeckdcoy',$coy);
		$this->db->orderby('tpeckdtipe', 'asc');
		return $this->db->get('dtbtipe');
	}

	function getAllModelTypePaging($num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('tpeckdtipe', 'asc');
		return $this->db->get('dtbtipe', $num, $offset);
	}

	function getAllModelTypePagingSearch($modeltypeInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('tpeckdcoy', $modeltypeInfo['tpeckdcoy']);
		$this->db->like('tpeckdtipe', $modeltypeInfo['tpeckdtipe']);
		$this->db->orderby('tpeckdtipe', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		$this->db->orderby('date', 'desc');
		$this->db->orderby('time', 'desc');
		return $this->db->get('dtbtipe');
	}

	function getAllModelTypeView()
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('tpeckdtipe', 'asc');
		return $this->db->get('v_dealersp');
	}

	function getAllmodeltypeInfo($id,$coy='100')
	{
		$this->db->where('tpeckdcoy', $coy);
		$this->db->where('tpeckdtipe', $id);
		return $this->db->get('dtbtipe')->row();
   	}

	function addModelType($modeltypeInfo)
	{
		$this->db->insert('dtbtipe', $modeltypeInfo);
		return TRUE;
	}

	function updateModelType($modeltypeInfo,$coy='100')
	{
		$this->db->where('tpeckdcoy', $coy);
		$this->db->where('tpeckdtipe', $modeltypeInfo['tpeckdtipe']);
		$this->db->update('dtbtipe', $modeltypeInfo);
		return TRUE;
	}
	
	function deletemodeltype($modeltype_Id,$modeltype_Info)
	{
		// Don't allow the admin to be nkd_del this way				
		if ($modeltype_Id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('tpeckdtipe', $modeltype_Id);
			$this->db->update('dtbtipe', $modeltype_Info);
			return TRUE;
		}
	}
	
	function getAssignedRoleColor($tipecode,$coy='100')
	{
		$sql = "SELECT wrnckdwarna, wrncnmwarna,wrncnmwarpol FROM dtbwarna "
				. "WHERE nkd_del=0 AND wrnckdcoy='".$coy."'"
				. "AND wrnckdwarna IN "
				. "(SELECT wartipeckdwarna FROM dtbwarnatipe WHERE wartipeckdcoy='"
				. $coy . "' AND wartipeckdtipe='". $tipecode . "')";
		
		$query = $this->db->query($sql);
		return $query;		
	}
	
	function getNotAssignedRoleColor($tipecode,$coy='100')
    {
		$sql = "SELECT wrnckdwarna, wrncnmwarna,wrncnmwarpol FROM dtbwarna "
				. "WHERE nkd_del=0 AND wrnckdcoy='".$coy."'"
				. "AND wrnckdwarna NOT IN "
				. "(SELECT wartipeckdwarna FROM dtbwarnatipe WHERE wartipeckdcoy='"
				. $coy . "' AND wartipeckdtipe='". $tipecode . "')";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getRoleColor($colorInfo)
	{
		$this->db->where('wartipeckdcoy', $colorInfo['wartipeckdcoy']);
		$this->db->where('wartipeckdtipe',$colorInfo['wartipeckdtipe']);
		$this->db->where('wartipeckdwarna',$colorInfo['wartipeckdwarna']);
		return $this->db->get('dtbwarnatipe')->row();
	}
	
	function addAssignRoleColor($colorInfo)
	{
		$this->db->insert('dtbwarnatipe', $colorInfo);
		return TRUE;
	}
	
	function deleteAssignRoleColor($colorInfo)
	{
		$this->db->where('wartipeckdtipe', $colorInfo['wartipeckdtipe']);
		$this->db->where('wartipeckdwarna', $colorInfo['wartipeckdwarna']);
		$this->db->delete('dtbwarnatipe');
		return TRUE;
	}
	
	function getAllModelTypePrint($info)
	{
		$searchBy ="";  
		$searchBy .=!empty($info['tpeckdcoy'])? " AND tpeckdcoy LIKE '".$info['tpeckdcoy']."'":"";
		$searchBy .=!empty($info['tpeckdtipe'])? " AND tpeckdtipe LIKE '".$info['tpeckdtipe']."'":"";
		
		$sql ="SELECT * FROM dtbtipe 
				WHERE 1=1 $searchBy
			  ORDER BY tpeckdtipe ASC"; 
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$datac[]=$data;
			}
			return $datac;
		}
	}

	
	
	
	//Android by Dian on 2017-03-08
	function getModelTypeName($kd,$coy='100')
	{
		if(!empty($kd)){
			$this->db->select('tpecnmtipe');
			$this->db->where('tpeckdcoy',$coy);
			$this->db->where('tpeckdtipe',$kd);		
			$nama = $this->db->get('dtbtipe')->row();
			return isset($nama->tpecnmtipe)?$nama->tpecnmtipe:$kd;
		} else return '';
	}
	
	//Android by Dian on 2017-03-08
	function getAllModelTypeLabelValue($search_value, $offset, $limit, $coy='100')
	{
		//$this->db->select('tpeckdcoy, tpeckdtipe, tpecnmtipe, tpeckdsgroup, tpecoa');
		//if($nviewsls==1)$this->db->where('tpenviewsales', "0");
		//if($nviewtsvc==1)$this->db->where('tpenviewsvc', "0");
		//if($nviewtrgsls==1)$this->db->where('tpenviewtrgsls', "0");
		//if($nviewspk==1)$this->db->where('tpenviewspk', "0");
		//if($tpenviewpurchase==1)$this->db->where('tpenviewpurchase', "0");
		//if($tpenprodplan==1)$this->db->where('tpenprodplan', "0");
		//if($tpenviewucar==1)$this->db->where('tpenviewucar', "0");
		$this->db->like('tpecnmtipe', $search_value);
		$this->db->where('tpeckdcoy', $coy);
		$this->db->where('nkd_del', 0);
		$this->db->where('tpecstatus','00');
		$this->db->where('tpenviewsales', '1');
		$this->db->orderby('tpeckdtipe', 'asc');
		$this->db->offset($offset);
		$this->db->limit($limit);
		return $this->db->get('dtbtipe');
	}
	
	//Android by Dian on 2017-07-20
	function countAllmodeltypeSearch($search_value, $offset, $limit, $coy='100')
	{
		$this->db->like('tpecnmtipe', $search_value);
		$this->db->where('tpeckdcoy', $coy);
		$this->db->where('nkd_del', 0);
		$this->db->where('tpecstatus','00');
		$this->db->where('tpenviewsales', '1');
		$this->db->orderby('tpeckdtipe', 'asc');
		$this->db->offset($offset);
		$this->db->limit($limit);
		$query = $this->db->get('dtbtipe');
		return $query->num_rows();
	}
	
	//untuk test drive 17/01/2018
	function countAllTipeKendaraanTestDrive($offset, $limit){
		$this->db->where('nkd_del', 0);
		$this->db->where('tpenviewappstestdrv', 1);
		$query = $this->db->get("dtbtipe");
		return $query->num_rows();
	}
	
	//untuk test drive 17/01/2018
	function getAllTipeKendaraanTestDrive($offset, $limit){
		$this->db->where('nkd_del', 0);
		$this->db->where('tpenviewappstestdrv', 1);
		$this->db->offset($offset);
		$this->db->limit($limit);
		$this->db->orderby('tpecnmtipe', 'asc');
		return $this->db->get('dtbtipe');
	}
	
	
}
?>