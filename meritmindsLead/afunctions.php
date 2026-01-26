<?php 
require_once('dbconfig/class.mysql.php');   
    $dbObj = new DataBasePDO();
    
function getConvert($value){
	if($value < 10000000){
		$ret = round(($value/100000),2)." Lacs";
	}else{
		$ret = round(($value/10000000),2)." Crores";
	}
	return  $ret;
}

function getAates($sdate,$edate){
	$period = new DatePeriod(new DateTime($sdate), new DateInterval('P1D'), new DateTime($edate.' +1 day'));
    foreach ($period as $date) {
		$key=$date->format("Y-m-d");
        $dates[$key] = $date->format("d-m-Y");
    }
	return $dates;
}
function getMeasure($cid){
	$con ="id=$cid ";   
 	$contras=getSubject('case_type', $con);
 	return $contras[0]['measure'];
} 
function getUnit($value){
	if($value ==1){
		$ret = "In Police";
	}elseif($value ==2){
		$ret = "In SEB";
	}else{
		$ret ="In Both";
	}
	return  $ret;
}
 

function excuteSql($sql){
	global $dbObj;
	$result = $dbObj->executeQuery($sql);
	return $result;
}

function exeSql($sql){
	global $dbObj;
	$result = $dbObj->getAllResults($sql);
	return $result;
}
	
function getServieList() {
 	global $servTable;
	global $dbObj;
	    $sql = 'SELECT   
						 *   
						  FROM '. 
							$servTable. ' WHERE status=1'; 
							
														  
		$result = $dbObj->getAllResults($sql);
		//echo"<pre>";print_r($result);die();
		return $result;
		
		
		
	}
	
function getAllDistricts($id=0) {
 	global $distTable;
	global $dbObj;
	    $sql = 'SELECT   
						 *   
						  FROM '. 
							$distTable;
        if($id){
			$sql .= ' WHERE
							  id = "'.$id.'"'; 	
		}
        													  
		$result = $dbObj->getAllResults($sql);
		//echo"<pre>";print_r($result);die();
		return $result;
		
		
		
}
function getCount($table,$con=0) {
    global $dbObj;
	$sql = 'SELECT   
					 count(*) as nos  
					  FROM '. 
						$table ; 
	
     if($con){
		 $sql .= ' WHERE '. $con;
	 }	
 
  	$result = $dbObj->getAllResults($sql); //echo"<pre>";print_r($result);die();
	return $result[0]['nos'];
	}

function getDoctorsBySpes($spid) {
    global $docsTable;
	global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$docsTable.' as e 
						
						 WHERE
							  e.spid = "'.$spid.'"'; 	
	$result = $dbObj->getAllResults($sql);
	//echo"<pre>";print_r($result);die();
	return $result;
	}

function getDoctorsByCitySps($spid,$cid) {
    global $docsTable;
	global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$docsTable.' as e 
						
						 WHERE
							  e.spid = "'.$spid.'" and e.cid="'.$cid.'"'; 	
	$result = $dbObj->getAllResults($sql);
	//echo"<pre>";print_r($result);die();
	return $result;
	}
function getSpecialitiesByService($sid) {
    global $specTable;
	global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$specTable.' as e 
						
						 WHERE
							  e.sid = "'.$sid.'"'; 	
	$result = $dbObj->getAllResults($sql);
	//echo"<pre>";print_r($result);die();
	return $result;
	}

function getAllCities() {
//	echo $userId;die();
    global $cityTable;
	global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$cityTable.' as e 
						
						 WHERE 1 ORDER BY name'; 	
	$result = $dbObj->getAllResults($sql);//echo"<pre>";print_r($result);die();
	return $result;
	}	
function getAllCitiesByDist($did) {
//	echo $userId;die();
    global $cityTable;
	global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$cityTable.' as e 
						
						 WHERE
							  e.dtid = "'.$did.'" ORDER BY e.name'; 	
	$result = $dbObj->getAllResults($sql);//echo"<pre>";print_r($result);die();
	return $result;
	}
function getPerticularSub($table,$cname,$con=0) {
    global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$table.' 
						
						 WHERE
							  name = "'.$cname.'"'; 
	
     if($con){
		 $sql .= ' AND '. $con;
	 }	
  	$result = $dbObj->getAllResults($sql);   //echo"<pre>";print_r($result);die();
	return $result;
	}
//
function getSubject($table,$con=0) {
    global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$table ; 
	
     if($con){
		 $sql .= ' WHERE '. $con;
	 }
   //echo $sql;	 
  	$result = $dbObj->getAllResults($sql);//echo"<pre>";print_r($result);die();
	return $result;
	}	
	
function getValue($table,$id) {
    global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$table .' WHERE cid='.$id;
	
  	$result = $dbObj->getOneRow($sql);
	
	return $result['cname'];
	}
	
function getIds($table,$cname) {
    global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$table .' WHERE cname='.$cname;
	echo $sql;
  	$result = $dbObj->getOneRow($sql);
	
	return $result['cid'];
	}
	
function getPValue($table,$id,$field) {
    global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$table .' WHERE id='.$id;
	
  	$result = $dbObj->getOneRow($sql);
	
	return $result[$field];
	}
function getRowValues($table,$id) {
    global $dbObj;
	$sql = 'SELECT   
					 *   
					  FROM '. 
						$table .' WHERE news_id='.$id;
	//echo $sql;
  	$result = $dbObj->getOneRow($sql);
	return $result;
}

function dispJson($js){
	$jds=json_decode($js);
	$items='';
	foreach($jds as $x =>$jd){
		$n=$x+1;
	$items .=$n.') '.$jd.'<br/>';	
	}
	return $items;
}	
 
//for  pharma things
  	

    function getItemsBySid($sid) {
	    global $dbObj;
		$table =TABLE_ITEMS;   
					
		$whereArray				= array("`sid`='$sid' ORDER BY name ");
		
		$results					= $dbObj->selectData($table,$whereArray);
	
		return $results;
	}
	function getAllIssueByCust($cid) {
	    global $dbObj;
		$table =TABLE_ISSUES;   
					
		$whereArray				= array(" `cid`='$cid' ORDER BY created DESC ");
		
		$results					= $dbObj->selectData($table,$whereArray);
	
		return $results;
	}
	function getAllINotifications() {
	    global $dbObj;
		$table ='notification';   
					
		$whereArray				= array(" 1 ORDER BY created DESC ");
		
		$results					= $dbObj->selectData($table,$whereArray);
	
		return $results;
	}
	function statusUpdate($sid,$st){
	global $dbObj;
	$mtable =TABLE_ISSUES;
	$valueAr['istatus'] =$st; 
	$whereArray=array("`id`='$sid'");
	$result = $dbObj->updateData($mtable, $valueAr,$whereArray);
	}
	function statusName($sid){
		global $dbObj;
		$mtable =TABLE_STATUS;
		$sql="select sname from $mtable where id=$sid";
		$result = $dbObj->getOneRow($sql);
		return $result['sname'];
		
	}
 
	function getReplyDetails($iid) {
	    global $dbObj;
		$table =TABLE_REPLIES;   
					
		$whereArray				= array(" `iid`='$iid' ORDER BY created DESC ");
		
		$results					= $dbObj->selectData($table,$whereArray);
	
		return $results;
	}
	function smsSend($to,$message)
     {
         $message= urlencode($message);
        $sendUrl = "http://smslogin.mobi/spanelv2/api.php?username=IMAFSS&password=Fss@123&to=91".$to."&from=IMAFSS&message=".$message;

         if (function_exists('curl_init')) {
             $ch = curl_init();      // initialize a new curl resource
             curl_setopt($ch, CURLOPT_URL, $sendUrl);      // set the url to fetch
             curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);// Personally I prefer CURLAUTH_ANY as it covers all bases
             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// common name and also verify that it matches the hostname    provided)
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_HEADER, 0); // don't give me the headers just the content
             $content = curl_exec($ch);
             $error = curl_error($ch);

             curl_close($ch); // remember to always close the session and free all resources
         }else{
                      // curl library is not installed so we better use something else

             file_get_contents($sendUrl);
         }
         if(!$error){
             return "success";
         }else{
             return $error;
         }
    }
?>
