<?php
class MasterStock_model extends Model {

    function MasterStock_model()
    {
        parent::Model();
    }
	
	function setAllowedCoy($allowedcoy){ //convert arrayobject $allowedcoy into string separated by comma
		$coylist='';
		foreach($allowedcoy as $coy):
			if($coylist=='')$coylist="'".$coy->coyckdcoy."'"; else $coylist = $coylist.','."'".$coy->coyckdcoy."'";
		endforeach; 	
		return $coylist;
	}
	
	function setAllowedCab($allowedcab){ //convert arrayobject $allowedcab into string separated by comma
		$cablist='';
		foreach($allowedcab as $cab):
			if($cablist=='')$cablist="'".$cab->cabckdcab."'"; else $cablist = $cablist.','."'".$cab->cabckdcab."'";
		endforeach; 	
		return $cablist;
	}
	
	function setAllowedCabOwn($allowedcab){ //convert arrayobject $allowedcab into string separated by comma
		$cablist='';
		foreach($allowedcab as $cab):
			if($cablist=='')$cablist="'100','".$cab->cabckdcab."'"; else $cablist = $cablist.','."'".$cab->cabckdcab."'";
		endforeach; 	
		return $cablist;
	}
	
	function countMasterStock($MasterStockInfo)
	{
		if($MasterStockInfo['mstcoyown'] != '-')
			$this->db->where('mstcoyown', $MasterStockInfo['mstcoyown']);
		if($MasterStockInfo['mstcabown'] != '-')
			$this->db->where('mstcabown', $MasterStockInfo['mstcabown']);
		if($MasterStockInfo['mstcoycons'] != '-')
			$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		if($MasterStockInfo['mstcabcons'] != '-')
			$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
			$this->db->where('mstckdtipe', $MasterStockInfo['mstckdtipe']);	
			$this->db->orderby('mstckdtipe', 'asc');
			$query = $this->db->get('dmsstokv');
		return $query->num_rows();
	}
	
	function getMasterStockVinHmc($kd,$coy='099')
	{
		if(!empty($kd)){
		$this->db->select('mstcvinhmc');
		$this->db->where('mstcrangka',$kd);	
		$nama = $this->db->get('dmsstokv')->row();
		return isset($nama->mstcvinhmc)?$nama->mstcvinhmc:$kd;
		}else return '';
	}
	
	function countMAccLsh($MasterStockInfo)
	{
		$this->db->where('mstcfisik', 'OH');
		$this->db->where('mstcproses', 'RS');
		if($MasterStockInfo['mstcoyown'] != '-')
			$this->db->where('mstcoyown', $MasterStockInfo['mstcoyown']);
		if($MasterStockInfo['mstcabown'] != '-')
			$this->db->where('mstcabown', $MasterStockInfo['mstcabown']);
		if($MasterStockInfo['mstcoycons'] != '-')
			$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		if($MasterStockInfo['mstcabcons'] != '-')
			$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		
			$this->db->where('mstckdtipe', $MasterStockInfo['mstckdtipe']);	
			$this->db->where('mstckdacsm', $MasterStockInfo['mstckdacsm']);
			$this->db->orderby('mstckdtipe', 'asc');
			$query = $this->db->get('dmsstokv');
		return $query->num_rows();
	}
	
	function getAllMasterStock($MasterStockInfo)
	{
		$this->db->like('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		$this->db->orderby('mstckdcoy', 'asc');
		$this->db->orderby('mstcrangka', 'asc');
		return $this->db->get('dmsstokv');
	}

	function getAllMasterStockPaging($MasterStockInfo, $num, $offset)
	{
		$this->db->like('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		$this->db->orderby('mstckdcoy', 'asc');
		$this->db->orderby('mstcrangka', 'asc');
		return $this->db->get('dmsstokv', $num, $offset);
	}

	function getAllTrackSpkValid($MasterStockInfo){
		if(!empty($MasterStockInfo['mstckdcoy']))$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		if(!empty($MasterStockInfo['mstcrangka']))$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		if(!empty($MasterStockInfo['mstckdtipe']))$this->db->where('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		if(!empty($MasterStockInfo['mstckdwarna']))$this->db->where('mstckdwarna', $MasterStockInfo['mstckdwarna']);
		$this->db->where('mstcproses', 'RS');
		$query = $this->db->get('dmsstokv');
		return $query->num_rows();
	}
	
	function getAllMasterStockReport($MasterStockInfo,$allowedcoy=array(),$allowedcab=array())
	{ 
		$infoStokDealer = $this->Company_model->getAllCompanyInfo(($MasterStockInfo['mstcoyown']!='-')?$MasterStockInfo['mstcoyown']:$MasterStockInfo['mstcoycons']);
		if($infoStokDealer->coynstokdlr==0)$db = 'dmsstokv';
		else $db = 'dmsstokvdlr';
		
		$coy = $this->setAllowedCoy($allowedcoy);
		$cab = $this->setAllowedCab($allowedcab);
		$cab_own = $this->setAllowedCabOwn($allowedcab);
		$sql = "SELECT mstcoycons,mstcabcons,mstckdtipe,mstcrangka,mstcmesin,mstcnoiris,mstdtgliris,mstckdwarna,mstckdacsm,mstclokasi,mstcremark,mstckondisi,mstdtgliris,mstdtgsof,mstckdacsm,datediff(curdate(),mstdtgsof) as aging_soff,datediff(curdate(),mstdtgliris) as aging_iris,mstdtgsofref FROM $db WHERE mstcfisik='OH' AND mstcproses='RS'";
				if($MasterStockInfo['mstcoyown'] != '-'){
					$sql.=" AND mstcoyown='".$MasterStockInfo['mstcoyown']."'";
				}else{$sql.=" AND mstcoyown IN (".$coy.")";}
				
				if($MasterStockInfo['mstcabown'] != '-'){
					$sql.=" AND mstcabown='".$MasterStockInfo['mstcabown']."'";
				}else{$sql.=" AND mstcabown IN (".$cab_own.")";}
				
				if($MasterStockInfo['mstcoycons'] != '-'){
					$sql.=" AND mstcoycons='".$MasterStockInfo['mstcoycons']."'";
				}else{$sql.=" AND mstcoycons IN (".$coy.")";}
				
				if($MasterStockInfo['mstcabcons'] != '-'){
					$sql.=" AND mstcabcons='".$MasterStockInfo['mstcabcons']."'";
				}else{$sql.=" AND mstcabcons IN (".$cab.")";}
			$sql .=" ORDER BY mstcoycons,mstcabcons,mstckdtipe,mstcrangka ASC ";
//			echo $sql;die();
			return $this->db->query($sql);
    }
    
    function RptDailyStock($MasterStockInfo,$allowedcoy=array(),$allowedcab=array())
	{
		$query = $this->getAllMasterStockReport($MasterStockInfo,$allowedcoy,$allowedcab);
		$datapercoy=array();
		$datapercab=array();
		$datapercat=array();
		$datapercbno=array();
		$datadetil=array();
		if($query->num_rows() > 0){			
			$cur_coy = '#';
			$cur_cab = '#';
			$cur_cat = '#';
			$cur_cbno = '#';
			$cur_macc = '#';
			$no_cb=$counter=0;
			foreach($query->result() as $row){
				$row_tipe = $this->modeltype_model->getAllmodeltypeInfo($row->mstckdtipe,$row->mstcoycons);
				$counter++;
				$irisdate = ($row->mstdtgliris=='' || $row->mstdtgliris==null || $row->mstdtgliris=='0000-00-00')?'-':$row->mstdtgliris;
				$soffdate = ($row->mstdtgsof=='' || $row->mstdtgsof==null || $row->mstdtgsof=='0000-00-00')?'-':$row->mstdtgsof;
				
				if($cur_coy != $row->mstcoycons){
					$cur_coy = $row->mstcoycons;
					$datapercoy[$row->mstcoycons]['company']=isset($row->mstcoycons)?$this->Company_model->getCompanyName($row->mstcoycons):'';
					$cur_cab = '#';
				}
				if($cur_cab != $row->mstcabcons){
					$cur_cab = $row->mstcabcons;
					$datapercab[$row->mstcabcons]['branch']=isset($row->mstcabcons)?$this->Branch_model->getBranchName($row->mstcabcons,$row->mstcoycons):'';
					$datapercab[$row->mstcabcons]['amount'] = $this->IrisHo_model->getIrisHoAmount($row->mstcnoiris);
					$datapercab[$row->mstcabcons]['total'] = 1;
					$datapercat=array();
					$cur_cat = '#';
				}else{
					$datapercab[$row->mstcabcons]['amount']+=$this->IrisHo_model->getIrisHoAmount($row->mstcnoiris);
					$datapercab[$row->mstcabcons]['total']++;
				}
				if($cur_cat != $row->mstckdtipe){
					$cur_cat = $row->mstckdtipe;
					$datapercat[$cur_cat]['category']=isset($row->mstckdtipe)?$this->modeltype_model->getModelTypeName($row->mstckdtipe,$row->mstcoycons):'';
					$datapercat[$cur_cat]['option'] = $row_tipe->tpecnmoption;
					$datapercat[$cur_cat]['amount'] = $this->IrisHo_model->getIrisHoAmount($row->mstcnoiris);
					$datapercat[$cur_cat]['subtotal'] = 1;
					$datapercbno=array();
					$cur_cbno = '#';
					$no_cb = 0;	
				}else{
					$datapercat[$cur_cat]['subtotal']++;
					$datapercat[$cur_cat]['amount']+=$this->IrisHo_model->getIrisHoAmount($row->mstcnoiris);
				}
				
				if($cur_cbno != $row->mstcrangka){
					$cur_cbno = $row->mstcrangka;				
					$no_cb++;
					$datapercbno[$row->mstcrangka]['no_urut'] = $no_cb;
					$datapercbno[$row->mstcrangka]['mstcrangka'] = isset($row->mstcrangka)?$row->mstcrangka:'';
					$datapercbno[$row->mstcrangka]['mstcmesin']=isset($row->mstcmesin)?$row->mstcmesin:'';
					$datapercbno[$row->mstcrangka]['mstcnoiris']=isset($row->mstcnoiris)?$row->mstcnoiris:'';
					$datapercbno[$row->mstcrangka]['mstdtgliris']=isset($row->mstdtgliris)?convertDate($row->mstdtgliris):'';
					$datapercbno[$row->mstcrangka]['mstdtgsofref']=isset($row->mstdtgsofref)?convertDate($row->mstdtgsofref):'';
					$datapercbno[$row->mstcrangka]['mstdtgsof']=isset($row->mstdtgsof)?convertDate($row->mstdtgsof):'';
					$datapercbno[$row->mstcrangka]['mstckdwarna']=isset($row->mstckdwarna)?$row->mstckdwarna:'';
					$datapercbno[$row->mstcrangka]['mstcnmwarna']=isset($row->mstckdwarna)?$this->Warna_model->getWarnaName($row->mstckdwarna,$row->mstcoycons):'';				
					$datapercbno[$row->mstcrangka]['mstckdacsm']=isset($row->mstckdacsm)?$row->mstckdacsm:'';
					$datapercbno[$row->mstcrangka]['mstclokasi']=isset($row->mstclokasi)?$row->mstclokasi:'';
					$datapercbno[$row->mstcrangka]['mstcremark']=isset($row->mstcremark)?$row->mstcremark:'';
					$datapercbno[$row->mstcrangka]['mstckondisi']=isset($row->mstckondisi)?$row->mstckondisi:'';
					$datapercbno[$row->mstcrangka]['aging_iris']=($irisdate=='-')?'':Aging($irisdate);
					$datapercbno[$row->mstcrangka]['aging_signof']=($soffdate=='-')?'':Aging($soffdate);
					$datapercbno[$row->mstcrangka]['amount']=isset($row->mstcnoiris)?$this->IrisHo_model->getIrisHoAmount($row->mstcnoiris):'';
					if($cur_macc != $row->mstckdacsm){
						$cur_macc = $row->mstckdacsm;
						if(!empty($row->mstckdacsm) and $row->mstckdacsm!=='-')
						$datapercbno[$row->mstcrangka]['mstsubtotal']=1;	
					}else{
						$datapercbno[$row->mstcrangka]['mstsubtotal']='';
					}
					$datadetil=array();		
					$datadetil['no_urut']=0;
				}
				
				$datapercbno[$row->mstcrangka]['detil'][$datadetil['no_urut']]=$datadetil;
				$datapercat[$row->mstckdtipe]['cat']=$datapercbno;	
				$datapercab[$row->mstcabcons]['category']=$datapercat;
				$datapercoy[$row->mstcoycons]['branch']=$datapercab;
			}
		}
		return $datapercoy;
	}
    
    function getAllMasterStockReportGrouptByType($MasterStockInfo)
	{ 
		$sql = "SELECT * FROM dmsstokv WHERE mstcfisik='OH' AND mstcproses='RS' AND mstnexport=0 ";
			if($MasterStockInfo['mstcoyown'] != '-')
				$sql.=" AND mstcoyown='".$MasterStockInfo['mstcoyown']."'";
			if($MasterStockInfo['mstcabown'] != '-')
				$sql.=" AND mstcabown='".$MasterStockInfo['mstcabown']."'";
			if($MasterStockInfo['mstcoycons'] != '-')
				$sql.=" AND mstcoycons='".$MasterStockInfo['mstcoycons']."'";
			if($MasterStockInfo['mstcabcons'] != '-')
				$sql.=" AND mstcabcons='".$MasterStockInfo['mstcabcons']."'";
		$sql .=" GROUP BY mstckdtipe ORDER BY mstckdtipe ASC ";	
		return $this->db->query($sql);		
    }
    
    function getAllMasterStockReportToExcel($MasterStockInfo)
	{
		if($MasterStockInfo['mstckdcoy'] != '-')
			$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
			$this->db->orderby('mstckdtipe', 'des');

		if($MasterStockInfo['mstckdcab'] != '-')
			$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
			$this->db->orderby('mstckdtipe', 'des');
		return $this->db->get('dmsstokv')->row();
    }
    
    function getAllMasterStockReportToExcelRow($MasterStockInfo)
	{
		if($MasterStockInfo['mstckdcoy'] != '-')
			$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
			$this->db->orderby('mstckdtipe', 'des');

		if($MasterStockInfo['mstckdcab'] != '-')
			$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
			$this->db->orderby('mstckdtipe', 'des');
		return $this->db->get('dmsstokv');
    }
    
    function getReportFromView($MasterStockInfo)
	{
		if($MasterStockInfo['mstckdcoy'] != '-')
			$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
			$this->db->orderby('mstckdtipe', 'des');

		if($MasterStockInfo['mstckdcab'] != '-')
			$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
			$this->db->orderby('mstckdtipe', 'des');
		return $this->db->get('dmsstokv');
    }

    
	function countAllMasterStockSearch($MasterStockInfo)
	{
		if(isset($MasterStockInfo['mstckdcoy']))$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		if(isset($MasterStockInfo['mstckdcab']))$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
		$this->db->like('mstcrangka', $MasterStockInfo['mstcrangka']);
		$this->db->orderby('mstckdcoy', 'asc');
		$this->db->orderby('mstcrangka', 'asc');
		$query = $this->db->get('dmsstokv');
		return $query->num_rows();
	}
	
	function getAllMasterStockPagingSearch($MasterStockInfo, $num, $offset)
	{
		$this->db->like('mstcrangka', $MasterStockInfo['mstcrangka']);
		$this->db->like('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		$this->db->like('mstckdcab', $MasterStockInfo['mstckdcab']);
		$this->db->orderby('mstckdcoy', 'asc');		
		$this->db->orderby('mstcrangka', 'asc');
		return $this->db->get('dmsstokv', $num, $offset);
	}
	
	function getAllMasterStockInfo($MasterStockInfo)
	{
		if(!empty($MasterStockInfo['mstckdcoy']))$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		if(!empty($MasterStockInfo['mstckdcab']))$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
		if(!empty($MasterStockInfo['mstcoycons']))$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		if(!empty($MasterStockInfo['mstcabcons']))$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		return $this->db->get('dmsstokv')->row();
		
    }
    
    function getAllMasterStockInfoForWO($MasterStockInfo)
	{
		if(!empty($MasterStockInfo['mstcrangka']))$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		if(!empty($MasterStockInfo['mstcmesin']))$this->db->where('mstcmesin', $MasterStockInfo['mstcmesin']);
		if(!empty($MasterStockInfo['mstcnopolisi']))$this->db->where('mstcnopolisi', $MasterStockInfo['mstcnopolisi']);
		return $this->db->get('dmsstokv');
    }
    
    function getAllMasterStockInfoByConsignment($MasterStockInfo)
	{
		if(!empty($MasterStockInfo['mstcoycons']))$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		if(!empty($MasterStockInfo['mstcabcons']))$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		if(!empty($MasterStockInfo['mstcrangka']))$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		return $this->db->get('dmsstokv')->row();
    }
    
    function getAllMasterStockInfoByIris($MasterStockInfo)
	{
		if(!empty($MasterStockInfo['mstckdcoy']))$this->db->where('mstcoycons', $MasterStockInfo['mstckdcoy']);
		if(!empty($MasterStockInfo['mstckdcab']))$this->db->where('mstcabcons', $MasterStockInfo['mstckdcab']);
		if(!empty($MasterStockInfo['mstcrangka']))$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		return $this->db->get('dmsstokv')->row();
    }
    
    /* Request : pencarian data getAllMasterStockInfoByConsignment diganti oleh fungsi ini 
     * search By Chasis Only :> papanyaraka 08 April 2009
     * */
    function getAllMasterStockInfoByChasis($MasterStockInfo)
	{
		$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		return $this->db->get('dmsstokv')->row();
    }
    function getAllMasterStockInfoByChasisFisikAndProses($MasterStockInfo)
	{
		$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		$this->db->where('mstcfisik', 'OH');
		$this->db->where('mstcproses', 'RS');
		return $this->db->get('dmsstokv')->row();
    }
    //by rizq@26-10-2011
	function isApplicableEngine($MasterStockInfo)
	{
		$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		$this->db->where('mstcmesin', $MasterStockInfo['mstcmesin']);
		$this->db->where('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		$this->db->where('mstckdwarna', $MasterStockInfo['mstckdwarna']);
		$query = $this->db->get('dmsstokv');
		return $query->num_rows();
	}
    
    function getAllMasterStockInfoByChasisVvs($MasterStockInfo)
	{
		$sql = "SELECT * FROM dmsstokv WHERE mstcrangka='".$MasterStockInfo['mstcrangka']."'";
		return $this->db->query($sql)->row();		
    }
    
    function getAllMasterStockInfoByEngine($MasterStockInfo)
	{
		$this->db->where('mstcmesin', $MasterStockInfo['mstcmesin']);
		return $this->db->get('dmsstokv')->row();
    }
    
    function getAllMasterStockInfoByProd($MasterStockInfo)
	{
		$this->db->where('mstcnoprod', $MasterStockInfo['mstcnoprod']);
		return $this->db->get('dmsstokv')->row();
    }
    
    function isChasisExist($MasterStockInfo)
	{
		$chasis = $this->getAllMasterStockInfoByChasis($MasterStockInfo);
		if(isset($chasis->mstcrangka) && !empty($chasis->mstcrangka))return true; else return false;
    }
    
    function getAllMasterStockByConsignment($MasterStockInfo,$num=null,$offset=null)
	{
		$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		$this->db->like('mstcrangka', $MasterStockInfo['mstcrangka']);
		
		$this->db->orderby('mstcoycons', 'asc');	
		$this->db->orderby('mstcabcons', 'asc');
		$this->db->orderby('mstcrangka', 'asc');
		if($num != null && $offset != null)$this->db->limit($num,$offset);	
		return $this->db->get('dmsstokv');
    }
    
    function getChasisCode($id)
	{
		$this->db->where('mstcrangka', $id);
		return $this->db->get('dmsstokv')->row();
    }
    
    function getAllMasterStockInfoProduksi($MasterStockInfo)
	{
		/* Request : pencarian data getAllMasterStockInfoByConsignment diganti oleh fungsi ini 
	     * search By Chasis Only :> papanyaraka 08 April 2009
	     * */
		if(!empty($MasterStockInfo['mstckdcoy']))$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		if(!empty($MasterStockInfo['mstckdcab']))$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
		$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		$this->db->where('mstcnoprod', $MasterStockInfo['mstcnoprod']);
		return $this->db->get('dmsstokv')->row();
    }
     
    function getAllMasterStockRow($MasterStockInfo)
	{
		if($MasterStockInfo['mstcrangka'] !='-'){
			$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
			$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
			$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
		}else if($MasterStockInfo['mstcnoprod'] !='-'){
			$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
			$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
			$this->db->where('mstcnoprod', $MasterStockInfo['mstcnoprod']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
		}else if($MasterStockInfo['mstcmesin'] !='-'){
			$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
			$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
			$this->db->where('mstcmesin', $MasterStockInfo['mstcmesin']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
		}
		return $this->db->get('dmsstokv')->row();
    }
    /*Dita Setiawan
     * 2009-06-30
     * */
    function getAllMasterStockRowByOrderDealer($MasterStockInfo)
	{
		$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		$this->db->where('mstcfisik', 'OH');
		$this->db->where('mstcproses', 'RS');
		if($MasterStockInfo['mstcrangka'] !='-'){
			$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
			$this->db->where('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		}else if($MasterStockInfo['mstcnoprod'] !='-'){
			$this->db->where('mstcnoprod', $MasterStockInfo['mstcnoprod']);
			$this->db->where('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		}else if($MasterStockInfo['mstcmesin'] !='-'){
			$this->db->where('mstcmesin', $MasterStockInfo['mstcmesin']);
			$this->db->where('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		}
		return $this->db->get('dmsstokv')->row();
    }

	function getMasterStockInfoByClause($MasterStockInfo)
	{
		if ($MasterStockInfo['mstcrangka'] !='-'){
			$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		}else if ($MasterStockInfo['mstcnoprod'] !='-'){ 
			$this->db->where('mstcnoprod', $MasterStockInfo['mstcnoprod']);
		}else if($MasterStockInfo['mstcmesin'] !='-'){
			$this->db->where('mstcmesin', $MasterStockInfo['mstcmesin']); 
		}
		return $this->db->get('dmsstokv')->row();
    }
    
    /* #info stok by rangka by. tri
     * 2012-09-10
     * */
    function getAllMasterStockInfoByRangka($MasterStockInfo)
	{
		if(!empty($MasterStockInfo['mstckdcoy']))$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		if(!empty($MasterStockInfo['mstckdcab']))$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
		$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		return $this->db->get('dmsstokv')->row();
    }

	function addMasterStock($MasterStockInfo)
	{
		return $this->db->insert('dmsstokv', $MasterStockInfo);		
	}

	function updateMasterStock($MasterStockInfo)
	{
		$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
		$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		
		return $this->db->update('dmsstokv', $MasterStockInfo);
		
	}
	
	function updateMasterStockbyOwn($MasterStockInfo)
	{
		$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
		$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		
		return $this->db->update('dmsstokv', $MasterStockInfo);
		
	}
	
	/*update chasis hungkul*/
	function updateMasterStockChasisOnly($MasterStockInfo)
	{
		$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		return $this->db->update('dmsstokv', $MasterStockInfo);
		
	}
	
	/*update nBook only*/
	function updateMasterStockNBookOnly($MasterStockInfo,$arrayofwhere)
	{
		$this->db->set('mstnbookaloc', $MasterStockInfo['mstnbookaloc']);
		$this->db->set('mstcbook', '');
		return $this->db->update('dmsstokv', $MasterStockInfo,$arrayofwhere);
		
	}
	
	function deleteMasterStock($MasterStockInfo)
	{
		$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		return $this->db->delete('dmsstokv');	
	}
	
	function getAllMasterStockSelectChasis($MasterStockInfo)
	{
		$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
		$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		return $this->db->get('dmsstokv')->row();
	}
	
	function getAllMasterStockConsChasis($MasterStockInfo)
	{
		$this->db->where('mstcoyown', $MasterStockInfo['mstcoyown']);
		$this->db->where('mstcabown', $MasterStockInfo['mstcabown']);
		if ($MasterStockInfo['mstcrangka'])
			$this->db->where('mstcrangka', $MasterStockInfo['mstcrangka']);
		if ($MasterStockInfo['mstcnoprod'])
			$this->db->where('mstcnoprod', $MasterStockInfo['mstcnoprod']);
		return $this->db->get('dmsstokv')->row();
	}
	
	function getAllMasterStockLabelValue($MasterStockInfo)
	{
		$this->db->select('mstcrangka,mstcmesin'); 
		$this->db->where('mstckdcoy', $MasterStockInfo['mstckdcoy']);
		$this->db->where('mstckdcab', $MasterStockInfo['mstckdcab']);
		$sql = $this->db->get('dmsstokv');
		return $sql; 
	}
	
	function countAllChasis($MasterStockInfo,$ohrs=0)
	{
		if ($MasterStockInfo['mstcoycons']!=='-')
			$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		if ($MasterStockInfo['mstcabcons']!=='-')
			$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		if ($MasterStockInfo['mstcrangka']!=='-')
			$this->db->like('mstcrangka', $MasterStockInfo['mstcrangka']);
		if(!empty($MasterStockInfo['mstckdtipe'])){
			if($MasterStockInfo['mstckdtipe']!=='-')
				$this->db->like('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		}
			if($ohrs==0){
				$this->db->where('mstcfisik', 'OH');
				$this->db->where('mstcproses', 'RS');
			}
			$query = $this->db->get('dmsstokv');
		return $query->num_rows();
	}
	
	function getAlllistChasis($MasterStockInfo, $num, $offset,$ohrs=0)
	{
		if ($MasterStockInfo['mstcoycons']!=='-')
			$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		if ($MasterStockInfo['mstcabcons']!=='-')
			$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		if ($MasterStockInfo['mstcrangka']!=='-')
			$this->db->like('mstcrangka', $MasterStockInfo['mstcrangka']);
		if(!empty($MasterStockInfo['mstckdtipe'])){
			if($MasterStockInfo['mstckdtipe']!=='-')
				$this->db->like('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		}
			if($ohrs==0){
				$this->db->where('mstcfisik', 'OH');
				$this->db->where('mstcproses', 'RS');
			}
			$this->db->orderby('mstcrangka', 'asc');
			$this->db->offset($offset);
			$this->db->limit($num);
		return $this->db->get('dmsstokv');
	}
	
	function countAllPeriode($MasterStockInfo)
	{
		if ($MasterStockInfo['mstcoycons']!=='-')
			$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		if ($MasterStockInfo['mstcabcons']!=='-')
			$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		if ($MasterStockInfo['mstcnoprod']!=='-')
			$this->db->like('mstcnoprod', $MasterStockInfo['mstcnoprod']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
			$query = $this->db->get('dmsstokv');
		return $query->num_rows();
	}
	
	function getAlllistPeriode($MasterStockInfo, $num, $offset)
	{
		if ($MasterStockInfo['mstcoycons']!=='-')
			$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		if ($MasterStockInfo['mstcabcons']!=='-')
			$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		if ($MasterStockInfo['mstcnoprod']!=='-')
			$this->db->like('mstcnoprod', $MasterStockInfo['mstcnoprod']);
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
			$this->db->orderby('mstcrangka', 'asc');
			$this->db->offset($offset);
			$this->db->limit($num);
		return $this->db->get('dmsstokv');
	}
	
	function countgetAllCPE($MasterStockInfo){
		if ($MasterStockInfo['mstcrangka']!= '-')
			$this->db->like('mstcrangka', $MasterStockInfo['mstcrangka']);
		if ($MasterStockInfo['mstcnoprod']!= '-')
			$this->db->like('mstcnoprod', $MasterStockInfo['mstcnoprod']);
		if ($MasterStockInfo['mstcmesin']!= '-')
			$this->db->like('mstcmesin', $MasterStockInfo['mstcmesin']);
		if(!empty($MasterStockInfo['al'])){
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
		}
		if(!empty($MasterStockInfo['SL'])){
			$this->db->where('mstcproses', 'SL');
		}
		if(!empty($MasterStockInfo['mstckdwarna'])){
			if($MasterStockInfo['mstckdwarna']!=='-')
				$this->db->like('mstckdwarna', $MasterStockInfo['mstckdwarna']);
		}
		if(!empty($MasterStockInfo['mstckdtipe'])){
			if($MasterStockInfo['mstckdtipe']!=='-')
				$this->db->like('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		}
		if(!empty($MasterStockInfo['mstcoycons']) && !empty($MasterStockInfo['mstcabcons'])){
			if($MasterStockInfo['mstcabcons']!=='-')
				$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
			if($MasterStockInfo['mstcabcons']!=='-')
				$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		}
		$query = $this->db->get('dmsstokv');
		return $query->num_rows();
	}
	
	function getAllCPE($MasterStockInfo,$num,$offset){
		if ($MasterStockInfo['mstcrangka']!= '-')
			$this->db->like('mstcrangka', $MasterStockInfo['mstcrangka']);
		if ($MasterStockInfo['mstcnoprod']!= '-')
			$this->db->like('mstcnoprod', $MasterStockInfo['mstcnoprod']);
		if ($MasterStockInfo['mstcmesin']!= '-')
			$this->db->like('mstcmesin', $MasterStockInfo['mstcmesin']);
		if(!empty($MasterStockInfo['al'])){
			$this->db->where('mstcfisik', 'OH');
			$this->db->where('mstcproses', 'RS');
		}
		if(!empty($MasterStockInfo['SL'])){
			$this->db->where('mstcproses', 'SL');
		}
		if(!empty($MasterStockInfo['mstckdwarna'])){
			if($MasterStockInfo['mstckdwarna']!=='-')
				$this->db->like('mstckdwarna', $MasterStockInfo['mstckdwarna']);
		}
		if(!empty($MasterStockInfo['mstckdtipe'])){
			if($MasterStockInfo['mstckdtipe']!=='-')
				$this->db->like('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		}
		if(!empty($MasterStockInfo['mstcoycons']) && !empty($MasterStockInfo['mstcabcons'])){
			if($MasterStockInfo['mstcabcons']!=='-')
				$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
			if($MasterStockInfo['mstcabcons']!=='-')
				$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		}
		$this->db->offset($offset);
		$this->db->limit($num);
		$query = $this->db->get('dmsstokv');
		return $query;
	}
	
	function countgetAllCPEByType($MasterStockInfo){
		$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		$this->db->where('mstcfisik', 'OH');
		$this->db->where('mstcproses', 'RS');
		if($MasterStockInfo['mstcrangka']!= '-')
			$this->db->like('mstcrangka', $MasterStockInfo['mstcrangka']);
		if($MasterStockInfo['mstcnoprod']!= '-')
			$this->db->like('mstcnoprod', $MasterStockInfo['mstcnoprod']);
		if($MasterStockInfo['mstcmesin']!= '-')
			$this->db->like('mstcmesin', $MasterStockInfo['mstcmesin']);
		if($MasterStockInfo['mstckdtipe']!= '-')
			$this->db->like('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		if($MasterStockInfo['mstckdwarna']!= '-')
			$this->db->like('mstckdwarna', $MasterStockInfo['mstckdwarna']);
		$query = $this->db->get('dmsstokv');
		return $query->num_rows();
	}
	
	function getAllCPEByType($MasterStockInfo,$num,$offset){
		$this->db->where('mstcoycons', $MasterStockInfo['mstcoycons']);
		$this->db->where('mstcabcons', $MasterStockInfo['mstcabcons']);
		$this->db->where('mstcfisik', 'OH');
		$this->db->where('mstcproses', 'RS');
		if($MasterStockInfo['mstcrangka']!= '-')
			$this->db->like('mstcrangka', $MasterStockInfo['mstcrangka']);
		if($MasterStockInfo['mstcnoprod']!= '-')
			$this->db->like('mstcnoprod', $MasterStockInfo['mstcnoprod']);
		if($MasterStockInfo['mstcmesin']!= '-')
			$this->db->like('mstcmesin', $MasterStockInfo['mstcmesin']);
		if($MasterStockInfo['mstckdtipe']!= '-')
			$this->db->like('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		if($MasterStockInfo['mstckdwarna']!= '-')
			$this->db->like('mstckdwarna', $MasterStockInfo['mstckdwarna']);
		$this->db->offset($offset);
		$this->db->limit($num);
		$query = $this->db->get('dmsstokv');
		return $query;
	}	
	
	function get_generate_chasis($MasterStockInfo)
	{
		$this->db->where('mstckdtipe', $MasterStockInfo['mstckdtipe']);
		$this->db->where('mstckdwarna', $MasterStockInfo['mstckdwarna']);
		$this->db->where('mstcfisik', 'OH');
		$this->db->where('mstcproses', 'RS');
		$this->db->orderby('mstdtgsof', 'asc');
		return $this->db->get('dmsstokv')->row();
	}
	
	
	
	
	
	
	//android
	function countgetAllCPECust($MasterStockInfo){
		$this->db->where('mstcproses', 'SL');
		$this->db->where('mstcrangka', $MasterStockInfo);
		$query = $this->db->get('dmsstokv');
		return $query->num_rows();
	}
	
	function getAllCPECust($MasterStockInfo){
		$this->db->where('mstcproses', 'SL');
		$this->db->where('mstcrangka', $MasterStockInfo);
		$query = $this->db->get('dmsstokv');
		return $query;
	}

}
?>