<?php
// core configuration
include_once '../config/database.php';

include_once '../model/dao/txcurr_patients.php';
include_once '../model/dao/txnew_patients.php';
include_once '../model/dao/pvls_patients.php';
include_once '../model/dao/pbs_patients.php';
include_once '../model/dao/ltfu_patients.php';
include_once '../model/dao/all_patients.php';
include_once '../model/dao/age_patients.php';
include_once '../model/dao/all_facilities.php';

// include classes
include_once 'cohort_facts.php';


// get database connection
$database = new Database();
$db = $database->getConnection();
$facts = new Facts($db);


// initialize objects
$txcurr = new TxCurr_Patients($db);
$txcurr_lastqtr = new TxCurr_Patients($db);
$txnew = new TxNew_Patients($db);
$ltfu = new LTFU_Patients($db);
$pbs = new PBS_Patients($db);
$pvls = new PVLS_Patients($db);
$male = new All_Patients($db);
$female = new All_Patients($db);
$age = new Age_Patients($db);
$facilities = new All_Facilities($db);


//get last quarter
$lastquarter= ceil(date("n") / 3);



//1.  TXNEW 
$fy=date('Y');
extract(getQuarter((new DateTime())->modify('+3 Months')));
$q=$quart;
$qtrstart= $start;
extract(getQuarter((new DateTime())));
$fyear=$fy;
$row = $txnew->countAll($qtrstart) ;
foreach($row as $rows):  
$rowP = $txnew->getPatients($rows['datim_id']) ;
$facts->insertStateFact(1,$fy,$q,$rows['datim_id'],$rows['total_rows'],$rowP);
endforeach;


//2. Treatment Current  TXNEW for Last Quarter	



//get last quarter interval
extract(getQuarter((new DateTime())->modify('-3 Months')));
$qtrstart= $start;
$qtrend= $end;
$fyear=$fy;

//get txNEW of last quarter
$txnew_lastqtr = $txnew->countLastQuarter($qtrstart,$qtrend) ;
foreach($txnew_lastqtr as $rows): 
$rowP = $txnew->getPatients($qtrstart,$rows['datim_id']) ; 
$facts->insertStateFact(1,$fyear,$lastquarter,$rows['datim_id'],$rows['total_rows'],$rowP);
endforeach;

//3. Treatment Current TXCURR 
$fy=date('Y');
extract(getQuarter((new DateTime())->modify('+3 Months')));
$q=$quart;
extract(getQuarter((new DateTime())));
$fyear=$fy;
$row = $txcurr->countAll() ;

foreach($row as $rows):  
$rowP = $txcurr->getPatients($rows['datim_id']) ;
$facts->insertStateFact(2,$fy,$q,$rows['datim_id'],$rows['total_rows'],$rowP);
//exit();
endforeach;
//4. Treatment Current  TXCURR for Last Quarter	
//get last quarter interval
extract(getQuarter((new DateTime())->modify('-3 Months')));
echo $qtrstart= $start;
echo $qtrend= $end;
$fyear=$fy;

//get txcurr of last quarter
$txcurr_lastqtr = $txcurr->countLastQuarter($qtrend) ;
foreach($txcurr_lastqtr as $rows):  
$rowP = $txcurr->getPatients($rows['datim_id']) ;
$facts->insertStateFact(2,$fyear,$lastquarter,$rows['datim_id'],$rows['total_rows'],$rowP);
endforeach;

//5. Treatment ML
$fy=date('Y');
extract(getQuarter((new DateTime())->modify('+3 Months')));
$q=$quart;
extract(getQuarter((new DateTime())));
$fyear=$fy;
$row = $ltfu->countAll() ;
foreach($row as $rows):  
$rowP = $ltfu->getPatients($rows['datim_id']) ;
$facts->insertStateFact(5,$fy,$q,$rows['datim_id'],$rows['total_rows'],$rowP);
endforeach;

//6. PVLS Numerator
$fy=date('Y');
extract(getQuarter((new DateTime())->modify('+3 Months')));
$q=$quart;
extract(getQuarter((new DateTime())));
$fyear=$fy;
$row = $pvls->countNume() ;
foreach($row as $rows):  
$rowP = $pvls->getPatientsnume($rows['datim_id']) ;
$facts->insertStateFact(3,$fy,$q,$rows['datim_id'],$rows['total_rows'],$rowP);
endforeach;
//6a. PVLS Denominator
$pv = $pvls->countAll() ;
foreach($pv as $rows):    
$rowP = $pvls->getPatients($rows['datim_id']) ;
$facts->insertStateFact(4,$fy,$q,$rows['datim_id'],$rows['total_rows'],$rowP);
endforeach;

//7. Sex
$fy=date('Y');
extract(getQuarter((new DateTime())->modify('+3 Months')));
$q=$quart;
extract(getQuarter((new DateTime())));
$fyear=$fy;
$row = $male->countMale() ;
foreach($row as $rows):   
$rowP = $male->getPatientsMale($rows['datim_id']) ;
$facts->insertStateFact(8,$fy,$q,$rows['datim_id'],$rows['total_rows'],$rowP);
endforeach;
$rowf = $female->countFemale() ;
foreach($rowf as $rows):   
$rowP = $female->getPatientsFemale($rows['datim_id']) ;
$facts->insertStateFact(9,$fy,$q,$rows['datim_id'],$rows['total_rows'],$rowP);
endforeach;
/**
//8. PBS 
$fy=date('Y');
extract(getQuarter((new DateTime())->modify('+3 Months')));
$q=$quart;
extract(getQuarter((new DateTime())));
$fyear=$fy;
$row = $pbs->countAll() ;
foreach($row as $rows):  
$facts->insertStateFact(32,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;

//9. Age Groups
$fy=date('Y');
extract(getQuarter((new DateTime())->modify('+3 Months')));
$q=$quart;
extract(getQuarter((new DateTime())));
$fyear=$fy;
$row = $age->countless1() ;
foreach($row as $rows):  
$facts->insertStateFact(10,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->count1to4() ;
foreach($row as $rows):  
$facts->insertStateFact(11,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->count5to9() ;
foreach($row as $rows):  
$facts->insertStateFact(12,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->count10to14() ;
foreach($row as $rows):  
$facts->insertStateFact(13,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->count15to19() ;
foreach($row as $rows):  
$facts->insertStateFact(14,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->count20to24() ;
foreach($row as $rows):  
$facts->insertStateFact(15,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->count25to29() ;
foreach($row as $rows):  
$facts->insertStateFact(16,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->count30to34() ;
foreach($row as $rows):  
$facts->insertStateFact(17,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->count35to39() ;
foreach($row as $rows):  
$facts->insertStateFact(18,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->count40to44() ;
foreach($row as $rows):  
$facts->insertStateFact(19,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->count45to49() ;
foreach($row as $rows):  
$facts->insertStateFact(20,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
$row = $age->countplus50() ;
foreach($row as $rows):  
$facts->insertStateFact(21,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;

/**
//10. All facilities
$fy=date('Y');
extract(getQuarter((new DateTime())->modify('+3 Months')));
$q=$quart;
extract(getQuarter((new DateTime())));
$fyear=$fy;
$row = $facilities->read() ;
foreach($row as $rows):  
$facts->insertStateFact(33,$fy,$q,$rows['datim_id'],$rows['total_rows']);
endforeach;
*/
function getQuarter(\DateTime $DateTime) {
		$y = $DateTime->format('Y');
		$m = $DateTime->format('m');
		$year;
		switch($m) {
			case $m >= 1 && $m <= 3:
				$start = $y.'/01/01';
				$end = (new DateTime('03/1/'.$y))->modify('Last day of this month')->format('Y/m/d');
				$quart = '1';
				$year = $y;
				break;
			case $m >= 4 && $m <= 6:
				$start = $y.'/04/01';
				$end = (new DateTime('06/1/'.$y))->modify('Last day of this month')->format('Y/m/d');
				$quart = '2';
				$year = $y;
				break;
			case $m >= 7 && $m <= 9:
				$start = $y.'/07/01';
				$end = (new DateTime('09/1/'.$y))->modify('Last day of this month')->format('Y/m/d');
				$quart = '3';
				$year = $y;
				break;
			case $m >= 10 && $m <= 12:
				$start = $y.'/10/01';
				$end = (new DateTime('12/1/'.$y))->modify('Last day of this month')->format('Y/m/d');
				$quart = '4';
				$year = date('Y', strtotime('+1 year'));
				break;
		}
		return array(
				'start' => $start,
				'end' => $end,
				'quart' => $quart,
				'fy'=>$year,
		);
	}
	
	echo " I have completed this in peace";
	

?>