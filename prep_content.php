<?php error_reporting(0);/*
$test = '';
$simdb = array();


$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'0', "text"=>'Home', "link"=>'http://www.xomaster.com', "custom"=>'<img/>');
	
$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'1', "text"=>'Products<br>& Services', "link"=>'services.html');
	
$simdb[]=array("type"=>'Link', "level"=>'1', "level_order"=>'0', "text"=>'Products<br>& Services',  "link"=>'pro_files/menumanager.php');

	

		//----------		$simdb[]=array("level"=>'2', "level_order"=>'0', "link"=>'<a><p text-align="center"><font color="#fff">$24.99<br>SEE MORE!</font></p><img class="menuimages;" src="menupics/crystalballs/60mm Lead Crystal Ball w stand.jpg"/></a>');





$serial = $simdb;

	$s = serialize($serial); 
 // store 
  file_put_contents($_SERVER['DOCUMENT_ROOT'].'/system/menu/menudata.txt', $s);


*/

  
  
//  echo 
  

if($s2 = @file_get_contents("system/menu/menudata.txt")){$done=1;
  $simdb2 = unserialize($s2);}else{
  
  $s2 = @file_get_contents("../system/menu/menudata.txt");
  $simdb2 = unserialize($s2);
  $s2 = @file_get_contents($_SERVER['DOCUMENT_ROOT'].'/system/menu/menudata.txt');
  $simdb2 = unserialize($s2); }
  @$www='http://';
    if (substr($_SERVER['SERVER_NAME'], 0, 4) === 'www.')
{
    @$www.='www.';
}
  
$server=$_REQUEST['req'];

$partsreq = explode('/', $server);

  $ia=-1;
foreach (@$simdb2 as $key => $value) {
	if(@$simdb2[$key]['type']=='Link'){
		if($simdb2[$key]['level']==0){
		$ia++;}
		//echo$_REQUEST['req'];//$_SERVER['PHP_SELF'];
		if($simdb2[$key]['link']=='/'.$partsreq[0] or ($_REQUEST['req']==''and$simdb2[$key]['link']=='')){
		$test[]=$ia;
		 
		}
		
		if (substr($simdb2[$key]['link'], 0, 4) === 'http'){//https could give issue!
		$link=$simdb2[$key]['link'];}else{$simdb2[$key]['link']=$simdb2[$key]['link'];
		}
	}	
}
		
		

foreach (@$simdb2 as $key => $value) {
if(@$simdb2[$key]['type']=='Link'){$add='';
	if($test){
	foreach($test as $key23 => $value23) {
	if(($value23==@$simdb2[$key]['level_order'])and(0==@$simdb2[$key]['level'])){
	$add='select';
	}}
	
  }
  
  if(@$simdb2[$key]['type']=='Link'){
$alt=strip_tags($simdb2[$key]['text'],'');
  if($add=='select'){
	$simdb2[$key]['link']='<a class="'.$add.'" href="'.$simdb2[$key]['link'].'">'.$simdb2[$key]['text'].'</a>'; /*title="'.$alt.'" alt="'.$alt.'"*/
	}else{
	$simdb2[$key]['link']='<a href="'.$simdb2[$key]['link'].'">'.$simdb2[$key]['text'].'</a>';/*title="'.$alt.'" alt="'.$alt.'"*/
	}
  
  }else{
  	if($add=='select'){
	$simdb2[$key]['link']='<a class="'.$add.'" href="'.$simdb2[$key]['link'].'">'.$simdb2[$key]['text'].'</a>';
	}else{
	$simdb2[$key]['link']='<a href="'.$simdb2[$key]['link'].'">'.$simdb2[$key]['text'].'</a>';
	}

}

}
}
  foreach (@$simdb2 as $key => $value) {
if(@$simdb2[$key]['type']=='Label'){
$simdb2[$key]['link']=$simdb2[$key]['text'];

}
  }
  foreach (@$simdb2 as $key => $value) {
if(@$simdb2[$key]['type']=='Custom'){
$simdb2[$key]['link']=$simdb2[$key]['custom'];

}
  }
  /*
$avasaa = $simdb2[$key]['link'];
 echo "$avasaa";
  */
  
  
  

//----------
$i=0;
$i2=0;
 foreach ($simdb2 as $key => $value) {
switch ($simdb2[$key]['level']) {
    case "0": //echo 'c0'; 	
	$i=0; $i2=0;
	$menu_order = ($simdb2[$key]['level_order']);

$a[$menu_order][0][0][0]['data'] = array(
	"level"=>$simdb2[$key]['level'], 
	"link"=>$simdb2[$key]['link']); 
		break;
        
	case "1": //echo 'c1';
$i++;	$i2=0;
	$a[$menu_order][][0][0]['data'] = array(
	"level"=>$simdb2[$key]['level'], 
	"link"=>$simdb2[$key]['link']);  //echo $menu_order;
		break;
     		
	case "2": //echo 'c2';
$i2++;		
	$a[$menu_order][$i][][0]['data'] = array(
	"level"=>$simdb2[$key]['level'], 
	"link"=>$simdb2[$key]['link']);
		break;
		
	case "3": //echo 'c3';
					
	$a[$menu_order][$i][$i2][]['data'] = array(
	"level"=>$simdb2[$key]['level'], 
	"link"=>$simdb2[$key]['link']); 
		break;
}}	 






//----------