<?php
class CustomerService_model extends Model {

    function CustomerService_model()
    {
        parent::Model();
    }

	function countAllCustomerService()
	{
		$this->db->where('nkd_del', 0);
		$query = $this->db->get("dtbcussvc");
		return $query->num_rows();
	}

	function countAllCustomerServiceSearch($customerserviceInfo)
	{
		$this->db->where('nkd_del', 0);
		if(!empty($customerserviceInfo['csvckdcoy']))$this->db->where('csvckdcoy', $customerserviceInfo['csvckdcoy']);
		if(!empty($customerserviceInfo['csvckdcab']))$this->db->where('csvckdcab', $customerserviceInfo['csvckdcab']);
		if(!empty($customerserviceInfo['csvckdcust']))$this->db->like('csvckdcust', $customerserviceInfo['csvckdcust']);
		if(!empty($customerserviceInfo['csvcnmcust']))$this->db->like('csvcnmcust', $customerserviceInfo['csvcnmcust']);
		if(!empty($customerserviceInfo['csvcrangka']))$this->db->like('csvcrangka', $customerserviceInfo['csvcrangka']);
		if(!empty($customerserviceInfo['csvcmesin']))$this->db->like('csvcmesin', $customerserviceInfo['csvcmesin']);
		if(!empty($customerserviceInfo['csvcnopolisi']))$this->db->like('csvcnopolisi', $customerserviceInfo['csvcnopolisi']);
		
		$this->db->orderby('csvckdcoy', 'asc');
		$this->db->orderby('csvckdcab', 'asc');
		$this->db->orderby('csvckdcust', 'asc');
		$query = $this->db->get('dtbcussvc');
		return $query->num_rows();
	}
	
	function countAllCustomerPartSearch($customerserviceInfo)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('cprckdcoy', $customerserviceInfo['cprckdcoy']);
		$this->db->where('cprckdcab', $customerserviceInfo['cprckdcab']);
		if(isset($customerserviceInfo['cprckdcust']))$this->db->like('cprcnmcust', $customerserviceInfo['cprckdcust']);
		$this->db->orderby('cprckdcoy', 'asc');
		$this->db->orderby('cprckdcab', 'asc');
		$this->db->orderby('cprckdcust', 'asc');
		$query = $this->db->get('dtbcuspart');
		return $query->num_rows();
	}
	
	function countAllCustomerPartSearchByQuery($customerserviceInfo)
	{
		$sql = "SELECT * FROM `dtbcuspart`" .
				" WHERE `nkd_del` = 0 AND cprckdcoy='".$customerserviceInfo['cprckdcoy']."' AND cprckdcab='".$customerserviceInfo['cprckdcab']."'" .
				" AND (`cprckdcust` LIKE '". $customerserviceInfo['cprckdcust'] ."%' OR `cprcnmcust` LIKE '". $customerserviceInfo['cprckdcust'] ."%')" .
				" ORDER BY `cprckdcust` asc";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function getCustomerServiceName($customerserviceInfo)
	{
		if(is_array($customerserviceInfo)){
			if(!empty($customerserviceInfo['csvckdcoy']))$this->db->where('csvckdcoy', $customerserviceInfo['csvckdcoy']);
			if(!empty($customerserviceInfo['csvckdcab']))$this->db->where('csvckdcab', $customerserviceInfo['csvckdcab']);
			$this->db->where('csvckdcust', $customerserviceInfo['csvckdcust']);
			$this->db->where('csvnstatus', 1);#added 2012-12-17
		}else $this->db->where('csvckdcust', $customerserviceInfo);
		$nama = $this->db->get('dtbcussvc');
		foreach ($nama->result() as $nm):
			return !empty($nm->csvcnmcust)?$nm->csvcnmcust:$customerserviceInfo['csvckdcust'];
		endforeach;
	}
	
	/*this function to get field dinamis*/
	function getCustomerServiceFieldName($kd, $tbl, $field, $select, $num=1)
	{
		if(!empty($kd)){
		$this->db->select($field);
		$this->db->where($select,$kd);		
		$this->db->limit($num);		
		$nama = $this->db->get($tbl)->row();
		return isset($nama->$field)?$nama->$field:'';
		}else return '';
	}
	
	function getCustomerPartName($customerserviceInfo)
	{
		if(is_array($customerserviceInfo)){
			if(!empty($customerserviceInfo['cprckdcoy']))$this->db->where('cprckdcoy', $customerserviceInfo['cprckdcoy']);
			if(!empty($customerserviceInfo['cprckdcab']))$this->db->where('cprckdcab', $customerserviceInfo['cprckdcab']);
			$this->db->where('cprckdcust', $customerserviceInfo['cprckdcust']);
		}else $this->db->where('cprckdcust', $customerserviceInfo);
		$nama = $this->db->get('dtbcuspart');
		foreach ($nama->result() as $nm):
			return $nm->cprcnmcust;
		endforeach;
	}
	
	function getCustomerServiceAddress($customerserviceInfo)
	{
		if(is_array($customerserviceInfo)){
			if(!empty($customerserviceInfo['csvckdcoy']))$this->db->where('csvckdcoy', $customerserviceInfo['csvckdcoy']);
			if(!empty($customerserviceInfo['csvckdcab']))$this->db->where('csvckdcab', $customerserviceInfo['csvckdcab']);
			$this->db->where('csvckdcust', $customerserviceInfo['csvckdcust']);
		}else $this->db->where('csvckdcust', $customerserviceInfo);
		$nama = $this->db->get('dtbcussvc');
		foreach ($nama->result() as $nm):
			return $nm->csvcadcust1;
		endforeach;
	}
	
	function getCustomerPartAddress($customerserviceInfo)
	{
		if(is_array($customerserviceInfo)){
			if(!empty($customerserviceInfo['cprckdcoy']))$this->db->where('cprckdcoy', $customerserviceInfo['cprckdcoy']);
			if(!empty($customerserviceInfo['cprckdcab']))$this->db->where('cprckdcab', $customerserviceInfo['cprckdcab']);
			$this->db->where('cprckdcust', $customerserviceInfo['cprckdcust']);
		}else $this->db->where('cprckdcust', $customerserviceInfo);
		$nama = $this->db->get('dtbcuspart');
		foreach ($nama->result() as $nm):
			return $nm->cprcadcust1;
		endforeach;
	}

	function getAllCustomerServiceUnit($customerserviceInfo,$nstatus=1)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('csvnstatus', $nstatus); //flag pemilik terbaru 29-09-2009
		if($customerserviceInfo['csvcrangka']="-") $this->db->where('csvcrangka', $customerserviceInfo['csvcrangka']);
		if($customerserviceInfo['csvcmesin']="-") $this->db->where('csvcmesin', $customerserviceInfo['csvcmesin']);
		if($customerserviceInfo['csvcnopolisi']="-")$this->db->where('csvcnopolisi', $customerserviceInfo['csvcnopolisi']);
		return $this->db->get('dtbcussvc');	
	}
	
	function getAllCustomerServiceUnitNew($customerserviceInfo,$nstatus=1)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('csvnstatus', $nstatus); //flag pemilik terbaru 29-09-2009
		if(!empty($customerserviceInfo['csvcrangka'])) $this->db->where('csvcrangka', $customerserviceInfo['csvcrangka']);
		if(!empty($customerserviceInfo['csvcmesin'])) $this->db->where('csvcmesin', $customerserviceInfo['csvcmesin']);
		if(!empty($customerserviceInfo['csvcnopolisi']))$this->db->where('csvcnopolisi', $customerserviceInfo['csvcnopolisi']);
		return $this->db->get('dtbcussvc');	
	}
	
	function getAllCustomerServiceUnitByStatus($customerserviceInfo)
	{
		$this->db->where('nkd_del', 0);
		if($customerserviceInfo['csvcrangka']!="") $this->db->where('csvcrangka', $customerserviceInfo['csvcrangka']);
		if($customerserviceInfo['csvcmesin']!="") $this->db->where('csvcmesin', $customerserviceInfo['csvcmesin']);
		if($customerserviceInfo['csvcnopolisi']!="")$this->db->where('csvcnopolisi', $customerserviceInfo['csvcnopolisi']);
		return $this->db->get('dtbcussvc');	
	}
	
	function getCustomerServiceByCoyCab($customerserviceInfo)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('csvckdcoy', $customerserviceInfo['csvckdcoy']);
		$this->db->where('csvckdcab', $customerserviceInfo['csvckdcab']);
		return $this->db->get('dtbcussvc')->row();
	}
		
	function getAllCustomerService($customerserviceInfo)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('csvckdcoy', $customerserviceInfo['csvckdcoy']);
		$this->db->like('csvckdcab', $customerserviceInfo['csvckdcab']);
		$this->db->orderby('csvckdcust', 'asc');
		return $this->db->get('dtbcussvc');
	}

	function getAllCustomerServiceLabelValue($customerserviceInfo)
	{
		$this->db->select('csvckdcust, csvcnmcust');
		$this->db->where('nkd_del', 0);
		$this->db->where('csvcstatus', '00');
		$this->db->where('csvckdcoy', $customerserviceInfo['csvckdcoy']);
		$this->db->where('csvckdcab', $customerserviceInfo['csvckdcab']);
		$this->db->orderby('csvckdcoy', 'asc');
		$this->db->orderby('csvckdcab', 'asc');		
		$this->db->orderby('csvcnmcust', 'asc');
		return $this->db->get('dtbcussvc');
	}
	
	function getAllCustomerPartLabelValue($customerserviceInfo)
	{
		$this->db->select('cprckdcust, cprcnmcust');
		$this->db->where('nkd_del', 0);
		$this->db->where('cprnstatus', 1);
		$this->db->where('cprckdcoy', $customerserviceInfo['csvckdcoy']);
		$this->db->where('cprckdcab', $customerserviceInfo['csvckdcab']);
		$this->db->orderby('cprcnmcust', 'asc');
		return $this->db->get('dtbcuspart');
	}
	
	function getAllCustomerServicePaging($customerserviceInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->like('csvckdcoy', $customerserviceInfo['csvckdcoy']);
		$this->db->like('csvckdcab', $customerserviceInfo['csvckdcab']);
		$this->db->like('csvckdcust', $customerserviceInfo['csvckdcust']);
		
		$this->db->orderby('csvckdcoy', 'asc');
		$this->db->orderby('csvckdcab', 'asc');	
		$this->db->orderby('csvckdcust', 'asc');
		return $this->db->get('dtbcussvc', $num, $offset);
	}

	function getAllCustomerServicePagingSearch($customerserviceInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		if(!empty($customerserviceInfo['csvckdcoy']))$this->db->where('csvckdcoy', $customerserviceInfo['csvckdcoy']);
		if(!empty($customerserviceInfo['csvckdcab']))$this->db->where('csvckdcab', $customerserviceInfo['csvckdcab']);
		if(!empty($customerserviceInfo['csvckdcust']))$this->db->like('csvckdcust', $customerserviceInfo['csvckdcust']);
		if(!empty($customerserviceInfo['csvcnmcust']))$this->db->like('csvcnmcust', $customerserviceInfo['csvcnmcust']);
		if(!empty($customerserviceInfo['csvcrangka']))$this->db->like('csvcrangka', $customerserviceInfo['csvcrangka']);
		if(!empty($customerserviceInfo['csvcmesin']))$this->db->like('csvcmesin', $customerserviceInfo['csvcmesin']);
		if(!empty($customerserviceInfo['csvcnopolisi']))$this->db->like('csvcnopolisi', $customerserviceInfo['csvcnopolisi']);
		
		$this->db->orderby('csvckdcoy', 'asc');
		$this->db->orderby('csvckdcab', 'asc');	
		$this->db->orderby('csvckdcust', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		return $this->db->get('dtbcussvc');
		//print_r($this->db->last_query());
	}
	
	function getAllCustomerPartPagingSearch($customerserviceInfo, $num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('cprckdcoy', $customerserviceInfo['cprckdcoy']);
		$this->db->where('cprckdcab', $customerserviceInfo['cprckdcab']);
		if(isset($customerserviceInfo['cprckdcust']))$this->db->like('cprckdcust', $customerserviceInfo['cprckdcust']);
				
		$this->db->orderby('cprckdcoy', 'asc');
		$this->db->orderby('cprckdcab', 'asc');	
		$this->db->orderby('cprckdcust', 'asc');
		$this->db->offset($offset);
		$this->db->limit($num);
		return $this->db->get('dtbcuspart');
	}
	
	function getAllCustomerPartLabelValuePagingSearch($customerserviceInfo, $num, $offset)
	{
		$sql = "SELECT * FROM `dtbcuspart`" .
				" WHERE `nkd_del` = 0 AND cprckdcoy='".$customerserviceInfo['cprckdcoy']."' AND cprckdcab='".$customerserviceInfo['cprckdcab']."'" .
				" AND (`cprckdcust` LIKE '". $customerserviceInfo['cprckdcust'] ."%' OR `cprcnmcust` LIKE '". $customerserviceInfo['cprckdcust'] ."%')" .
				" ORDER BY `cprckdcust` asc" .
				" LIMIT ".$offset.",".$num;
		return $this->db->query($sql);
	}
	
    function getAllCustomerServiceInfoByChasis($customerserviceInfo)
	{
		$this->db->where('csvcrangka', $customerserviceInfo['csvcrangka']);
		return $this->db->get('dtbcussvc')->row();
    }
    
	function getAllCustomerServiceInfoByEngine($customerserviceInfo)
	{
		$this->db->where('csvcmesin', $customerserviceInfo['csvcmesin']);
		return $this->db->get('dtbcussvc')->row();
    }
    
	function getAllCustomerServiceInfoByNopol($customerserviceInfo)
	{
		$this->db->where('csvcnopolisi', $customerserviceInfo['csvcnopolisi']);
		return $this->db->get('dtbcussvc')->row();
    }
    
	function getAllCustomerServiceInfoBYCoyOnly($customerserviceInfo)
	{
		if(!empty($customerserviceInfo['csvckdcoy']))$this->db->where('csvckdcoy', $customerserviceInfo['csvckdcoy']);
		if(!empty($customerserviceInfo['csvckdcust']))$this->db->where('csvckdcust', $customerserviceInfo['csvckdcust']);
		$this->db->limit(1);
		return $this->db->get('dtbcussvc')->row();
    }
    
    function getAllCustomerServiceInfoBYCustomerCode($customerserviceInfo)
	{
		$this->db->where('csvckdcust', $customerserviceInfo['csvckdcust']);
		$this->db->limit(1);
		return $this->db->get('dtbcussvc')->row();
    }
    
    function getAllCustomerPartInfo($customerserviceInfo)
	{
		if(!empty($customerserviceInfo['cprckdcoy']))$this->db->where('cprckdcoy', $customerserviceInfo['cprckdcoy']);
		if(!empty($customerserviceInfo['cprckdcab']))$this->db->where('cprckdcab', $customerserviceInfo['cprckdcab']);
		if(!empty($customerserviceInfo['cprckdcust']))$this->db->where('cprckdcust', $customerserviceInfo['cprckdcust']);
		return $this->db->get('dtbcuspart')->row();
    }
    
    function getAllCustomerServiceInfoNoParm($id,$cab=null)
	{
		$this->db->where('csvckdcust', $id);
		if(!empty($cab))$this->db->where('csvckdcab', $cab);		
		$query = $this->db->get('dtbcussvc')->row();
		//print_r($this->db->last_query());
		return $query;
    }
	
	#tri @09-04-2012
    function countAllCustomerServiceByQuerySearch($customerserviceInfo)
	{
		$sql = "SELECT * FROM dtbcussvc " .
				"WHERE nkd_del=0 AND csvckdcoy='".$customerserviceInfo['csvckdcoy']."' AND csvckdcab='".$customerserviceInfo['csvckdcab']."'";
		$sql .=	"AND (csvckdcust LIKE '%".$customerserviceInfo['csvckdcust']."%' OR csvcrangka LIKE  '%".$customerserviceInfo['csvckdcust']."%' OR csvcmesin LIKE  '%".$customerserviceInfo['csvckdcust']."%' OR csvcnopolisi LIKE  '%".$customerserviceInfo['csvckdcust']."%' OR csvcnmcust LIKE  '%".$customerserviceInfo['csvckdcust']."%')";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	#tri @09-04-2012
	function getAllCustomerServiceBYQueryPagingSearch($customerserviceInfo, $num=100, $offset=10)
	{
	if(empty($num))
			$num=100;
		if(empty($offset))
			$offset=0;
		$sql = "SELECT * FROM dtbcussvc ".
				"WHERE nkd_del=0 AND csvckdcoy='".$customerserviceInfo['csvckdcoy']."' AND csvckdcab='".$customerserviceInfo['csvckdcab']."'";
		$sql .="AND (csvckdcust LIKE '%".$customerserviceInfo['csvckdcust']."%' OR csvcrangka LIKE  '%".$customerserviceInfo['csvckdcust']."%' OR csvcmesin LIKE  '%".$customerserviceInfo['csvckdcust']."%' OR csvcnopolisi LIKE  '%".$customerserviceInfo['csvckdcust']."%' OR csvcnmcust LIKE  '%".$customerserviceInfo['csvckdcust']."%')LIMIT ".$num." OFFSET ".$offset."";
		$query = $this->db->query($sql);
		return $query;
	}

	function addCustomerService($customerserviceInfo)
	{
		if($this->db->insert('dtbcussvc', $customerserviceInfo))return true; else return false;		
	}
	
	function addCustomerServiceMnt($customerserviceInfo)
	{
		if($this->db->insert('dtbcusmtnc', $customerserviceInfo))return true; else return false;		
	}

	function updateCustomerService($customerserviceInfo)
	{
		$this->db->where('csvckdcoy', $customerserviceInfo['csvckdcoy']);
		if(!empty($customerserviceInfo['csvckdcab']))$this->db->where('csvckdcab', $customerserviceInfo['csvckdcab']);
		$this->db->where('csvckdcust', $customerserviceInfo['csvckdcust']);
		if($this->db->update('dtbcussvc', $customerserviceInfo)) return true; else return false;		
	}
	
	function updateCustomerServiceNew($customerserviceInfo)
	{
		if(!empty($customerserviceInfo['csvcmesin']))$this->db->where('csvcmesin', $customerserviceInfo['csvcmesin']);
		$this->db->where('csvckdcust', $customerserviceInfo['csvckdcust']);
		if($this->db->update('dtbcussvc', $customerserviceInfo)) return true; else return false;		
	}
	
	function updateCustomerServiceById($customerserviceInfo)
	{
		/* papanyaraka, Des 14th 2009
		 * update customer by id -> used by workorder to prevent duplicated id
		 * */
		$this->db->where('csvckdcust', $customerserviceInfo['csvckdcust']);
		return $this->db->update('dtbcussvc', $customerserviceInfo);		
	}
	
	function updateCustomerServiceByEngineOnly($customerserviceInfo)
	{
		$this->db->where('csvcmesin', $customerserviceInfo['csvcmesin']);
		if($this->db->update('dtbcussvc', $customerserviceInfo)) return true; else return false;
		
	}
	
	function deleteCustomerService($customerserviceInfo)
	{
		$customerserviceInfo['nkd_del']=1;
		
		$this->db->where('csvckdcoy', $customerserviceInfo['csvckdcoy']);
		$this->db->where('csvckdcab', $customerserviceInfo['csvckdcab']);
		$this->db->where('csvckdcust', $customerserviceInfo['csvckdcust']);
		
		return $this->db->update('dtbcussvc', $customerserviceInfo);
	}

	function getAllCustomerServiceUnitSvcRepair($customerserviceInfo, $nstatus=1, $lim=null)
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('csvnstatus', $nstatus); //flag pemilik terbaru 29-09-2009
		if($customerserviceInfo['csvcrangka']!="-") $this->db->where('csvcrangka', $customerserviceInfo['csvcrangka']);
		if($customerserviceInfo['csvcmesin']!="-") $this->db->where('csvcmesin', $customerserviceInfo['csvcmesin']);
		if($customerserviceInfo['csvcnopolisi']!="-")$this->db->where('csvcnopolisi', $customerserviceInfo['csvcnopolisi']);
		$this->db->orderby('csvcnowo', 'desc');
		if(!empty($lim))$this->db->limit($lim);
		return $this->db->get('dtbcussvc');	
	}
	
	function getAllCustomerServiceUnitSvcRepair2($customerserviceInfo, $nstatus=1, $lim=null)
	{
		$sql = "SELECT * FROM dtbcussvc INNER JOIN dtsvcunitassign ON(asgicrangka=csvcrangka) WHERE nkd_del=0 AND csvnstatus=$nstatus ";
		if(($customerserviceInfo['csvcrangka']!="-"))$sql .= " AND csvcrangka='".$customerserviceInfo['csvcrangka']."' ";
		if(($customerserviceInfo['csvcmesin']!="-"))$sql .= " AND csvcmesin='".$customerserviceInfo['csvcmesin']."' ";
		if(($customerserviceInfo['csvcnopolisi']!="-"))$sql .= " AND csvcnopolisi='".$customerserviceInfo['csvcnopolisi']."' ";
		$sql .= " ORDER BY csvcnowo LIMIT $lim";
		return $this->db->query($sql);
	}
	
	
	
	
	
	
	
	
	function getAllCustomerServiceInfo($customerserviceInfo, $nstatus=1)	//service history, booking service
	{
		if(!empty($customerserviceInfo['csvckdcust']))$this->db->where('csvckdcust', $customerserviceInfo['csvckdcust']);
		if(!empty($customerserviceInfo['csvcmesin']))$this->db->where('csvcmesin', $customerserviceInfo['csvcmesin']);
		if(!empty($customerserviceInfo['csvcrangka']))$this->db->where('csvcrangka', $customerserviceInfo['csvcrangka']);
		if(!empty($customerserviceInfo['csvcnopolisi']))$this->db->where('csvcnopolisi', $customerserviceInfo['csvcnopolisi']);
		$this->db->where('csvnstatus', $nstatus);
		$this->db->where('nkd_del', 0);
		return $this->db->get('dtbcussvc');
    }
	
	function countCustomerSearch($customerserviceInfo, $nstatus=1)	//android
	{
		$this->db->where('nkd_del', 0);
		if(!empty($customerserviceInfo['csvcrangka']))$this->db->like('csvcrangka', $customerserviceInfo['csvcrangka']);
		if(!empty($customerserviceInfo['csvcmesin']))$this->db->like('csvcmesin', $customerserviceInfo['csvcmesin']);
		if(!empty($customerserviceInfo['csvcnopolisi']))$this->db->like('csvcnopolisi', $customerserviceInfo['csvcnopolisi']);
		if(!empty($customerserviceInfo['csvcnmcust']))$this->db->like('csvcnmcust', $customerserviceInfo['csvcnmcust']);
		$this->db->where('csvnstatus', $nstatus);
		$query = $this->db->get('dtbcussvc');
		return $query->num_rows();
	}
	
	function getCustomerCode($customerserviceInfo, $nstatus=1)	//android for get ckdcust
	{
		$this->db->where('csvcrangka', $customerserviceInfo);
		$this->db->where('csvnstatus', $nstatus);
		return $this->db->get('dtbcussvc')->row();
    }
	
	function countCustomerCode($customerserviceInfo, $nstatus=1)	//android for get ckdcust
	{
		$this->db->where('csvcrangka', $customerserviceInfo);
		$this->db->where('csvnstatus', $nstatus);
		$query = $this->db->get('dtbcussvc');
		return $query->num_rows();
    }
	
	function updatePhoneCustomerService($kd_customer, $phone, $email){
		$this->db->set('csvcnohp3', $phone, FALSE);
		$this->db->set('csvcemail2', $email, FALSE);
		$this->db->where('csvckdcust', $kd_customer);
		return $this->db->update('dtbcussvc');
	}
	
	
	
	
}
?>