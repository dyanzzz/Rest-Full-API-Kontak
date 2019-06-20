<?php  
/* 
|--------------------------------------------------------------------------
| Additional Configuration for iHyundai
|--------------------------------------------------------------------------
|
*/
define("ROW_PER_PAGE", 10);
define("ROW_PER_PAGE2", 20); // used by eomcgp
define("ROW_PER_PAGE_LSH", 25);
define("ROW_PER_PAGE_STOCKPART", 40);
define("ROW_PER_PAGE_SIGNOFF", 60);
define("DetailRowMax", 15);//maximum number of detail row for print pra-BP, Pra-penerimaan, Cashbank dll...

//------------- Importation
define("LetterOfCrdCounterCode","073"); //Letter of Credit
define("PRPC","076");//CBU Proforma
define("BOLC","074");//Bill Of Leading 
define("SHPC","075");//Shipment 
define("PibCounterCode","078");//PIB
define("WIP","079");// Work In Process (WIP) 

//------------- Master
define("GoodsIvnCounterCode","A01"); // Goods Iventory

define("bwhbmgdCounterCode","521"); // BMG
define("bwhbkgdCounterCode","522"); // BKG

define("CustCTUCounterCode","802"); // Customer CTU

/*----------- Hotel Recervation ---------------*/
define("CEKIN","803");//Check-In

/*------------- Inventory And Stock Admin ----------------*/
define("SignOffCounterCode","019");    //Sign Off	019
define("CbuOrderCounterCode","021"); 	// Counter For Cbu Order / Purchase Order
define("IRISHO","023"); 				// Counter For IRISHO
define("IRISDLR","016"); 				// Counter For IRIS DEALER
define("DistArea","025"); 				// Counter For Distributed Area
define("DOInternal","027"); 			// Counter For DO Internal
define("PIRIS","018"); 				// Counter For PERMOHONAN IRIS
define("STKPLAN","019"); 				// Counter For PERMOHONAN IRIS
//Vehicle Good Receive ??
//IRIS Branch ??
// LPB IRIS 028

/*------------- Sales Order ----------------*/
define("SpkRegCounterCode","031"); 		//SPK REGISTRY
define("RetSpkRegCounterCode","032"); 	//Retur SPK Reg??
define("PoOptionalCounterCode","033"); 	//PoOptionalCounterCode/PO Sublet/PO ACCS/OPTIONAL
define("KaroseriCounterCode","034"); 	//Karoseri??
define("ApprovPoOptionalCounterCode","035");	//Approval PoOptional CounterCode/PO Sublet
define("OrderDealer","036");					//OrderDealer / PURCHASE ORDER CBU
define("ODValidasi","037");					//OrderDealer / PURCHASE ORDER CBU
define("BookAloc","038");					//Booking Alocation
define("CustomerCode","805");  	
define("CustomerAllCode","806");
define("CustSvcCounterCode","807");
define("CustUpdate","809");  
define("MSTCP","602");
	
define("VehicleMaintenance","026");		//VehicleMaintenance
define("VehicleStatus","015");		//Maint. Stock Status
define("CusSvcMnc","808");		//Customer Service Maintenance


/*------------- Billing Invoice ----------------*/
define("SalesUnit","041");						//SalesUnit
define("SalesRent","041");						//Sales Rental
define("HPPUNIT","049");						//HPP UNIT
define("ReturUnit","042");						//Retur Unit??
define("DeliveryOrderCounterCode","043"); 		// Counter For Delivery Order 
define("ReturDOCounterCode","044"); 			//Retur DO			044
define("DeliveryOrderHIMCounterCode","045"); 	// Counter For Delivery Order HIM
define("BdgtTargetCounterCode","381"); 			// Budget Target Sales
define("DOPLN","047"); 			// Delivery Order Plan Dlr
/*------------- GL A/P BBN Kendaraan ----------------*/
define("AP_BBN","G29");	
define("GLIntAPPraBP","G30");	
define("GLIntIRSIn","G31");	
define("GLIntIRSHO","G32");	

/*------------- Sales Payment ----------------*/
define("SPKwitansiCounterCode","048");	 		//Kwitansi Sales Payment Kwitansi
define("SPMonGiroCounterCode","046");			//Monitoring Giro?? //046

/*------------- Police Registration ----------------*/
define("PerFakturPolisiCounterCode","061");	// Counter For Permohonan Faktur Polisi
define("FakturPolisiCounterCode","062"); 	// FakturPolisi
define("PFPOLREV","063");	// Counter For Revisi Permohonan F.Pol
define("BBGM","058"); 						//Buy Back Guaranti

/*------------- Service Management ----------------*/
/*----------- Service Advisor ---------------*/
define("WOCounterCode","112"); 					// Counter For Work Order
define("WOReturn","114"); 					// Counter For Work Order
define("BookingService","113");					// BookingService
define("CussFollUpCounterCode","117"); 	// CussFollUp
define("CALLCENTER","118"); 	// CALL CENTER
//WO Return??

define("ServiceEstimationCounterCode","116"); 	//Service Estimation

/*----------- Foreman ---------------*/
//Technism Allocation??
define("ClockOnCounterCode","122"); 		// Counter For Clock On Job
define("STOCKTACKING","148"); 		// STOCKTACKING
define("JobPending","104"); 		//Job pending??
define("TransactionLaborCounterCode","125"); 		// Counter For Transaction Labor (Lampiran Sk.Cadang)

/*----------- Service Billing Invoice ---------------*/
define("KWBCounterCode","151");				// Counter For Invoic Bengkel
define("KWBJI","156");						// Counter For RETUR KWB
define("KWBReturCounterCode","152");		//ReturInvoice
define("HsssaPklCounterCode","115");		//Po Sublet

//Gate Pass WO?? 153
//Tax Form?? 154
define("LapTAcl","138");//CounterCode For Laporan Teknik
/*----------- Spare Part ---------------*/
define("OrderingPartCounterCode","131"); 			// Counter For Ordering Part
define("opcCounterCode","158"); 			// Ordering Part Customer
define("GoodRPartCounterCode","132");				// Counter For GoodReceivePart
define("IrisGoodRPartCounterCode","133");				// Counter For GoodReceivePart
  
//Good Receive Part-ex.IRIS 133
//Good Receive Part-ex.Local 134
//Good Receive Part-ex.Others 135
//Retur GR Part ex.HO 136
//Retur GR Part ex.Local 138
//Retur GR Part ex.Others 139
define("ReturIrisLpb","137");			// Retur Good Receive Part Counter Code
define("ReturGoodRPartCounterCode","136");			// Retur Good Receive Part Counter Code
define("TransactionPartOutCounterCode","140"); 		// Counter For Transaction Part Out/Lampiran SUku Cadang
define("ReturLscCounterCode","141"); 				// Counter For Retur LSC
define("FPSukuCadangCounterCode","142"); 			// Counter For Transaction Sales Out = FP suku cadang
define("ReturFpSukuCadangCounterCode","143"); 		// Counter For Retur FP.Suku Cadang
define("IrisPartsCounterCode","144"); 				// Counter For IRIS Part
define("ReturIrisPartsCounterCode","145"); 			// Counter For Retur IRIS Part
define("HssmtnOpCounterCode","175"); 				// Counter For Nota Opex Material
define("RTNPMT","176"); 				// Counter For Retur Nota Opex Material
define("HssmtnOpWoCounterCode","182"); 				// Counter For Nota Opex Material Wo
define("CGIR","178"); 					// Counter For C/G Invoice (FPS) Receive 05-12-2011
define("TandaTerimaFaktur","179"); 					// Counter For TANDA TERIMA FAKTUR 26-01-2009
define("TandaTerimaFakturMaterial","180"); 					// Counter For TANDA TERIMA FAKTUR MATERIAL 2019-01-03
define("UNSUPPLYPARTS","181"); 					// Counter For UNSPULLY PARTS
define("HssPrPSp","146");//Peminjaman Spare Part?? 146
define("HssRtPrPSp","147");//Pengembalian Spare Part?? 147
//STO-Tag Number?? 148
define("HssPraspIn","149");//Adjusment In-Part??  149
define("HssPraspOut","150");//Adjustment Out-Part??  150

/*----------- Material ---------------*/
define("OrderingMaterialCounterCode","161"); 			// Counter For Ordering Material
define("TransMatInCounterCode","162");		// Counter For Transaction Material In/Good Receive Material
define("GoodRMaterialCounterCode","163");	// Counter For GoodReceiveMaterial
define("LampiranMaterialCounterCode","164"); // Lampiran Material Counter Code
define("ReturLsMaterialCounterCode","165"); // Retur Lampiran Material Counter Code
define("TransactionMaterialOutCounterCode","166"); 	// Transaction Material Out Counter Code /Faktur Penjualan Material
define("ReturFakturMaterialCounterCode","167"); 	// Retur Faktur Material
define("ReturLpbMatCounterCode","168"); 	// Retur Lampiran Material
define("IRSM","169"); 	// IRIS Material
//Retur IRIS Material??
//Peminjaman Material??
//Pengembalian Material??
//STO-Tag Material??
define("HssMtamIn","173"); 	//Adjusment In-Material?? 173
define("HssMtamOut","174"); 	//Adjusment Out-Material?? 174

/*----------- Waranty ---------------*/
define("FreeService","126");//CounterCode For Free Service
define("LapTeknik","127");//CounterCode For Laporan Teknik
define("WarClaim","128");//CounterCode For Waranty Claim
define("REMIT","129");//CounterCode For Remittance
define("PCLAIM","130");//CounterCode For Part Claim

define("CLMPNT","260");//Claimnt Point
define("INVBIL","812");//Claimnt Point

define("TSBT","890");//CounterCode TSB
define("TSBC","891");//CounterCode TSB Comment
define("WarClaimCsd","134");//CounterCode For Waranty Claim CSD

/*----------- Finance Control ---------------*/
define("PraBPCounterCode","201");//CounterCode For Pra BP
define("PraPnrmCounterCode","204");//CounterCode For Pra Penerimaan
define("CekGiroCode","203");//CounterCode For Pra Penerimaan
define("MSTVD","601");//CounterCode For Vendor Optional
define("PGF","064");//PROGRESIF-PJK (PAJAK PROGRESIF)

 

/*----------- Eoffice ---------------*/
/*----------- Document Invoice Received ---------------*/
define("DocumentInvoiceReceived","221");//Document Invoice Received
define("PengajuanLembur","508");//Pengajuan Lembur
define("PengajuanCuti","509");//Pengajuan Cuti

/*----------- Cash Bank ---------------*/
define("CbhCounterCodeI","301"); // Counter For Cbh 301 CASH BANK IN
define("CbhCounterCodeO","302"); // Counter For Cbh 302 CASH BANK OUT
define("CbhReimbushCounterCodeI","331");
define("CbhReimbushCounterCodeO","332");
define("ReClass","333"); //  
define("ReClassSvc","333"); //  
define("CBCorrectReq","217"); // Counter For CB Corection request
define("CBCoaTitipan","215");  
define("BNKLN","372"); // BANK LOAN
define("NotaDebet","228"); // BANK LOAN

/*------------- Member Register Mart ----------------*/
define("CustMemOTH","814");
define("KwitansiOTH","059");

/* 		below is counter code that undefined yet 		*/
define("ProjectPraBP","230");//CounterCode For Project Pra-BP
define("PraBgCounterCode","231");//CounterCode For PRA
define("CKDppCounterCode","020"); // Counter For CKD Order
define("SalesPlanningCounterCode","021"); // Counter For Branch Sales Planning Order
define("DealerSalesPlanningCounterCode","022"); // Counter For Dealer Sales Planning Order
define("VehiclePurchasingCounterCode","014");
define("FcppCounterCode","024");

define("CounterDeleteTrx","398"); // Counter For Delete Transaction 398
define("GlAccCounterCode","399"); // Counter For GLACC 399

/*FIRST-RENT*/
/*---------------- Voucher Invoice -----------------*/
define("VoucherInvoice","871"); // Counter For Voucher Invoice 980

/*---------------- Voucher Driver -----------------*/
define("VoucherDriver","870"); // Counter For Voucher Invoice 980

/*--------------COUNTER CODE SERVICE MANAGEMENT-----------------*/
define("TransactionMaterialCounterCode","031"); 	// Transaction Material / Sales And Purchase??

/*define("TransactionPartMutationCounterCode","014");	// Counter For Transaction Mutation Out (tidak digunakan/tidak ada UI)*/

/*--------------COUNTER CODE HELPDESK-----------------*/
define("IncomingOrderCounterCode","501"); 	// Incoming Order

/*--------------BRANCH MONITORING SYSTEM-----------------*/
define("SalesmanActivityCounterCode","401"); 	// Salesman Activity
define("RTEMP","406"); 	// Req Termination Emp
define("CLAIMINSENTIVE","407"); 	// CLAIM INSENTIVE
define("SLRQ","408"); 	// SALESMAN REQUEST
define("EMRQ","411"); 	// Request NEW Employee Data
define("SlmMntSpvCounterCode","409");//Document Invoice Received
define("CLAIMINSENTIVEREKAP","410");// CLAIM INSENTIVE REKAP

/*--------------COUNTER CODE HCRM-----------------*/
define("GogoCounterCode","815"); 	// Member GOGO Registration
define("hcrmhmregCounterCode","811"); 	// Member Registration
define("hcrmhmregCounterCode2","813"); 	// Member Registration 2 (pak sugeng)
define("hcrmreqHyundaiApps","804"); 	// Request Hyundai Apps Booking Service
define("hcrmreqTestDrive","804"); 	// Request test Drive xxx

/*--------------COUNTER CODE HCRM-----------------*/
define("TextDf","051"); // TextDf
define("DFPRM","052"); 	// SURAT PESANAN PENCAIRAN DF
define("CLMPDC","053"); // CLAIM PDC
define("NORFreeSvc","054"); // CLAIM N.O.R (Free Service)

/*--------------COUNTER CODE HCRM-----------------*/
define("PAJAK","123"); 	// FAKTRU PAJAK

/*--------------COUNTER CODE IPPC-----------------*/
define("IPPC","124"); 	// Member Registration
/*--------------COUNTER CODE IPPB-----------------*/
define("IPPB","111"); 	// Member Registration
/*--------------COUNTER CODE IPPP-----------------*/
define("IPPP","118"); 	// Member Registration
/*--------------COUNTER CODE IPLA-----------------*/
define("IPLA","119"); 	// Member Registration

define("InvnonmtrlInCounterCodeIN","530"); 	// Inventory GA IN
define("InventoryGaCounterCodeOUT","531"); 	// Inventory GA Out
define("TTDDOC","532"); 	// Tanda Terima DOC
define("OrderingInvNonMtrl","520"); 	// Inventory Ordering NonMaterial
define("SPD","502"); 	// SURAT PERMOHONAN SPD
define("RealisasiSPD","504"); 	// REALISASI SPD
define("PermhnPoAssetCounterCode","511"); 	// PERMOHONAN PO ASSET
define("PoAssetCounterCode","519"); 	// PO ASSET
define("PurchaseOrderUnit","874"); 	// Purchase Order Unit
define("SPBRC","873"); 	// SPB Rentcar
define("FXAIN","515"); 	// Fix Asset IN
define("FXAMT","516"); 	// Fix Asset Mutation
define("FXAOUT","517"); 	// Fix Asset OUT
define("ASTMST","507"); 	// Asset Master

/*Attendance*/
define("Attendance","506"); 	// Attendance
define("TrainingPersonal","512"); 	// Training Personal
define("IPLS","503"); 	// Training Personal
define("LGLO","510"); 	// Login-Logout
define("RQMN","513"); 	// Requirement
define("FAST","441"); 	// Fix Asset
define("POR","514"); 	// Problem Or Request
//define("PRBD","511"); 	// Problem Or Request Branch Dealer


/*----------------- COUNTER CODE PHB --------------*/
define("PHB","017");// PHB CET

/*----------------- Key Performance Indicator (KPI) --------------*/
define("KpiStrategic","541");// KPI STRATEGIC
define("KpiTactical","542");// KPI TACTICAL
define("KpiOperational","543");// KPI OPERATIONAL
define("KpiAchievement","544");// KPI ACHIEVEMENT

/*----------------- Rental --------------*/
define("RentcarinvCounterCode","872"); 	// Rent Car Inventory
define("GENINV","875"); 	// Generate Invoice

/*----------------- SURAT REGISTRASI UJI TYPE --------------*/
define("SRUT","070"); 	// SURAT REGISTRASI UJI TYPE


/******************** CONSTANTA FOR PRINTING DOCUMENT **********************************/
define("isKWBusingFixedForm",0); 					// 1 = use fixed form , 0 = blank paper
define("isSalesUnitForm",1); 						// 1 = Invoice , 0 = Invoice & BSTB

/******************** SHORTCUT **********************************/
define("ShortcutAdd","ALT+A");//Shortcut For Add Button
define("ShortcutEdit","ALT+E");//Shortcut For Edit Button
define("ShortcutSave","ALT+S");//Shortcut For Save Button
define("ShortcutDel","ALT+D");//Shortcut For Delete Button
define("FormatCOA","xxxx.xxxx.xxxx"); // format Chart Of Account

/*  
 * Uploaded Document Path
*/
define('prabp_docpath','doc/prabp/');
define('waranty','doc/SK_SPD/');
define('bbg_docpath','doc/bbg/');
define('img_dealer_docpath','doc/img_dealer/');
define('det_menu','doc/menu/');
define('asset','doc/asset/');
define('attendance','ihyundai_system_files/application/doc/');
define("URL_UPLOAD", 'E:/Workspace/ihyundai/doc/warany/');    //local
define("PATH_UPLOAD_EVIDENCE_REVIEW", 'doc/hr_upload/pdca_evidence/'); //upload file evidence REVIEW MONTHLY (IO HRD)
define("PATH_UPLOAD_TMP_ACL_HMC", 'doc/wcl/tmp_acl/');

?>
