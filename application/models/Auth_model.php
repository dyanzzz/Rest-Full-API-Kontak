<?php
	class Auth_model extends CI_Model
	{
		
		function getAppsLog($flag_app)
		{
			$this->db->where('delete', 0);
			$this->db->where('active', 1);
			$this->db->where('flag_app', $flag_app);
			$query = $this->db->get('dtbappslog');
			return $query;
		}
		
		function getUserActive($dataAppsLog)
		{
			$this->db->where('usercode',$dataAppsLog['username']);
			$this->db->where("activestatus='ATSAC'" .$dataAppsLog['access_level']);
			$query = $this->db->get('usm_user');
			return $query;
		}
		
		function cekCounterCodeLogin($dataAppsLog)
		{
			$this->db->where('cntckdcount',$dataAppsLog['code_counter']);
			$query = $this->db->get('dtbcount');
			return $query;
		}
		
		function updateLastLogin($dataLastLogin)
		{
			$this->db->where('usercode', $dataLastLogin['usercode']);
			$this->db->set('logged_in', $dataLastLogin['logged_in']);
			$this->db->set('lastlogon', $dataLastLogin['lastlogon']);
			$this->db->set('lastlogon5', $dataLastLogin['lastlogon5']);
			$this->db->set('lastlogon4', $dataLastLogin['lastlogon4']);
			$this->db->set('lastlogon3', $dataLastLogin['lastlogon3']);
			$this->db->set('lastlogon2', $dataLastLogin['lastlogon2']);
			$this->db->set('lastlogon1', $dataLastLogin['lastlogon1']);
			$this->db->set('logincounter', $dataLastLogin['logincounter']);
			$query = $this->db->update('usm_user', $dataLastLogin);
			return $query;
		}
		
		function insertUsmLogin($_usm_login)
		{
			$query = $this->db->insert('usm_login', $_usm_login);
			return $query;
		}
		
		function updateCodeCounter($dataCodeCounter)
		{
			$this->db->where('cntckdcount', $dataCodeCounter['cntckdcount']);
			$this->db->set('cntccounter', $dataCodeCounter['cntccounter']);
			$query = $this->db->update('dtbcount', $dataCodeCounter);
			return $query;
		}
		
		function updateLogoutUsmUser($data_usm_user)
		{
			$this->db->where('usercode', $data_usm_user['usercode']);
			$this->db->set('logged_in', $data_usm_user['logged_in']);
			$query = $this->db->update('usm_user', $data_usm_user);
			return $query;
		}
		
		function updateLogoutUsmLogin($data_usm_login)
		{
			$this->db->where('ulgcuser', $data_usm_login['ulgcuser']);
			$this->db->where('ulgcnomor', $data_usm_login['ulgcnomor']);
			$this->db->set('ulgdtgllogout', $data_usm_login['ulgdtgllogout']);
			$this->db->set('ulgtjamlogout', $data_usm_login['ulgtjamlogout']);
			$query = $this->db->update('usm_login', $data_usm_login);
			return $query;
		}
		
	}
?>