<?php if(!isset($_SESSION)) {
     session_start();
}
require('../config.inc.php');
include('menufunctions/adder.php');
//include('menufunctions/addlist.php');
include('menufunctions/reorder.php');error_reporting(0);
/* start login*/
$username = "compaq420"; //Change to whatever you want your username to be
$password = "carl"; //Change to whatever you want your password to be
if(@$_POST['logout']=='1'){
	
	unset ($_SESSION[SESSION_PREFIX]['logged_in']);

	}
	
if(isset($_POST['submit'])){
	if((htmlspecialchars(strtolower($_POST['username'])) == $username && htmlspecialchars(strtolower($_POST['password'])) == $password) ){
       
  $_SESSION[SESSION_PREFIX]['logged_in']=true;
	
	

} if(isset($_POST['password'])){usleep(5000000);}
	
}
	
	
	if($_SESSION[SESSION_PREFIX]['logged_in']===true){
//doc start
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<script type="text/javascript" language="javascript" charset="utf-8" src="<?php echo SSL_URL;?>/js/jquery1.5.1.min.js"></script> 
<meta name="robots" content="noindex, follow" />
<style type="text/css">
#custom{display:none;}#text{display:none;}#link{display:none;}
</style>

 

 <?php 

 if(true==$_POST['reset']){/*$simdb = array();


$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'0', "text"=>'Home', "link"=>'http://www.xomaster.com', "custom"=>'<img/>');
	
$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'1', "text"=>'Products & Services', "link"=>'services.html');
	
$simdb[]=array("type"=>'Link', "level"=>'0', "level_order"=>'2', "text"=>'Menu Manager',"link"=>'pro_files/menumanager.php');



$serial = $simdb;

	$s = serialize($serial); 
 // store 
  file_put_contents('menudata.txt', $s);*/}



//--------------1. Edit--------2. re-arrange, 3. delete and  #4. add splice might be nice for re-ordering
  
  if ($_POST){
$editnum=$_POST['editnum'];
$thenum=$_POST['adds']['numtoadd'];
	$s2 = file_get_contents('menudata.txt');
  $simdb = unserialize($s2);

  foreach ($_POST["editnum"] as $key => $value){
 $simdb[$key]['type'] = $_POST['type'][$key]; 
 $simdb[$key]['level'] = $_POST['level'][$key];
$simdb[$key]['level_order'] = $_POST['level_order'][$key];
$simdb[$key]['text'] = $_POST['Text'][$key];
$simdb[$key]['link'] = $_POST['Link'][$key];
$simdb[$key]['custom'] = $_POST['custom'][$key];
}  
if($editnum>0){
$a2=$simdb;

$levs=array(0=>0);
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
$simdb=$a2;

}
	$s = serialize($simdb); 
 // store 
  file_put_contents('menudata.txt', $s);
}




//-----------------delete Part 1-----------
	  $s2 = file_get_contents('menudata.txt');
  $a2 = unserialize($s2);
$postdelete=@$_POST;
  foreach (@$_POST["todelete"] as $key => $value){
 /* if ($_POST) {
    echo '<pre>';
    echo htmlspecialchars(print_r($_POST, true));
    echo '</pre>';
}*/

//print_r($delete);echo'<hr>';

$a2[$value]['delete']=true;
}
$serial = $a2;

	$s = serialize($serial);
  // store $s somewhere where page2.php can find it.
  file_put_contents('menudata.txt', $s);
 
//-------Call Re-arrange function-------
if($_POST["re_order"]){
reorder($_POST);}


//-----------------delete part 2-----------
  $s2 = file_get_contents('menudata.txt');
  $a2 = unserialize($s2);


foreach($a2 as $keyd => $valued){
if($a2[$keyd]['delete']==true){
unset($a2[$keyd]);
}}
//----Clear post-----
if($_POST["todelete"]){
$a2 = array_values($a2);

unset($_POST['level']);
unset($_POST['level_order']);
unset($_POST['type']);
unset($_POST['Text']);
unset($_POST['Link']);
unset($_POST['custom']);
unset($_POST['editnum']);
unset($_POST['todelete']);
$flagdel=true;}

print_r($a2, true);//echo'<hr>';
//------Level and order fixer---------	

	if($flagdel==true){$a2 = array_values($a2);
$levs=array(0=>0);
	foreach($a2 as $key => $value){
		if($key==0){$a2[$key]['level']=0;$a2[$key]['level_order']=0;}elseif($key>0){
			foreach($levs as $key2 => $value2){
				if($a2[$key]['level']==$key2)
				{$a2[$key]['level_order']=$levs[$key2]+=1;
						
				}elseif(($a2[$key]['level']>$key2)and(!isset($levs[$key2+1])))//if larger than current level declare first and start a new counter in $levs for that level
				{$levs[$key2+1]=0;
						$a2[$key]['level_order']=0;
					
						if($a2[$key]['level']>$a2[$key-1]['level']+1){
						
						$a2[$key]['level']=$a2[$key-1]['level']+1;$a2[$key]['level_order']=$levs[$key2]+=1;
						}
				}

			}
		}
	}
}

/**/

//Save..
//print_r($a2);
$serial = $a2;

	$s = serialize($serial);
  // store $s somewhere where page2.php can find it.
  file_put_contents('menudata.txt', $s);
 

/*
-------------------Add New Items--------------
*/

  if($_POST['addition']==true){//make accomodate arrays!
add();

}/*if($_POST['addlist']==true){//make accomodate arrays!
addlist();

}*/
 $s2 = file_get_contents('menudata.txt');
  $simdb = unserialize($s2);
 //---------------------------do css for List Items--------------
 function docss($showlv,$levelord){

 
$s2 = file_get_contents('menudata.txt');
  $simdb = unserialize($s2); foreach ($simdb as $key => $value) {
 
 
  if(($showlv==$simdb[$key]['level'])&&(@$simdb[$key]['level_order']==$levelord)){ 
$selected = $simdb[$key]['type'];


 if($selected=='Link'){ ?>
 <style type="text/css">
div#text<?php echo"$key";?>{display:block;}
div#link<?php echo"$key";?>{display:block;}
div#custom<?php echo"$key";?>{display:none;}
 </style>
   <?php } 
   
   if($selected=='Label'){ ?>
<style type="text/css">
div#text<?php echo"$key";?>{display:block;}
div#link<?php echo"$key";?>{display:none;}
div#custom<?php echo"$key";?>{display:none;}
 </style>
   <?php }  
   
   if($selected=='Custom'){ ?>
<style type="text/css">
div#text<?php echo"$key";?>{display:none;}
div#link<?php echo"$key";?>{display:none;}
div#custom<?php echo"$key";?>{display:block;}
 </style>
   <?php }}}}  
  
  
  //---------------css Adder---------------

  
?>  <style type="text/css">
.add{display:none;}

 </style>
  <style type="text/css">#reset{display:none;} </style>
 </head>
 <body>
   <!-- Body Start -->
   <?php
if (defined('LIVE_SITE')){
	if (empty($_SERVER['HTTPS'])) {
    header('Location: '.SSL_URL.'/pro_files/login.php');
    exit;
	}
}
?>
<div>

<form style="float:left;" action="" method="post" > 
<input type="hidden" name="view" value="menu">
<input type="submit" name="submit" value="View Menu">
</form>

<form style="float:left;" action="<?php echo SSL_URL;?>/system/onepagedbman.php" method="post" > 
<input type="hidden" name="view" value="dbman">
<input type="submit" name="submit" value="View Database Manager">
</form>



<form style="float:left;" action="<?php echo SSL_URL;?>/system/admin.php" method="post" > 
<input type="hidden" name="view" value="query">
<input type="submit" name="submit" value="Run a Query">
</form>


<form style="float:left;" action="<?php echo SSL_URL;?>/system/admin.php" method="post" > 
<input type="hidden" name="view" value="categories">
<input type="submit" name="submit" value="View Categories">
</form>


<form style="float:left;" action="<?php echo SSL_URL;?>/system/admin.php" method="post" > 
<input type="hidden" name="view" value="pages">
<input type="submit" name="submit" value="View Pages">
</form>


<form style="float:left;" action="<?php echo SSL_URL;?>/system/admin.php" method="post" > 
<input type="hidden" name="view" value="articles">
<input type="submit" name="submit" value="View Articles">
</form>
</div><br style="clear:both;"/><hr>

<!-- top links bar ends here -->

<h2>Menu Manager</h2>
 <form action="" method="post">
add how many?:  <input type="text" name="adds[numtoadd]" size="5" value="<?php if($thenum)echo$thenum; ?>" /><br />
</form>   


<button id="resetCheck" onclick="resetCheck()">Reset Data</button>
<form action="" id="reset"  method="post" style="float:right;">
<input type="hidden" name="reset" value="true"> <input type="submit" style="color:#f00;" value="Reset!" />
  <span style="float:right;"> - Warning resets entire menu!</span></form><hr style="clear:both;"/>  
  <form action="" method="post">

 <?php
    function show_ups($thenum,$keyadd){ 
 
  ?>
<script type="text/javascript">

 
function showformadd<?php echo"$keyadd";?>(str)
   
{
if (str=="Link")
  {  $("div#textadd<?php echo"$keyadd";?>").css("display","block");
$("div#linkadd<?php echo"$keyadd";?>").css("display","block");
 $("div#customadd<?php echo"$keyadd";?>").css("display","none"); /*document.getElementById("defaultadd<?php echo"$keyadd";?>").outerHTML=''; */
 } 
  if (str=="Label")
  {$("div#textadd<?php echo"$keyadd";?>").css("display","block");
$("div#linkadd<?php echo"$keyadd";?>").css("display","none");
 $("div#customadd<?php echo"$keyadd";?>").css("display","none");/* document.getElementById("defaultadd<?php echo"$keyadd";?>").outerHTML=''*/; 

  }
    if (str=="Custom")
  { $("div#textadd<?php echo"$keyadd";?>").css("display","none");
$("div#linkadd<?php echo"$keyadd";?>").css("display","none");
 $("div#customadd<?php echo"$keyadd";?>").css("display","block"); /*document.getElementById("defaultadd<?php echo"$keyadd";?>").outerHTML=''*/;
 }
 }
  
  </script>
  <fieldset>
   <legend>New Item <?php echo"$keyadd";?>:</legend>
Level: <input type="text" name="leveladd[]" size="5" value="<?php if(@$leveladd[$keyadd]){echo "$leveladd[$keyadd]";/*add last plus me*/} else {echo'0';} ?>">Level Order: <input type="text" name="level_orderadd[]" size="5" value="<?php if(@$level_orderadd[$keyadd]){echo "@$level_orderadd[$keyadd]";/*add last plus me*/} else { $s2 = file_get_contents('menudata.txt');
  $simdb = unserialize($s2);echo($keyadd+count(@$simdb));} ?>"> <!--  Add where?<input type="text" name="editnumadd[]" value="0">   Add as a new list?:  <input type="checkbox" name="addlist[]" value="<?php/* echo "$keyadd"; */?>" />--> <input type="hidden" name="addition" value="true">
<br />
  
  List Type: 
    <select name="typeadd[<?php echo"$keyadd";?>]" onchange="showformadd<?php echo"$keyadd";?>(this.value)">
<option id="defaultadd<?php echo"$keyadd";?>" value="">Select a type:</option>
	<?php if(!$selected){ ?><option value="Link">Link</option><?php } // old default goes with commented java<option value="Link">Link</option>
	else{ ?><option value="<?php echo"$selected"; ?>"><?php echo"$selected"; ?></option> 
	<option value="Link">Link</option><?php };?>
	
        <option value="Label">Label</option>
        <option value="Custom">Custom html</option>
    </select>

<div id="textadd<?php echo"$keyadd";?>" class="add">Text:<br> <textarea type="text" cols="50" rows="3" name="Textadd[]" ><?php echo @$textadd; ?></textarea></div>
<div id="linkadd<?php echo"$keyadd";?>" class="add">Link:<br> <textarea type="text" cols="50" rows="3" name="Linkadd[]" ><?php echo @$linkadd; ?></textarea></div>
<div id="customadd<?php echo"$keyadd";?>" class="add">Custom html:<br> <textarea  type="text" cols="50" rows="5" name="customadd[]" ><?php echo @$customadd; ?></textarea></div>

   </fieldset>
   <?php
}
 
if($_POST){$thenum = $_POST['adds']['numtoadd'];}	
  $i=0;
   while ($i < $thenum) { 
$keyadd =$i++;//print_r( )

show_ups($thenum,$keyadd);//adder function call
  

 }
    
  ?><?php 
    /*
	-------------------Function show Adder------------------
	*/
  

  
if($_POST['adds']['numtoadd']>0){//-----Display add button if needed ?>

   <input type="hidden" name="adds[numtoadd]" value="<?php echo "$thenum"; ?>"  />
   
   <input type="submit" value="Add menu item<?php if($_POST['adds']['numtoadd']>1){echo's';}?>!" />
  Add as new list? <input type="checkbox" name="listaddition" value="true" /></form><hr>
<?php }
/*
if ($_POST) {
    echo '<pre>';
    echo htmlspecialchars(print_r($_POST, true));
    echo '</pre>';
}
*/
     //---------------------------show li--------------
?><form id="form1" action="" method="post" ><?php
function showli($showlv,$levelord){		$s2 = file_get_contents('menudata.txt');
  $simdb = unserialize($s2);



 foreach ($simdb as $key => $value) {
 
 
  if(($showlv==$simdb[$key]['level'])&&(@$simdb[$key]['level_order']==$levelord)){ 
$selected = $simdb[$key]['type'];
//echo $selected;
  
 
  //---------------Refill Form-----------------
$level = $simdb[$key]['level'];
$level_order = $simdb[$key]['level_order'];

$text = $simdb[$key]['text'];

$link = $simdb[$key]['link'];
$link = htmlentities($link, ENT_QUOTES);

$custom = @$simdb[$key]['custom'];
 

 ?><script type="text/javascript">

function showform<?php echo"$key";?>(str)

{
if (str=="Link")
  {  $("div#text<?php echo"$key";?>").css("display","block");
$("div#link<?php echo"$key";?>").css("display","block");
 $("div#custom<?php echo"$key";?>").css("display","none");  } 
  if (str=="Label")
  {$("div#text<?php echo"$key";?>").css("display","block");
$("div#link<?php echo"$key";?>").css("display","none");
 $("div#custom<?php echo"$key";?>").css("display","none");
  }
    if (str=="Custom")
  { $("div#text<?php echo"$key";?>").css("display","none");
$("div#link<?php echo"$key";?>").css("display","none");
 $("div#custom<?php echo"$key";?>").css("display","block"); 
 }
 }

  </script>
 <?php if($simdb[$key]['level']>@$simdb[$key-1]['level']+1){echo'I\'m feeling disconnected';} ?>
   <fieldset style="margin-left:<?php echo$level*25;?>px;">
   <legend>Item #:<?php echo$key+1;?></legend>

Level: <input type="text" name="level[]" value="<?php echo "$level"; ?>"><br>
Level Order: <input type="text" name="level_order[]" value="<?php echo "$level_order"; ?>"><br>
List Type: <br />
    <select name="type[<?php echo"$key";?>]" onchange="showform<?php echo"$key";?>(this.value)">   
	<?php if(!$selected){ ?><option value="Link">Link</option><option value="Label">Label</option><?php }
	else{ ?><option value="<?php echo"$selected"; ?>"><?php echo"$selected"; ?></option> 
<?php }; 

if($selected == 'Label'){ ?><option value="Link">Link</option><?php } 
	if($selected == 'Link'){ ?><option value="Label">Label</option><?php } 
	if($selected == 'Custom'){ ?><option value="Link">Link</option><option value="Label">Label</option><?php }
	else{?>      
       
        <option value="Custom">Custom</option> <?php } ?>
    </select><br />



<div id="text<?php echo"$key";?>">Text:<br> <textarea type="text" cols="50" rows="2" name="Text[]" ><?php echo "$text"; ?></textarea><br></div>
<div id="link<?php echo"$key";?>">Link:<br> <textarea type="text" cols="50" rows="2" name="Link[]" ><?php echo "$link"; ?></textarea><br></div>
<div id="custom<?php echo"$key";?>">Custom html:<br> <textarea type="text" cols="50" rows="3" name="custom[]" ><?php echo "$custom"; ?></textarea></div>
   <input type="hidden" name="editnum[]" value="<?php echo "$key"; ?>">
   
   <?php
echo '  Re-Order to: <input type="text" name="re_order[]" size="5" value="'.(1+$key).'"/>';
   ?>Delete?:  <input type="checkbox" name="todelete[]" value="<?php echo "$key"; ?>" />
 
</fieldset>

   
<?php //print_r($simdb);
}}

}
/*
------------------------Display List Functions----------------------
*/

foreach ($simdb as $key => $value) {

$showlv=$simdb[$key]['level'];
$levelord=$simdb[$key]['level_order'];

docss($showlv,$levelord);
showli($showlv,$levelord);	
	
}	
/*
-------------------submit--------------
*/
	?>		
	  <input type="hidden" name="adds[numtoadd]" value="<?php echo "$thenum"; ?>"  />
	    <input type="submit" value="submit changes!" /></form>
 
	<form style="position:fixed;right:10px;top:10px;" method="post">
		 <input type="hidden" name="logout" value="1" />		
		<input type="submit" name="submit" value="Logout" />
	</form><?php





      } else {
        echo "You are not logged in";
       
 //IF THE FORM WAS NOT SUBMITTED
//SHOW FORM
	?><form method="post">
		Username: <input type="text" name="username" /><br />
		Password: <input type="password" name="password" />
		<input type="submit" name="submit" />
		
	</form><?php 
}?></body><script>
var showingReset = 0;
function resetCheck()
{	


	if(showingReset == 0){
	 document.getElementById('resetCheck').innerHTML="Return with-out resetting";
	$('#reset').css('display','block');
	 showingReset=1;
	 }else{ document.getElementById('resetCheck').innerHTML="Reset Data";
	
	 $('#reset').css('display','none');
	 showingReset=0;
	 }
}</script></html>

	<?php	
/*


$serial = $simdb;

	$s = serialize($serial); 
 // store 
  file_put_contents('pro_files/menudata.txt', $s);*/