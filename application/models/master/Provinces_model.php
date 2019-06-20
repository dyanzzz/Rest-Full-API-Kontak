<?php
class Provinces_model extends Model {

    function Provinces_model()
    {
        parent::Model();
    }

	function countAllProvinces()
	{
		$this->db->where('nkd_del', 0);
		$query = $this->db->get("dtbprop");
		return $query->num_rows();
	}

	function countAllProvincesSearch($provincesInfo)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('prickdprop', $provincesInfo['prickdprop']);
		$this->db->orderby('prickdprop', 'asc');
		$query = $this->db->get('dtbprop');
		return $query->num_rows();
	}

	function getAllProvinces()
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('pricknmprop', 'asc');
		return $this->db->get('dtbprop');
	}

	function getAllProvincesLabelValue()
	{
		$this->db->select('prickdprop, pricknmprop');
		$this->db->where('nkd_del', 0);
		$this->db->where('pricstatus', '00');
		$this->db->orderby('pricknmprop', 'asc');
		return $this->db->get('dtbprop');
	}
	
	function getAllKotaList($KotaInfo)
	{
		$this->db->where('cmtckdkota',$KotaInfo['cmtckdkota']);
		return $this->db->get('dtbprop');
	}
	
	function getAllProvincesPaging($num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('prickdprop', 'asc');
		return $this->db->get('dtbprop', $num, $offset);
	}

	function getAllProvincesPagingSearch($provincesInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('prickdprop', $provincesInfo['prickdprop']);
		$this->db->orderby('prickdprop', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		return $this->db->get('dtbprop');
	}

	function getAllProvincesInfo($id)
	{
		$this->db->where('prickdprop', $id);
		return $this->db->get('dtbprop')->row();
    }
	
	function addProvinces($provincesInfo)
	{
		$this->db->insert('dtbprop', $provincesInfo);
		return TRUE;
	}

	function getProvincesName($kd)
	{
		if(!empty($kd)){
		$this->db->select('pricknmprop');
		$this->db->where('prickdprop',$kd);		
		$nama = $this->db->get('dtbprop')->row();
		return isset($nama->pricknmprop)?$nama->pricknmprop:$kd;
		}else return '';
	}
	
	function updateProvinces($provincesInfo)
	{
		$this->db->where('prickdprop', $provincesInfo['prickdprop']);
		$this->db->update('dtbprop', $provincesInfo);
		return TRUE;
	}
	
	function deleteProvinces($provinces_id, $provincesInfo)
	{
		// Don't allow the admin to be nkd_del this way				
		if ($provinces_id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('prickdprop', $provinces_id);
			$this->db->update('dtbprop', $provincesInfo);
			return TRUE;
		}
	}
	
	function getKodeProp()
	{
		$this->db->select('prickdprop, pricknmprop');
		$this->db->where('nkd_del', 0);
		$query = $this->db->get('dtbprop');
		return $query->result();
	}
	
	function getKodeKota()
	{
		$this->db->select('kotckdkota, kotcnmkota, kotckdprop');
		$this->db->where('nkd_del', 0);
		$query = $this->db->get('dtbkota');
		return $query->result();
	}
	
	function getKodePropKota()
	{
		$this->db->select('kotckdprop');
		$query = $this->db->get('dtbkota');
		return $query->result();
	}	
	
	/*function deleteProvinces($provinces_id)
	{
		$this->db->where('prickdprop', $provinces_id);
		$this->db->delete('dtbprop');
		return TRUE;
	}*/

}
?>