<?php /*error_reporting(0);
$test = '';
$simdb = array();


$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'0', "text"=>'Home', "link"=>'http://www.xomaster.com', "custom"=>'<img/>');
	
$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'1', "text"=>'Products<br>& Services', "link"=>'services.html');
	
$simdb[]=array("type"=>'Link', "level"=>'1', "level_order"=>'0', "text"=>'Products<br>& Services',  "link"=>'pro_files/menumanager.php');

	

		//----------		$simdb[]=array("level"=>'2', "level_order"=>'0', "link"=>'<a><p text-align="center"><font color="#fff">$24.99<br>SEE MORE!</font></p><img class="menuimages;" src="menupics/crystalballs/60mm Lead Crystal Ball w stand.jpg"/></a>');



<div style="max-width:25%;"><nav><?php include_once('system/menu/prep_content_side.php');?></nav></div>

$serial = $simdb;

	$s = serialize($serial); 
 // store 
  file_put_contents('pro_files/menudata.txt', $s);

*/


  
  
//  echo 


  $s2 = @file_get_contents($_SERVER['DOCUMENT_ROOT'].'/system/menu/menudata.txt');
  $simdb2 = unserialize($s2); 
/*  @$www='http://';
    if (substr($_SERVER['SERVER_NAME'], 0, 4) === 'www.')
{
    @$www.='www.';
}
  */
$server=$_REQUEST['req'];

$partsreq = explode('/', $server);
$preqc=$partsreq[count($partsreq)-1];
  $ia=-1;
foreach (@$simdb2 as $key => $value) {
//	if($simdb2[$key]['level']==0){}
		$ia++;
		
		
		
	if(@$simdb2[$key]['type']=='Link'){
		
	$partslink = explode('/', $simdb2[$key]['link']);
		$plink=$partslink[count($partsreq)];
		//echo$preqc;echo$plink;
		
		
		//echo$_REQUEST['req'];//$_SERVER['PHP_SELF'];
		if($plink == $preqc and $preqc !=='' and $match==false){// or ($_REQUEST['req']==''and$simdb2[$key]['link']==''and$key==0)
		$test[($simdb2[$key]['level'])]=$ia;
		$match=true;
		//	var_dump($test);////
		//  echo'here';
		}
		
		if (substr($simdb2[$key]['link'], 0, 4) === 'http'){//https could give issue!
		$link=$simdb2[$key]['link'];}else{$simdb2[$key]['link']=$simdb2[$key]['link'];//BASE_URL.
		}
	}	
}
	
		
unset($value);
foreach (@$simdb2 as $key => $value) {
if(@$simdb2[$key]['type']=='Link'){$add='';
	if($test){
	foreach($test as $level => $value23) {
	if(@$simdb2[$key]['level']==$level and ($value23==$key)){
	$add='select';//echo$value23;echo'-'.$simdb2[$key]['level'];////
	}}
	
  }
  
  if(@$simdb2[$key]['type']=='Link'){
$alt=strip_tags($simdb2[$key]['text'],'');
$simdb2[$key]['text']=$alt;
  if($add=='select'){
	$simdb2[$key]['link_text']=$simdb2[$key]['link'];
	$simdb2[$key]['link']='<a class="'.$add.'" href="'.$simdb2[$key]['link'].'">'.$simdb2[$key]['text'].'</a>'; /*title="'.$alt.'"*/
	
	}else{
	$simdb2[$key]['link_text']=$simdb2[$key]['link'];
	$simdb2[$key]['link']='<a href="'.$simdb2[$key]['link'].'">'.$simdb2[$key]['text'].'</a>';/*title="'.$alt.'"*/
	
	}
  
  }else{
  	if($add=='select'){//$simdb2[$key]['link_text']=$simdb2[$key]['link'];
	$simdb2[$key]['link']='<a class="'.$add.'" href="'.$simdb2[$key]['link'].'">'.$simdb2[$key]['text'].'</a>';
	
	}else{
	//$simdb2[$key]['link_text']=$simdb2[$key]['link'];
	$simdb2[$key]['link']='<a href="'.$simdb2[$key]['link'].'">'.$simdb2[$key]['text'].'</a>';
	
	}

}

}
}
  foreach (@$simdb2 as $key => $value) {
if(@$simdb2[$key]['type']=='Label'){
$simdb2[$key]['link']=$simdb2[$key]['text'];
$simdb2[$key]['link_text1']=$simdb2[$key]['text'];
}
  }
  foreach (@$simdb2 as $key => $value) {
if(@$simdb2[$key]['type']=='Custom'){
$simdb2[$key]['link']=$simdb2[$key]['custom'];

}
  }
  /* $CONNECT THE DOTS */
 unset($value);$parent =0;
foreach (@$simdb2 as $key => $value) {$found = false;
	$task_id=1 + $key;	
	if($key==0){
		$tasks[$parent][$task_id]['link']=$simdb2[$key]['link'];
		$tasks[$parent][$task_id]['text']=$simdb2[$key]['text'];
		$tasks[$parent][$task_id]['level']=$simdb2[$key]['level'];
		$tasks[$parent][$task_id]['link_text']=$simdb2[$key]['link_text'];
		$simdb2[$key]['parent']=$parent;
	}
	
	if($simdb2[$key]['level'] == 0 ){
		$tasks[0][$task_id]['link']=$simdb2[$key]['link'];	
		$tasks[0][$task_id]['text']=$simdb2[$key]['text'];
		$tasks[0][$task_id]['level']=$simdb2[$key]['level'];
		$tasks[0][$task_id]['link_text']=$simdb2[$key]['link_text'];
		$simdb2[$key]['parent']=0;
			
	}else if(($simdb2[$key]['level'] == $simdb2[$key -1]['level']) and $key !==0){
		$tasks[$parent][$task_id]['link']=$simdb2[$key]['link'];
		$tasks[$parent][$task_id]['text']=$simdb2[$key]['text'];
		$tasks[$parent][$task_id]['level']=$simdb2[$key]['level'];
		$tasks[$parent][$task_id]['link_text']=$simdb2[$key]['link_text'];
		$simdb2[$key]['parent']=$parent;

	}else if(($simdb2[$key]['level'] > $simdb2[$key -1]['level']) and $key !==0){
		
		$parent = $key;
		$tasks[$parent][$task_id]['link']=$simdb2[$key]['link'];
		$tasks[$parent][$task_id]['text']=$simdb2[$key]['text'];	
		$tasks[$parent][$task_id]['level']=$simdb2[$key]['level'];	
		$tasks[$parent][$task_id]['link_text']=$simdb2[$key]['link_text'];
		$simdb2[$key]['parent']=$parent;
	}else if($key !==0){//if level is lower than previous: lookup parentid
		$countdown=$key;
		while(--$countdown> 0 and ($found === false)){

			if( (($simdb2[$key]['level'])) == ($simdb2[$countdown]['level'])and $simdb2[$key]['level']!==0){//finds first occurance of same level, needs to find that ones parent
				$parent= $simdb2[$countdown]['parent'];			
				$tasks[$parent][$task_id]['link']=$simdb2[$key]['link'];
				$tasks[$parent][$task_id]['text']=$simdb2[$key]['text'];
				$tasks[$parent][$task_id]['level']=$simdb2[$key]['level'];	
				$tasks[$parent][$task_id]['link_text']=$simdb2[$key]['link_text'];		
				$simdb2[$key]['parent']=$parent;					
				if($parent<0){$parent=0;}//.'first';
				$found = true;
			}
			if($simdb2[$countdown]['level']==0 and $found == false){
				$parent=$countdown;if($parent<0){$parent=0;}
				$tasks[$parent][$task_id]['link']=$simdb2[$key]['link'];
				$tasks[$parent][$task_id]['text']=$simdb2[$key]['text'];
				$tasks[$parent][$task_id]['level']=$simdb2[$key]['level'];
				$tasks[$parent][$task_id]['link_text']=$simdb2[$key]['link_text'];
				$simdb2[$key]['parent']=$parent;
				$found = true;
			}
		}
	}
}
		
	/* echo '<pre>';
    echo htmlspecialchars(print_r($tasks, true));
    echo '</pre>';
		
		 */  
		
		foreach ($tasks as $task_id => $todo){
			foreach ($tasks[$task_id] as $task_ids => $todos){//echo$task_id;
			/*if($todos['link_text']){
			$last=count($partlink = explode('/', $todos['link_text']));
			}else{*/$last=count($partlink = explode('/', $todos['link_text'])); //echo$last;//}
		//echo $testlink=$partlink[$todos['level']+3];
				foreach ($partsreq as $key => $link){
					if( $partlink[$last-1] !=''){
				
						/*echo'last'.$partlink[$last-1];echo'<br>';
					echo'link'.$link;
					echo'<hr>';*/
						if(str_replace("-", " ", strtolower($link))==str_replace("-", " ", strtolower($partlink[$last-1]))){
						/*
						
						echo'match'.$link;
						echo$task_id;
						echo'todo'.$partlink[$last-1];*/
						//echo$task_ids;
						$check_list[]=$task_ids;
						$check_list[]=$task_id;
						$check_this=$task_id;
						
						}
				
				
					}
				}	
			}
		}
		/* */
		
		
		//echo$tasks[0][1]['link'];
		
		
		function open_list($tasks, $check_this, $check_list){
			if($check_this !=''){
			foreach ($tasks as $task => $todos){
				foreach ($tasks[$task] as $task1 => $todos1){//echo'todos:'.$task.'<br>';//echo$check_this;
				if($task1==$check_this){
				$check_list[]=$task;
				$check_this=$task;
				//
				
				if($task >0){
				open_list($tasks, $check_this, $check_list);}
			return $check_list;
				}}
				}
			
			
			
			//echo'task:'.$task;

			/*
				if($todos){$check_list[]=$task_id;}
				
				$check_list[]=$task;
				if(isset($tasks[$task_id])){
				open_list($tasks, $check_list[0], $check_this, $check_list);
			}
			*/
			
			}
		 
		 }
		 if($check_this!=0){
	$check_list=open_list($tasks,$check_this,$check_list);
		 }
		
		 
		 
		 /* echo '<pre>';
    echo htmlspecialchars(print_r($check_list, true));
    echo '</pre>';
		 */
		 
  function make_list($parent,$tasks,$partsreq,$check_list){
	
	$pace.='';
	//global ;$tasks,$partsreq
	
	
	if($parent == $tasks[0] ){echo'
<ol class="tree">
',$pace,(1 /*@strtolower($partsreq[0])!==''*/ ? ( 1 /*@strtolower($partsreq[0]) !== 'home'*/ ?'<li><label for="Home"><a href="/">Home</a></label> <input type="checkbox" id="Home" /></li>
	':''):'');}
	else{ echo"
$pace<ol>
";}


		
		foreach ($parent as $task_id => $todo){
$checked='';
if(is_array($check_list)){
foreach($check_list as $key => $tocheck){
if($tocheck == $task_id ){
$checked='checked';
}
}
}
$item="<li><label for='".str_replace(' ', '-', $todo['text'])."'>".$todo['link']."</label> <input type='checkbox' $checked id='".str_replace(' ', '-', $todo['text'])."' />";
if($todo['link_text']!=''){

$partlink = explode('/', $todo['link_text']);
$testlink=$partlink[$todo['level']+3];
$cselect=$partlink[$todo['level']+3];
}else{$testlink=$todo['text'];}


if(str_replace("-", " ", strtolower($partsreq[$todo['level']]))==str_replace("-", " ", strtolower($testlink))){
$item="<li><label for='".str_replace(' ', '-', $todo['text'])."'>".$todo['link']."</label> <input $checked type='checkbox' id='".str_replace(' ', '-', $todo['text'])."' />";
}

		if(isset($tasks[$task_id]) or $parent == $tasks[0]){ echo$item;}else if
	
		(!isset($tasks[$task_id]))echo"$pace<li class='file'>",$todo['link'];	
		
		
			if(isset($tasks[$task_id])){
			make_list($tasks[$task_id],$tasks,$partsreq,$check_list);
			}
			
			echo"</li>
";
			}
	
  echo"$pace</ol>
";//$pace=substr($pace, 0, -1);
  
  }
    
 make_list($tasks[0],$tasks,$partsreq,$check_list);// make_list($tasks[0]);
 
 
