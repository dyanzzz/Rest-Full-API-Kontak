<?php
class Exhibition_model extends Model {

    function Exhibition_model()
    {
        parent::Model();
    }

	function countAllExhibition()
	{
		$this->db->where('nkd_del', 0);
		$query = $this->db->get("dtbexib");
		return $query->num_rows();
	}

	
	
	function countAllExhibitionSearchByQuery($exhibitionInfo)
	{
		$sql = "SELECT * FROM dtbexib " .
				"WHERE nkd_del=0 ";
		$sql .=	"AND (ckd_exib LIKE '%".$exhibitionInfo['ckd_exib']."%' OR cnm_exib LIKE  '%".$exhibitionInfo['ckd_exib']."%')";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getAllExhibition()
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('cnm_exib', 'asc');
		return $this->db->get('dtbexib');
	}

	function getAllExhibitionPaging($num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('ckd_exib', 'asc');
		return $this->db->get('dtbexib', $num, $offset);
	}
	
	function getAllExhibitionPagingSearch($exhibitionInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('ckd_exib', $exhibitionInfo['ckd_exib']);
		$this->db->orderby('ckd_exib', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		return $this->db->get('dtbexib');
	}
	
	function getAllExhibitionPagingSearchByQuery($exhibitionInfo, $num, $offset)
	{
		$sql = "SELECT * FROM dtbexib" .
				" WHERE nkd_del = 0 " .
				" AND (ckd_exib LIKE '%". $exhibitionInfo['ckd_exib'] ."%' OR cnm_exib LIKE  '%".$exhibitionInfo['ckd_exib']."%')" .
				" ORDER BY ckd_exib asc" .
				" LIMIT ".$num." OFFSET ".$offset."";
		return $this->db->query($sql);
	}

	function getAllExhibitionInfo($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('dtbexib')->row();
    	}

	function addExhibition($exhibitionInfo)
	{
		$this->db->insert('dtbexib', $exhibitionInfo);
		return TRUE;
	}

	function updateExhibition($exhibitionInfo)
	{
		$this->db->where('id', $exhibitionInfo['id']);
		$this->db->update('dtbexib', $exhibitionInfo);
		return TRUE;
	}
	
	function deleteExhibition($exhibition_id, $exhibitionInfo)
	{
		// Don't allow the admin to be nkd_del this way				
		if ($exhibition_id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('id', $exhibition_id);
			$this->db->update('dtbexib', $exhibitionInfo);
			return TRUE;
		}
	}
	
	
	
	
	
	function countAllExhibitionSearch($search_value, $offset, $limit)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('cstatus','00');
		$this->db->like('cnm_exib', $search_value);
		$this->db->orderby('ckd_exib', 'asc');
		$this->db->offset($offset);
		$this->db->limit($limit);
		$query = $this->db->get('dtbexib');
		return $query->num_rows();
	}
	
	//Android by Dian on 2017-03-08
	function getExhibitionKd($name)
	{
		if(!empty($name)){
		$this->db->select('ckd_exib, cnm_exib');
		$this->db->where('cnm_exib',$name);
		$kd = $this->db->get('dtbexib')->row();
		return isset($kd->ckd_exib)?$kd->ckd_exib:$name;
		}else return '';
	}
	
	//Android
	function getAllExhibitionLabelValue($search_value, $offset, $limit)
	{
		$this->db->select('ckd_exib, cnm_exib');
		$this->db->where('nkd_del', 0);
		$this->db->where('cstatus','00');
		$this->db->like('cnm_exib',$search_value);
		$this->db->orderby('ckd_exib', 'asc');
		$this->db->offset($offset);
		$this->db->limit($limit);
		return $this->db->get('dtbexib');
	}
	
	//Android
	function getExhibitionName($kd)
	{
		if(!empty($kd)){
		$this->db->select('ckd_exib, cnm_exib');
		$this->db->where('ckd_exib',$kd);
		$nama = $this->db->get('dtbexib')->row();
		return isset($nama->cnm_exib)?$nama->cnm_exib:$kd;
		}else return '';
	}

	//Android by Dian on 2017-08-03
	function getDefaultExhibition()
	{
		$this->db->select('ckd_exib');
		$this->db->select('cnm_exib');
		$this->db->where('nkd_del', 0);
		$this->db->where('ckd_exib', 'NOE');
		//$this->db->orderby('cnm_exib', 'asc');
		$result = $this->db->get('dtbexib')->row();
		return $result;
	}
	
}
?>