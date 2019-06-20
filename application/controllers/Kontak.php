<?php
	use Restserver\Libraries\REST_Controller;
	defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH . 'libraries/REST_Controller.php';
	require APPPATH . 'libraries/Format.php';

	class Kontak extends REST_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model("Kontak_model", "kontak");
		}
  
		function index_get()
		{
			$id = $this->get('id');
			if($id == ''){
				$kontak = $this->kontak->getKontak();
			}else{
				$kontak = $this->kontak->getKontak($id);
			}

			if($kontak){
				$this->response([
					'status' => true,
					'result' => $kontak,
					'message' => "Display Kontak."
				], 200);
			}else{
				$this->response([
					'status' => false,
					'result' => '0',
					'message' => "Data not found"
				], 502);
			}
			
		}
		
		function index_post(){
			$data = [
				'id'=>$this->post('id'),
				'nama'=>$this->post('nama'),
				'nomor'=>$this->post('nomor')
			];

			if($this->kontak->createKontak($data) > 0){
				$this->response([
					'status' => true,
					'message' => "new kontak has been created oke."
				], 200);
			}else{
				$this->response([
					'status' => false,
					'message' => 'failed to create new data!'
				], 502);
			}
		}
		
		function index_put(){
			$id = $this->put('id');
			$data = [
				'id'=>$this->put('id'),
				'nama'=>$this->put('nama'),
				'nomor'=>$this->put('nomor')
			];

			if($this->kontak->updateKontak($data, $id) > 0){
				$this->response([
					'status' => true,
					'message' => "data mahasiswa has been updated."
				], 200);
			}else{
				$this->response([
					'status' => false,
					'message' => 'failed to update data!'
				], 502);
			}
		}
		
		function index_delete()
		{
			$id = $this->delete('id');
			if($id === null){
				$this->response([
					'status' => false,
					'message' => 'provide an id!'
				], 502);
			}else{
				if($this->kontak->deleteKontak($id) > 0){
					//ok
					$this->response([
						'status' => true,
						'message' => "deleted."
					], 201);
				} else {
					//not found
					$this->response([
						'status' => false,
						'message' => 'id not found!'
					], 502);
				}
			}
		}
		
		
		
	}
?>