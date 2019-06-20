<?php
class Warna_model extends Model {

    function Warna_model()
    {
        parent::Model();
    }

	function countAllWarna()
	{
		$this->db->where('nkd_del', 0);
		$query = $this->db->get("dtbwarna");
		return $query->num_rows();
	}

	function countAllWarnaSearch($warnaInfo)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('wrnckdcoy', $warnaInfo['wrnckdcoy']);
		$this->db->like('wrnckdwarna', $warnaInfo['wrnckdwarna']);
		$this->db->orderby('wrnckdwarna', 'asc');
		$query = $this->db->get('dtbwarna');
		return $query->num_rows();
	}

	function getAllWarna()
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('wrnckdwarna', 'asc');
		return $this->db->get('dtbwarna');
	}
	
	function getAllUserWarna($usercode,$companycode)
    {
		$sql = "SELECT wrnckdwarna, wrncnmwarna "
			."FROM dtbwarna "
			."WHERE nkd_del=0 AND wrnckdcoy='$companycode'";	
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getWarnaNameOnly($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('wrncnmwarna, wrncnmwarpol');
		$this->db->where('wrnckdwarna',$kd);
		$this->db->where('wrnckdcoy',$coy);
		$nama = $this->db->get('dtbwarna')->row();
		return isset($nama->wrncnmwarna)?$nama->wrncnmwarna:'?';
		}else return '';
	}
	
	function getWarnaNameID($kd,$coy='100')
	{
		if(!empty($kd)){
		$this->db->select('wrncnmwarna, wrncnmwarpol');
		$this->db->where('wrnckdwarna',$kd);
		$this->db->where('wrnckdcoy',$coy);
		$nama = $this->db->get('dtbwarna')->row();
		return isset($nama->wrncnmwarpol)?$nama->wrncnmwarpol:'?';
		}else return '';
	}
	
	function getAllWarnaLabelValue($coy='100')
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('wrncstatus','00');
		$this->db->where('wrnckdcoy',$coy);
		$this->db->orderby('wrnckdwarna', 'asc');
		return $this->db->get('dtbwarna');
	}
	
	function getWarnaValueByModelTipe($tipe,$coy='100')
	{
		$query = "SELECT wrnckdwarna,wrncnmwarna FROM dtbwarna "
				. "WHERE wrnckdwarna in (SELECT tpwckdwarna FROM dtbtpwrn "
				. "WHERE tpwckdtipe = $tipe)";
		$sql = $this->db->query($query);
		return $sql->result_array();
		$slm = array();
		foreach($sql as $a=>$b):
			$slm[$b['wrnckdwarna']]=$b['wrncnmwarna'];
		endforeach; 
		return $slm;
	}
	
	function getAllWarnaPaging($num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('wrnckdwarna', 'asc');
		return $this->db->get('dtbwarna', $num, $offset);
	}

	function getAllWarnaPagingSearch($warnaInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('wrnckdcoy', $warnaInfo['wrnckdcoy']);
		$this->db->like('wrnckdwarna', $warnaInfo['wrnckdwarna']);
		$this->db->orderby('wrnckdwarna', 'asc');
		return $this->db->get('dtbwarna', $num, $offset);
	}

	function getAllWarnaInfo($id,$coy='100')
	{
		$this->db->where('wrnckdcoy', $coy);
		$this->db->where('wrnckdwarna', $id);
		return $this->db->get('dtbwarna')->row();
    }
    
	function getAllWarnaById($id,$coy='100')
	{
		$this->db->where('wrnckdcoy', $coy);
		$this->db->where('wrnckdwarna', $id);
		return $this->db->get('dtbwarna');
    }
    
    function getAllWarnaUseTypeInfo($id)
	{
		$this->db->where('wrnckdtype', $id);
		return $this->db->get('dtbwarna')->row();
    }

	function addWarna($warnaInfo)
	{
		$this->db->insert('dtbwarna', $warnaInfo);
		return TRUE;
	}

	function updateWarna($warnaInfo)
	{
		$this->db->where('wrnckdwarna', $warnaInfo['wrnckdwarna']);
		$this->db->update('dtbwarna', $warnaInfo);
		return TRUE;
	}
	
	function deleteWarna($warna_id, $warnaInfo)
	{
		// Don't allow the admin to be nkd_del this way				
		if ($warna_id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('wrnckdwarna', $warna_id);
			$this->db->update('dtbwarna', $warnaInfo);
			return TRUE;
		}
	}
	
	function getAssignedInterior($colorcode)
	{
		$sql = "SELECT wrickdwrnint, wricnmwrnint " 
				."FROM dtbwrnint "
				. "WHERE nkd_del=0 AND wricstatus='00'"
				. "AND wrickdwrnint IN "
				. "(SELECT iwrckdwrnint FROM dtbintwrn WHERE iwrckdwarna='"
				. $colorcode . "')";
		
		$query = $this->db->query($sql);
		
		return $query;		
    }
    
    function getNotAssignedInterior($colorcode)
	{
		$sql = "SELECT wrickdwrnint, wricnmwrnint " 
				."FROM dtbwrnint "
				. "WHERE nkd_del=0 AND wricstatus='00'"
				. "AND wrickdwrnint NOT IN "
				. "(SELECT iwrckdwrnint FROM dtbintwrn WHERE iwrckdwarna='"
				. $colorcode . "')";
		
		$query = $this->db->query($sql);
		
		return $query;		
    }
	
	
	
	
	//Android	//17 Maret 2017
	function getAllWarnaTipeLabelValue($tipe,$coy='100')
	{
		$this->db->select('wartipeckdcoy,wartipeckdtipe,wartipeckdwarna,wartipecnmwartipe');
		$this->db->where('nkd_del', 0);
		$this->db->where('cstatus','00');
		$this->db->where('wartipeckdtipe',$tipe);
		$this->db->where('wartipeckdcoy',$coy);
		$this->db->orderby('wartipeckdwarna', 'asc');
		return $this->db->get('dtbwarnatipe');
	}
	
	//Android by Dian on 2017-03-17
	function getWarnaName($kode_color,$coy='100')
	{
		if(!empty($kode_color)){
			$this->db->select('wrnckdwarna, wrncnmwarna, wrncnmwarpol');
			$this->db->where('wrnckdwarna',$kode_color);
			$this->db->where('wrnckdcoy',$coy);
			$nama = $this->db->get('dtbwarna')->row();
			return isset($nama->wrncnmwarna)?$nama->wrncnmwarna.' | '.$nama->wrncnmwarpol:'?';
		}else return '';
	}
    
	//Android by Dian on 2017-03-17
	function countAllWarnaSearchByTipe($warnaInfo)
	{
		$this->db->where('nkd_del', 0);
		//$this->db->where('wrnckdcoy', $warnaInfo['wrnckdcoy']);
		//$this->db->like('wrnckdwarna', $warnaInfo['wrnckdwarna']);
		$this->db->where('wartipeckdtipe', $warnaInfo);
		$this->db->orderby('wartipeckdwarna', 'asc');
		$query = $this->db->get('dtbwarnatipe');
		return $query->num_rows();
	}
}
?>