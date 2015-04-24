<?php

function reorder(){

	$s2 = file_get_contents('menudata.txt');
  $a2 = unserialize($s2);
/*
	echo '<pre>';
    echo htmlspecialchars(print_r($a2, true));
    echo '</pre>';
*/
$flag=false;
foreach ($_POST["re_order"] as $key => $value){
$reorder0[$key] = (($_POST["re_order"][$key])- 1);
}

//---pre-calc-----------

foreach ($reorder0 as $key => $value){
	if (($key != $value)and($key < $value)){
	$change[$key]=$value - $key;
	
	}
}
 unset($value);

 
foreach ($reorder0 as $key => $value){
	if($key == $value){
	$same[$key]=$value;
	}
	if($key != $value){$flag=true;//tell fixer to fix
	$seqcheck[$key]=$value;
	}
}
  unset($value);

asort($seqcheck);
$seqcheck=array_flip($seqcheck);


foreach ($seqcheck as $key => $value){
	if($key != $value){
	$seqcheck2[]=array("orig"=>$value, "neword"=>$key);
	}
}
  unset($value);
//---over-complictated
foreach ($seqcheck2 as $key => $value){
	if(@$seqcheck2[$key]['neword']+1==@$seqcheck2[$key+1]['neword']){//next is sequence
		if((@$seqcheck2[$key]['neword']-1!=@$seqcheck2[$key-1]['neword'])
		or(!isset($seqcheck2[$key-1]['neword']))){
			$seqcheck3[($seqcheck2[$key]['neword'])]=array("neword"=>$seqcheck2[$key]['neword'], "orig"=>$seqcheck2[$key]['orig'], "start"=>true, "block"=>true);
		}else{
		$seqcheck3[($seqcheck2[$key]['neword'])]=array("neword"=>$seqcheck2[$key]['neword'], "orig"=>$seqcheck2[$key]['orig'], "block"=>true);
		}	
	$seqcheck3[($seqcheck2[$key+1]['neword'])]=array("neword"=>$seqcheck2[$key+1]['neword'], "orig"=>$seqcheck2[$key+1]['orig'], "block"=>true);//$seqcheck3[($seqcheck2[$key]['neword'])] has issues with not labeling block, when being assigned to new key
	}
	if(!@$seqcheck3[$key]['block'])$seqcheck3[($seqcheck2[$key]['neword'])]=array("neword"=>$seqcheck2[$key]['neword'], "orig"=>$seqcheck2[$key]['orig'], "alone"=>true);
}
  unset($value);
 // $start=0;--unnecessary labeling----
foreach ($seqcheck3 as $key => $value){
	if($seqcheck3[$key]['start']==true){
	$start=$key;
	$inc=0;}
	if($seqcheck3[$key]['block']==true){
	$seqcheck3[$start]['rows']=++$inc;
	
	}
}
    unset($value);
  $i=0;
 foreach ($same as $key => $value){
 
 $same2[]=array("neword"=>$i++, "orig"=>$value);
 }
  //---------combine same list with edited list---
foreach ($same2 as $key => $value){$done =false;


		if(!isset($seqcheck3[$key])){
		$seqcheck3[$key]=array("neword"=>$key, "orig"=>$same2[$key]['orig']);$done =true;ksort($seqcheck3);
		}elseif(isset($seqcheck3[$key])and $done==false){$Start=$key;
		
		while(isset($seqcheck3[++$Start])){echo'start:'.$Start;}
		$seqcheck3[$Start]=array("neword"=>$Start, "orig"=>$same2[$key]['orig']);$done =true;ksort($seqcheck3);
	
	}}  unset($value);
	
	 foreach ($seqcheck3 as $key => $value){
	$orig=$seqcheck3[$key]['orig'];
	 
	 $a3[]=$a2[$orig];
	 }unset($value);
	$a2= $a3; 
	
//------Level and order fixer---------	

	if($flag==true){$levs=array(0=>0);
	foreach($a2 as $key => $value){
		if($key==0){$a2[$key]['level']=0;$a2[$key]['level_order']=0;}elseif($key>0){
			foreach($levs as $key2 => $value2){
				if($a2[$key]['level']==$key2)
				{$a2[$key]['level_order']=$levs[$key2]+=1;
						
				}elseif(($a2[$key]['level']>$key2)and(!isset($levs[$key2+1])))//if larger than current level declare first and start a new counter in $levs for that level
				{$levs[$key2+1]=0;
						$a2[$key]['level_order']=0;
					
						if($a2[$key]['level']>$a2[$key-1]['level']+1){
						
						$a2[$key]['level']=$a2[$key-1]['level']+1;
						}
				}

			}
		}
	}
	}
	$s = serialize($a2); 
 // store 
  file_put_contents('menudata.txt', $s);	

}

?>