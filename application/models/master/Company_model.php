<?php
class Company_model extends Model {

    function Company_model()
    {
        parent::Model();
    }

	function countAllCompany()
	{
		$this->db->where('nkd_del', 0);
		$query = $this->db->get("dtbcoy");
		return $query->num_rows();
	}
	
	function getAllCompanyList($companyInfo)
	{
		if($companyInfo['coyckdcoy'] != null && $companyInfo['coyckdcoy'] != "")
		$this->db->where('coyckdcoy', $companyInfo);
		return $this->db->get('dtbcoy')->row();
	}
	
	function countAllCompanySearch($companyInfo)
	{
		if($companyInfo['coyckdcoy'] != "") {
		
			$this->db->where('nkd_del', 0);
			$this->db->like('coyckdcoy', $companyInfo['coyckdcoy']);
			$this->db->orderby('coyckdcoy', 'asc');
			$query = $this->db->get('dtbcoy');
			return $query->num_rows();
			
		} else
			//return $this->Company_model->countAllCompany();
			return $this->countAllCompany();
	}

	function getAllCompany()
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('coycnmcoy', 'asc');
		return $this->db->get('dtbcoy');
	}
	
	
	function getCompanyNamePrint($kd)
	{
		if(!empty($kd)){
		$this->db->select('coycnmcoyprint');
		$this->db->where('coyckdcoy',$kd);		
		$nama = $this->db->get('dtbcoy')->row();
		return isset($nama->coycnmcoyprint)?$nama->coycnmcoyprint:$kd;
		}else return '';
	}
	
	function getCompanyInit($kd)
	{
		if(!empty($kd)){
		$this->db->select('coyinit');
		$this->db->where('coyckdcoy',$kd);		
		$nama = $this->db->get('dtbcoy')->row();
		return isset($nama->coyinit)?$nama->coyinit:$kd;
		}else return '';
	}
	
	function getCompanyHmc($kd)
	{
		if(!empty($kd)){
		$this->db->select('coychmc');
		$this->db->where('coyckdcoy',$kd);		
		$nama = $this->db->get('dtbcoy')->row();
		return isset($nama->coychmc)?$nama->coychmc:$kd;
		}else return '';
	}
	
	
	
	function getAllCompanyPaging($num, $offset)
	{
		$this->db->where('nkd_del', 0);
		$this->db->orderby('coyckdcoy', 'asc');
		return $this->db->get('dtbcoy', $num, $offset);
	}

	function getAllCompanyPagingSearch($companyInfo, $num, $offset)
	{

		if($companyInfo['coyckdcoy'] != "") {
		
			$this->db->where('nkd_del', 0);
			$this->db->like('coyckdcoy', $companyInfo['coyckdcoy']);
			$this->db->orderby('coyckdcoy', 'asc');
			return $this->db->get('dtbcoy', $num, $offset);

		} else
			//return $this->Company_model->getAllCompanyPaging($num, $offset);
			return Company_model::getAllCompanyPaging($num,$offset);		

	}

	function getAllCompanyInfo($id)
	{
		$this->db->where('coyckdcoy', $id);
		return $this->db->get('dtbcoy')->row();
    }

	function addCompany($companyInfo)
	{
		$this->db->insert('dtbcoy', $companyInfo);
		return TRUE;
	}

	function updateCompany($companyInfo)
	{
		$this->db->where('coyckdcoy', $companyInfo['coyckdcoy']);
		$this->db->update('dtbcoy', $companyInfo);
		return TRUE;
	}
	
	function deleteCompany($company_id, $companyInfo)
	{
		// Don't allow the admin to be nkd_del this way				
		if ($company_id === 0) {
			return FALSE;
		} else {
			// Update nkd_del field = 1
			$this->db->where('coyckdcoy', $company_id);
			$this->db->update('dtbcoy', $companyInfo);
			return TRUE;
		}
	}
	
	
	
	
	
	function getAllCompanyLabelValue()
	{
		$this->db->select('coyckdcoy, coycnmcoy');
		$this->db->where('nkd_del', 0);
		$this->db->where('coycstatus', 00);
		//if($id <> '')$this->db->where('coyckdcoy',$id);
		$this->db->orderby('coyckdcoy', 'asc');
		return $this->db->get('dtbcoy');
	}
	
	function getAllCompanyLabelValue_count()
	{
		$this->db->where('nkd_del', 0);
		$this->db->where('coycstatus', 00);
		$query	= $this->db->get('dtbcoy');
		return $query->num_rows();
	}
	
}
?>