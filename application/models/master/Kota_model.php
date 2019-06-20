<?php
	class Kota_model extends Model 
	{

		function Kota_model()
		{
			parent::Model();
		}
		
		function countAllKota()
		{
			$this->db->where('nkd_del', 0);
			$query = $this->db->get("dtbkota");
			return $query->num_rows();
		}
		
		function getAllKotaLabelValueByProp($prop)
		{
			$this->db->select('kotckdkota, kotcnmkota, kotckdprop');
			$this->db->where('nkd_del', 0);
			$this->db->where('kotcstatus', '00');
			$this->db->where('kotckdprop', $prop);
			$this->db->orderby('kotcnmkota', 'asc');		
			return $this->db->get('dtbkota');
		}
		
		function getAllKotaInfo($id)
		{
			$this->db->where('nkd_del', 0);
			$this->db->where('kotckdkota', $id);
			return $this->db->get('dtbkota')->row();
		}

		function getKodePropKota($kdkota)
		{
			if(!empty($kdkota)){
				$this->db->select('kotckdprop');
				$this->db->where('kotckdkota', $kdkota);
				$query = $this->db->get('dtbkota')->row();
				return isset($query->kotckdprop)?$query->kotckdprop:'';
			}else return $kdkota;
		}
		
		
		
		
		//Android by Dian on 2017-07-20
		function countAllKotaSearch($search_value)
		{
			/* $this->db->where('nkd_del', 0);
			$this->db->like('kotcnmkota', $search_value);
			$this->db->orderby('kotcnmkota', 'asc');
			$this->db->offset($offset);
			$this->db->limit($limit);
			$query = $this->db->get('dtbkota');
			return $query->num_rows(); */
			
			$this->db->from('dtbkota a');
			$this->db->join('dtbprop b', 'b.prickdprop = a.kotckdprop');
			$this->db->like('a.kotcnmkota', $search_value);
			$this->db->or_like('b.pricknmprop', $search_value);
			$this->db->where('a.kotcstatus', '00');
			$this->db->where('a.nkd_del', 0);
			$this->db->where('b.nkd_del', 0);
			
			$query	= $this->db->get();
			return $query->num_rows();
		}
		
		//Android by Dian on 2017-07-20
		function getAllKota()
		{
			$this->db->where('nkd_del', 0);
			$this->db->orderby('kotcnmkota', 'asc');		
			return $this->db->get('dtbkota');

		}
		
		//Android by Dian on 2017-03-08
		function getKotaKd($name)
		{
			if(!empty($name)){
				$this->db->select('kotckdkota');
				$this->db->where('kotcnmkota',trim($name));		
				$kd = $this->db->get('dtbkota')->row();
				return isset($kd->kotckdkota)?$kd->kotckdkota:$name;
			}else return '';
		}
		
		//Android by Dian on 2017-03-08
		function getKotaName($kd)
		{
			if(!empty($kd)){
				$this->db->select('kotcnmkota');
				$this->db->where('kotckdkota', trim($kd));		
				$nama = $this->db->get('dtbkota')->row();
				return isset($nama->kotcnmkota)?$nama->kotcnmkota:$kd;
			}else return '';
		}

		//Android by Dian on 2017-07-20
		function getAllKotaLabelValue($search_value, $offset, $limit)
		{
			/* $this->db->select('kotckdkota, kotcnmkota, kotckdprop');
			$this->db->where('nkd_del', 0);
			$this->db->like('kotcnmkota', $search_value);
			$this->db->where('kotcstatus', '00');
			$this->db->orderby('kotcnmkota', 'asc');
			$this->db->offset($offset);
			$this->db->limit($limit);
			return $this->db->get('dtbkota'); */
			
			$this->db->select('a.*');
			$this->db->from('dtbkota a');
			$this->db->join('dtbprop b', 'b.prickdprop = a.kotckdprop');
			$this->db->like('a.kotcnmkota', $search_value);
			$this->db->or_like('b.pricknmprop', $search_value);
			$this->db->where('a.kotcstatus', '00');
			$this->db->where('a.nkd_del', 0);
			$this->db->where('b.nkd_del', 0);
			$this->db->order_by('a.kotcnmkota','asc');
			$this->db->offset($offset);
			$this->db->limit($limit);
			
			$query	= $this->db->get();
			return $query;
		}
		
	}
?>
