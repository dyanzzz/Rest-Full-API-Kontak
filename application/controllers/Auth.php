<?php
	use Restserver\Libraries\REST_Controller;
	defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH . 'libraries/REST_Controller.php';
	require APPPATH . 'libraries/Format.php';

	class Auth extends REST_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->helper('date');
			$this->load->library('encrypt');
			$this->load->model('Auth_model',"auth");
		}
		
		function login_post()
		{
			$user		= $this->post("username");
			$pass		= $this->post("password");
			$flag_app	= $this->post("flag_apps");
			$ipAddress	= $this->post("ip");
			$versiApp	= $this->post("versi");
			
			$queryAppsLog		= $this->auth->getAppsLog($flag_app)->row_array();
			$access_level		= $queryAppsLog['access_level'];
			$ulgcodeandroid		= $queryAppsLog['ulgcodeandroid'];
			$environment		= $queryAppsLog['environment'];		//1: Production - 0: Development
			$versiUpdate		= $queryAppsLog['versi_update'];
			$linkUpdate			= $queryAppsLog['link_update'];
			
			$dataUserLogin		= array(
				'username'		=> $user,
				'access_level'	=> $access_level,
				'code_counter'	=> LGLO
			);
			
			//check user active
			$queryGetUserActive	= $this->auth->getUserActive($dataUserLogin);
			$countUserActive	= $queryGetUserActive->num_rows();
			$rowGetUserActive	= $queryGetUserActive->row();
			
			//Check counterCode login
			$row_usm_login		= $this->auth->cekCounterCodeLogin($dataUserLogin)->row_array();
			$getLoginNumber		= $row_usm_login['cntccounter'];
			
			$login_result			= FALSE;
			//$response				= array();
			//$response["login"]		= array();
			
			if($countUserActive>0){
				if($versiApp == $versiUpdate){
					//foreach($queryGetUserActive->result() as $rowGetUserActive){
						$password		= $rowGetUserActive->password;
						$activestatus	= $rowGetUserActive->activestatus;
						$deleted		= $rowGetUserActive->deleted;
						
						$usercode		= $rowGetUserActive->usercode;
						$nip			= $rowGetUserActive->nip;
						$ckd_coy		= $rowGetUserActive->ckd_coy;
						$ckd_cab		= $rowGetUserActive->ckd_cab;
						$ckd_dept		= $rowGetUserActive->ckd_dept;
						$fullname		= $rowGetUserActive->fullname;
						$access_level	= $rowGetUserActive->access_level;
						$ckd_sls		= $rowGetUserActive->ckd_sls;
						$ckd_spv		= $rowGetUserActive->ckd_spv;
						$ckd_dealer		= $rowGetUserActive->ckd_dealer;
						$usm_ckdcussvc	= $rowGetUserActive->usm_ckdcussvc;
						$usm_crangka	= $rowGetUserActive->usm_crangka;
						$lastlogon4		= $rowGetUserActive->lastlogon4;
						$lastlogon3		= $rowGetUserActive->lastlogon3;
						$lastlogon2		= $rowGetUserActive->lastlogon2;
						$lastlogon1		= $rowGetUserActive->lastlogon1;
						$logincounter	= $rowGetUserActive->logincounter;
					
						$login_result	= TRUE;
						
						if($environment == "1"){
							#Production
							if($this->encrypt->decode($password) == $pass){
								if($activestatus=='ATSAC' && $deleted==0){
									$data['login'] = array(
										'usercode'			=> $usercode,
										'nip'				=> $nip,
										'company_code'		=> $ckd_coy,
										'branch_code'		=> $ckd_cab,
										'department_code'	=> $ckd_dept,
										'fullname'			=> $fullname,
										'access_level'		=> $access_level,
										'salesman_code'		=> $ckd_sls,
										'supervisor_code'	=> $ckd_spv,
										'dealer_code'		=> $ckd_dealer,
										'login_number'		=> $getLoginNumber,
										'kd_customer'		=> $usm_ckdcussvc,
										'chasis'			=> $usm_crangka
									);
									
									$data['success']		= "1";
									$data['message']		= "Login Success";
									$data['linkUpdate']		= "Update Not Available";
										
									$dataLastLogin = array(
										'usercode'		=> $usercode,
										'logged_in'		=> $login_result,
										'lastlogon'		=> date('Y-m-d H:i:s'),
										'lastlogon5'	=> $lastlogon4,
										'lastlogon4'	=> $lastlogon3,
										'lastlogon3'	=> $lastlogon2,
										'lastlogon2'	=> $lastlogon1,
										'lastlogon1'	=> date('Y-m-d H:i:s'),
										'logincounter'	=> ($logincounter + 1)
									); 
									//Update last logon & logged_in status usm_user
									$this->auth->updateLastLogin($dataLastLogin);
								
									$_usm_login	= array(
										'ulgckdcoy'			=> $ckd_coy,
										'ulgckdcab'			=> $ckd_cab,
										'ulgcuser'			=> $usercode,
										'ulgcnomor'			=> $getLoginNumber,
										'ulgcip'			=> $ipAddress,
										'ulgdtgllogin'		=> date("Y-m-d"),
										'ulgtjamlogin'		=> date("His"),
										'ulgnandroid'		=> 1,
										'ulgcodeandroid'	=> $ulgcodeandroid
									);
									//Update last logon & logged_in status usm_login
									$this->auth->insertUsmLogin($_usm_login);

									//Return Success to android App
									//array_push($response["login"], $data);
									//$response["success"] = "1";
									//$response["message"] = "Login Success";
									//$response["linkUpdate"] = "Update Not Available";
									//echo json_encode($response);
									
									//Void counter 510 
									$dataCodeCounter	= array(
										'cntckdcount'	=> LGLO,
										'cntccounter'	=> ($getLoginNumber + 1)
									);
									$this->auth->updateCodeCounter($dataCodeCounter);
									
									$this->response($data, REST_Controller::HTTP_OK);
								}else{
									//Return Failed to android App
									$this->response([
										'success' => 0,
										'message' => 'Account Not Active, Please Contact Administrator',
										'linkUpdate' => 'Update Not Available'
									], REST_Controller::HTTP_NOT_FOUND);
									
								}
							}else{
								//Return Failed to android App
								$this->response([
									'success' => 0,
									'message' => 'Password is Incorrect',
									'linkUpdate' => 'Update Not Available'
								], REST_Controller::HTTP_BAD_REQUEST);
								
							}
						}else{
							#Development
							if($activestatus=='ATSAC' && $deleted==0){
								
								$data['login'] = array(
									'usercode'			=> $usercode,
									'nip'				=> $nip,
									'company_code'		=> $ckd_coy,
									'branch_code'		=> $ckd_cab,
									'department_code'	=> $ckd_dept,
									'fullname'			=> $fullname,
									'access_level'		=> $access_level,
									'salesman_code'		=> $ckd_sls,
									'supervisor_code'	=> $ckd_spv,
									'dealer_code'		=> $ckd_dealer,
									'login_number'		=> $getLoginNumber,
									'kd_customer'		=> $usm_ckdcussvc,
									'chasis'			=> $usm_crangka
								);
								
								$data['success']		= "1";
								$data['message']		= "Login Success";
								$data['linkUpdate']		= "Update Not Available";
								
								$dataLastLogin = array(
									'usercode'			=> $usercode,
									'logged_in'			=> $login_result,
									'lastlogon'			=> date('Y-m-d H:i:s'),
									'lastlogon5'		=> $lastlogon4,
									'lastlogon4'		=> $lastlogon3,
									'lastlogon3'		=> $lastlogon2,
									'lastlogon2'		=> $lastlogon1,
									'lastlogon1'		=> date('Y-m-d H:i:s'),
									'logincounter'		=> ($logincounter + 1)
								);
								//Update last logon & logged_in status usm_user
								$this->auth->updateLastLogin($dataLastLogin);
								
								$_usm_login	= array(
									'ulgckdcoy'			=> $ckd_coy,
									'ulgckdcab'			=> $ckd_cab,
									'ulgcuser'			=> $usercode,
									'ulgcnomor'			=> $getLoginNumber,
									'ulgcip'			=> $ipAddress,
									'ulgdtgllogin'		=> date("Y-m-d"),
									'ulgtjamlogin'		=> date("His"),
									'ulgnandroid'		=> 1,
									'ulgcodeandroid'	=> $ulgcodeandroid
								);
								//Update last logon & logged_in status usm_login
								$this->auth->insertUsmLogin($_usm_login);
								
								//Return Success to android App
								//array_push($response["login"], $h);
								//$response["success"] = "1";
								//$response["message"] = "Login Success";
								//$response["linkUpdate"] = "Update Not Available";
								//echo json_encode($response);
								
								//Void counter 510
								$dataCodeCounter	= array(
									'cntckdcount'	=> LGLO,
									'cntccounter'	=> ($getLoginNumber + 1)
								);
								$this->auth->updateCodeCounter($dataCodeCounter);
								
								$this->response($data, REST_Controller::HTTP_OK);
								
							}else{
								//Return Failed to android App
								$this->response([
									'success' => 0,
									'message' => 'Account Not Active, Please Contact Administrator',
									'linkUpdate' => 'Update Not Available'
								], REST_Controller::HTTP_NOT_FOUND);
								
							}
						}
					//}
					
				}else{
					//Return Failed to android App
					$this->response([
						'success' => 3,
						'message' => "Update available now, version ".$versiUpdate,
						'linkUpdate' => $linkUpdate
					], REST_Controller::HTTP_NOT_FOUND);
				
				}
				
			}else{
				//Return Failed to android App
				$this->response([
					'success' => 0,
					'message' => 'Data Not Found, Please Contact Administrator',
					'linkUpdate' => 'Update Not Available'
				], REST_Controller::HTTP_NOT_FOUND);

			}
		}
		
		function logout_post()
		{
			$usercode 			= $this->post('usercode');
			$_login_number		= $this->post('login_number');
			
			$data_usm_user		= array(
				'logged_in'		=> false,			//set
				'usercode'		=> $usercode		//where
			);
			$this->auth->updateLogoutUsmUser($data_usm_user);
			
			$data_usm_login	  = array(
				'ulgdtgllogout'  => date("Ymd"), 	//set
				'ulgtjamlogout'  => date('His'),	//set
				'ulgcuser'		  => $usercode, 	//where
				'ulgcnomor'		  => $_login_number	//where
			);
			if($this->auth->updateLogoutUsmLogin($data_usm_login)){
				$this->response([
					'success' => 1,
					'message' => 'Logout'
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'success' => 0,
					'message' => 'Logout Failed'
				], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
		
	}
?>