 <?php 
 /*$simdb = array();


$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'0', "text"=>'0Home', "link"=>'http://www.xomaster.com', "custom"=>'<img/>');
	
$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'1', "text"=>'1Products<br>& Services', "link"=>'services.html');
	
$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'2', "text"=>'2Products & Services', "link"=>'services.html');
$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'3', "text"=>'3Products & Services', "link"=>'services.html');

$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'4', "text"=>'4Products & Services', "link"=>'services.html');

	$simdb[]=array("type"=>'Link', "level"=>'1', "level_order"=>'0', "text"=>'0Menu Manager',"link"=>'pro_files/menumanager.php');
	
		$simdb[]=array("type"=>'Link', "level"=>'2', "level_order"=>'0', "text"=>'1RSTMenu Manager',"link"=>'pro_files/menumanager.php');
		
		$simdb[]=array("type"=>'Link', "level"=>'2', "level_order"=>'1', "text"=>'2Menu Manager',"link"=>'pro_files/menumanager.php');
		
	
	//-------Handle Incoming requests
$addarray = array();
$addarray[]=array("leveladd"=>'0', "level_orderadd"=>'0', "test"=>'zero' );
$addarray[]=array("leveladd"=>'0', "level_orderadd"=>'1', "test"=>'one' );
//		//	//	$addarray[]=array("leveladd"=>'0', "level_orderadd"=>'2', "test"=>'two' );
$addarray[]=array("leveladd"=>'0', "level_orderadd"=>'5', "test"=>'five' );			
	//  $addarray[]=array("leveladd"=>'0', "level_orderadd"=>'3', "test"=>'three' );
//$addarray[]=array("leveladd"=>'0', "level_orderadd"=>'4', "test"=>'five' );

//$addarray[]=array("leveladd"=>'2', "level_orderadd"=>'1', "test"=>'1L1zero' );				
//$addarray[]=array("leveladd"=>'2', "level_orderadd"=>'5', "test"=>'L1one' );			
	$addarray[]=array("leveladd"=>'2', "level_orderadd"=>'6', "test"=>'3Eight', "type"=>'a' );
$addarray[]=array("leveladd"=>'2', "level_orderadd"=>'7', "test"=>'0ten' );*/
function add(){		
$s2 = file_get_contents('menudata.txt');
  $simdb = unserialize($s2);

	
	$addalist=0;
   foreach ($_POST["typeadd"] as $key => $value){
if($_POST['typeadd'][$key]!=null){if($_POST['listaddition']==true){$addalist=true;}
   
   
$addarray[$key]['typeadd'] = $_POST['typeadd'][$key]; 
$addarray[$key]['leveladd'] = $_POST['leveladd'][$key];
$addarray[$key]['level_orderadd'] = $_POST['level_orderadd'][$key];
$addarray[$key]['Textadd'] = $_POST['Textadd'][$key];
$addarray[$key]['Linkadd'] = $_POST['Linkadd'][$key];
$addarray[$key]['customadd'] = $_POST['customadd'][$key];
if($_POST['listaddition']==true){$addarray[$key]['addlist'] = true;}
 
 }}
 
	//-----Sort by level----& separate new list items
	foreach($addarray as $key => $value){
		
		$a[]=$addarray[$key]["leveladd"];
	
	}
		
	function cmp($a, $b) {
		if ($a == $b) {
		return 0;
		}
	return ($a < $b) ? -1 : 1;
	}

uasort($a, 'cmp');


//-----Build by level order
foreach($a as $key => $value){
$b[$key]=$addarray[$key]["level_orderadd"];
	}
	ksort($b);
	
$c=array_values($a);

//--------------combine into new sorted array $d, each key is assigned: level => level order 
foreach($c as $key => $value){
$d[$key][$value]=$b[$key];
	}
	//--------------count amount of additions to each seperate level 	
$f=array_count_values($c);
$bylevel=$f;

	//-------SORT ADDARRAY
	
	
	function cmp1($a, $b) {
		if ($a == $b) {
		return 0;
		}
	return ($a["leveladd"] < $b["leveladd"]) ? -1 : 1;
	}
	
	uasort($addarray, 'cmp1');	
		$addarray=array_values($addarray);//
			
//	echo '<pre>Addarray';
//    echo htmlspecialchars(print_r($addarray, true));
 //   echo '</pre>';
 
//----build seperate arays for each level
	foreach($bylevel as $key => $value){ $i=0;
	$i=$i+$LevelUp;
	$value=$LevelUp+$value;
	$LevelUp=$i;
		while($i<$value){echo $addarray[$i];
		$add[$key][]=$addarray[$i];$LevelUp++;
		$i++;}
	}
	
	
		function cmp2($a, $b) {
		if ($a == $b) {
		return 0;
		}
	return ($a["level_orderadd"] < $b["level_orderadd"]) ? -1 : 1;
	}
	
/*echo '<pre>Add';
    echo htmlspecialchars(print_r($add, true));
    echo '</pre>';*/
foreach($add as $key => $value){
uasort($add[$key], 'cmp2');	
		$addarray2=array_values($add);//
}

foreach($addarray2 as $key => $value){
$addarray2[$key]=array_values($addarray2[$key]);//

}
unset($addarray);
foreach($addarray2 as $key => $value){
	foreach($addarray2[$key] as $key2 => $value){
$addarray[]=$addarray2[$key][$key2];
	}
}
//-----Should be re-assembled by now----------------------


	//----------Build Clusters-----------

	
	foreach($addarray as $key => $value){ 	//Single
			if(($addarray[$key]['level_orderadd']<((@$addarray[$key+1]['level_orderadd'])-1))
			or($addarray[$key]['level_orderadd']>((@$addarray[$key-1]['level_orderadd'])+1))
		
		
	or(count($addarray[$key]['leveladd'])==1)){
			$list[$key]=$addarray[$key];
			
			}
		if($addarray[$key]['level_orderadd']==((@$addarray[$key+1]['level_orderadd'])-1)){
	
	//Cluster	
	
		$list[$key]=$addarray[$key];if($addarray[$key]['leveladd']==((@$addarray[$key+1]['leveladd']))){$list[$key]['cluster']='true';}
			if((( $addarray[$key]['level_orderadd'])-1)!==$addarray[$key]['level_orderadd']){
			$list[]=$addarray[$key+1];}}
			
		
	}	
	foreach($list as $key => $value){
		if(($list[$key]['cluster']=='true')
		and(((@$list[$key+1]['level_orderadd'])-1)==($list[$key]['level_orderadd']))){
		
		$list[$key+1]['single']='false';
		}	
	}
		//---Finish labeling-----------
	foreach($list as $key => $value){
		
		if(($list[$key]['cluster']=='true')or($list[$key]['single']=='false')){
		$list[$key]['cluster']='true';unset($list[$key]['single']);
		}
		else{$list[$key]['single']='true';}
	}
	
/*
	echo '<hr><hr><pre>list';
    echo htmlspecialchars(print_r($list, true));
    echo '</pre><hr><hr>';
	
	*/
	
	//-------Calculate Final positions----------
	unset($value);
	foreach($list as $key => $value){
		if(($list[$key]['cluster']=='true')
		and($list[$key+1]['cluster']=='true')
		and($list[$key]['leveladd']==((@$list[$key+1]['leveladd'])))
		and(($list[$key-1]['single']=='true')or(!isset($list[$key-1])
		or(($list[$key]['level_orderadd']>$list[$key-1]['level_orderadd']+1)
		and($list[$key]['level_orderadd']==$list[$key+1]['level_orderadd']-1))
		or(($list[$key]['cluster']=='true')
		and($list[$key]['leveladd']!==((@$list[$key-1]['leveladd']))))))){//first in cluster
		unset($newlist);
			if($list[$key]['leveladd']!==((@$list[$key-1]['leveladd']))or(($list[$key]['leveladd']!==((@$list[$key+1]['leveladd']))))){$increase=0;}

		$list[$key]['newlevel_order']=$increase+$list[$key]['level_orderadd'];	
		
		$newlist[$key]=$list[$key];
		$newlist[$key]['first']='true';
			
		$inc=$key;
			while(($list[++$inc]['cluster']=='true')and($list[$inc]['level_orderadd']==$list[$inc-1]['level_orderadd']+1)){// the rest 
			$list[$inc]['newlevel_order']=$increase+$list[$inc]['level_orderadd'];
			$newlist[]=$list[$inc];
			}
		$increaser=$inc-$key;
		$newlist[$key]['rows']=$inc-$key;
		$increase+=$increaser;	
		$list2[]=$newlist;
		}
		if($list[$key]['single']=='true'){
					
			if((!isset($list[$key+1])and($list[$key]['leveladd']==((@$list[$key-1]['leveladd']))))or($list[$key]['leveladd']!==@$list[$key+1]['leveladd'])and(isset($list[$key+1]['leveladd']))
			or(($list[$key]['level_orderadd']>$list[$key-1]['level_orderadd']+1))){//single
			$list[$key]['newlevel_order']=$increase+$list[$key]['level_orderadd'];
			$increase++;
			$list2[]=$list[$key];
			}
				else if($list[$key]['leveladd']!==((@$list[$key-1]['leveladd']))
				or(($list[$key]['leveladd']!==((@$list[$key+1]['leveladd']))))){
				$increase=0;
				$list[$key]['newlevel_order']=$increase+$list[$key]['level_orderadd'];
				$list2[]=$list[$key];$increase++;
				}	
		
		}
	}		
	

		
	//---------------SWITCH START----------
	$current_level=0;
	foreach($list2 as $key => $value){
		if($list2[$key]['single']=='true'){
		$i='one';
		}
		if($list2[$key]['single']!=='true'){
		$i='cluster';
		}
		
		switch ($i) {
    case 'one':	echo$done=false;
		foreach($simdb as $key2 => $value2){	
			if(($list2[$key]['newlevel_order']==$simdb[$key2]['level_order'])//to add to end of current list, not beginning of next add 1
			and($list2[$key]['leveladd']==$simdb[$key2]['level'])){
      
			$numrowsSimdb = count($simdb);
			$current_level=$simdb[$key2]['level'];
					
			while ($key2 < $numrowsSimdb--){										//	echo'<BR>currentLEVEL: '.$simdb[$key2]['level'].'<BR>';
				if(($simdb[$numrowsSimdb]['level']==$current_level)
				and($simdb[$numrowsSimdb]['level']==$simdb[$key2]['level'])){		//	echo'<BR>LEVEL: '.$simdb[$key2]['level'].'<BR>';echo'lEVEL: '.$simdb[$numrowsSimdb]['level'];
				$simdb[$numrowsSimdb]['level_order'] = 1+($simdb[$numrowsSimdb]['level_order']);
				}
				if($current_level==$simdb[$key2]['level']){$simdb[($numrowsSimdb + 1)] = $simdb[($numrowsSimdb)];}
				}
			$simdb[$key2]['type']=@$list2[$key]['typeadd'];
			$simdb[$key2]['level']=@$list2[$key]['leveladd'];
			$simdb[$key2]['level_order']=((@$list2[$key]['newlevel_order']));
			$simdb[$key2]['text']=@$list2[$key]['Textadd'];
			$simdb[$key2]['link']=@$list2[$key]['Linkadd'];
			$simdb[$key2]['custom']=@$list2[$key]['customadd'];
			$simdb[$key2]['list']=@$list2[$key]['addlist'];
			$done=true;}
		}					

//-------------single high-------------
		foreach($simdb as $keya => $valuea){	
			if(($list2[$key]['newlevel_order']>$simdb[$keya]['level_order'])
			and($list2[$key]['leveladd']==$simdb[$keya]['level'])){	echo'simkeyKeya: '.$keya;echo'key:'.$key; 
			$keyfin=$keya;//Find final level order that matches new level
			}
		}
		if(($list2[$key]['newlevel_order']>$simdb[$keyfin]['level_order'])
		and($list2[$key]['leveladd']==$simdb[$keyfin]['level'])
		and($done==false)){
		$numrowsSimdb = count($simdb);
			while ($keyfin+1 < $numrowsSimdb--){				//	make room in list
				if($list2[$key]['leveladd']==$simdb[$keyfin]['level']){
				$simdb[($numrowsSimdb + 1)] = $simdb[($numrowsSimdb)];
				}
			}
			$simdb[$keyfin+1]['type']=@$list2[$key]['typeadd'];
			$simdb[$keyfin+1]['level']=@$list2[$key]['leveladd'];
			$simdb[$keyfin+1]['level_order']=(1+($simdb[$keyfin]['level_order']));
			$simdb[$keyfin+1]['text']=@$list2[$key]['Textadd'];
			$simdb[$keyfin+1]['link']=@$list2[$key]['Linkadd'];
			$simdb[$keyfin+1]['custom']=@$list2[$key]['customadd'];
		$simdb[$keyfin+1]['list']=@$list2[$key]['addlist'];
		}/**/
        break;		

	case 'cluster':	$donem=false;
		foreach($list2[$key] as $key3 => $value3){$zero=0;//---cluster----3
			foreach($simdb as $key4 => $value4){//---Simdb----4
				if(($list2[$key][$key3]['newlevel_order']==$simdb[$key4]['level_order'])	
				and($list2[$key][$key3]['leveladd']==$simdb[$key4]['level'])){
					if($list2[$key][$key3]['first']=='true'){
					$rows=$list2[$key][$key3]['rows'];
					}
					$numrowsSimdb2 = count($simdb);$numrowsSimdb3 = count($simdb);
					$current_level=$simdb[$key4]['level'];
					if($list2[$key][$key3]['first']=='true'){
				
						while ($key4 < $numrowsSimdb2--){
							if($simdb[$numrowsSimdb2]['level']==$current_level){
							$simdb[$numrowsSimdb2]['level_order'] = ($rows)+($simdb[$numrowsSimdb2]['level_order']);//------re-order
							}
						}
						while ($key4 < $numrowsSimdb3--){
						$current_level=$simdb[$key4]['level'];
							if($list2[$key][$key3]['leveladd']==$current_level){
							$simdb[($numrowsSimdb3+($rows))] = $simdb[($numrowsSimdb3)];//------make room for additions----makes last few bckwards--hence ksortprint$simdb;
							}
						}
						if($current_level==$simdb[$key4]['level']){//--add new items
									
							foreach($list2[$key] as $key5 => $value5){//!

							$simdb[$key4+$zero]['type']=@$list2[$key][$key5]['typeadd'];
							$simdb[$key4+$zero]['level']=@$list2[$key][$key5]['leveladd'];
							$simdb[$key4+$zero]['level_order']=((@$list2[$key][$key5]['newlevel_order']));
							$simdb[$key4+$zero]['text']=@$list2[$key][$key5]['Textadd'];
							$simdb[$key4+$zero]['link']=@$list2[$key][$key5]['Linkadd'];
							$simdb[$key4+$zero]['custom']=@$list2[$key][$key5]['customadd'];
$simdb[$key4+$zero]['list']=@$list2[$key][$key5]['addlist'];
								$zero++;
							}
						}	ksort($simdb);$donem=true;
					}	
				}		
			}
		}
	//-------------cluster high-------------
		 foreach($list2[$key] as $key3b => $value3b){$zeroa=0;//---cluster----3
			foreach($simdb as $keyb => $valueb){//---Simdb----4
			if(($list2[$key][$key3b]['newlevel_order']>$simdb[$keyb]['level_order'])
			and($list2[$key][$key3b]['leveladd']==$simdb[$keyb]['level'])
			and($list2[$key][$key3b]['first']=='true')){
			$keyfinal=$keyb;//Find final level order that matches new level
			}
		}
						if(($list2[$key][$key3b]['newlevel_order']>$simdb[$keyfinal]['level_order'])
				and($simdb[$keyfinal]['level']==$list2[$key][$key3b]['leveladd'])
				and($donem==false)){
					if($list2[$key][$key3b]['first']=='true'){
					$rows=$list2[$key][$key3b]['rows'];
					}
					$numrowsSimdb3a = count($simdb);
					$current_level=$simdb[$keyfinal]['level'];
					if($list2[$key][$key3b]['first']=='true'){
				
						while ($keyfinal-1 < $numrowsSimdb3a--){
						$current_level=$simdb[$keyfinal]['level'];
							if($list2[$key][$key3b]['leveladd']==$current_level){
							$simdb[($numrowsSimdb3a+($rows))] = $simdb[($numrowsSimdb3a)];//------make room for additions----makes last few bckwards--hence ksortprint$simdb;
							}
						}
						if($current_level==$list2[$key][$key3b]['leveladd']){//--add new itemssame effect Ithinks as no if statement
									
							foreach($list2[$key] as $key5b => $value5b){//!

							$simdb[$keyfinal+$zeroa+1]['type']=@$list2[$key][$key5b]['typeadd'];
							$simdb[$keyfinal+$zeroa+1]['level']=@$list2[$key][$key5b]['leveladd'];
							$simdb[$keyfinal+$zeroa+1]['level_order']=($simdb[$keyfinal+$zeroa]['level_order']+1);
							$simdb[$keyfinal+$zeroa+1]['text']=@$list2[$key][$key5b]['Textadd'];
							$simdb[$keyfinal+$zeroa+1]['link']=@$list2[$key][$key5b]['Linkadd'];
							$simdb[$keyfinal+$zeroa+1]['custom']=@$list2[$key][$key5b]['customadd'];
							$simdb[$keyfinal+$zeroa+1]['list']=@$list2[$key][$key5b]['addlist'];
								$zeroa++;
							}
						}	ksort($simdb);
					}	
				}		
			}
		break;
		}
	}
	/*
	echo '<hr><pre>';
    echo htmlspecialchars(print_r($simdb, true));
    echo '</pre><hr>';
 */
// make new lists
unset($value);
foreach($simdb as $key => $value){

	if((@$simdb[$key]['list']==true))
	{//-----single new list
	$keylchk=$key;
	$level_count=0;
	$i=1;	$simdb[$key]['level']=$simdb[$key]['level']+1;
		
		while($keylchk-->0){//-----count number on same new level
		if($simdb[$key]['level']==$simdb[$keylchk]['level']){$level_count++;}
		}$simdb[$key]['level_order']=$level_count;
	
		
		$keylchk2=$key;
			
		$simcount=count($simdb);
		
		foreach($simdb as $key8 => $value8){
			if($key8>$keylchk2){
				if(($simdb[$key8]['level']==$simdb[$key]['level'])){
				$simdb[$key8]['level_order']=$simdb[$key8]['level_order']+1;//----reindex new level 
				}
				if($simdb[$key8]['level']==$simdb[$key]['level']-1){
				$simdb[$key8]['level_order']=$simdb[$key8]['level_order']-1;//----reindex level left behind
				}
			}
		}
	}

}
unset($value);
foreach($simdb as $key => $value){unset($simdb[$key]['list']);}
$a2=$simdb;


  	$s = serialize($simdb);
  
   // store 
  file_put_contents('menudata.txt', $s);

}


 
?>