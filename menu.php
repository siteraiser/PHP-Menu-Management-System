<?php
function draw_menu(){
include_once('prep_content.php');?>
<?php 

echo 
'
<nav><div class="menustyled"> <ul id="nav">
	
';
foreach ($a as $key => $value) {$i=0;
    $i=count($a[$key]);
   foreach($a[$key] as $key1 => $value1) {$s=1;$s2=1;
   
   if($key1 == 0){
echo "		
		<li>
"."		".$a[$key][$key1][0][0]['data']['link']."	";

}//sub menu 1
if($key1 >= '1'){
if(!isset($a[$key][$key1+1])){echo "
			<ul>
";}
$i--;
foreach($a[$key] as $key1 => $value1) {if($key1 >= '1'){

foreach($a[$key][$key1] as $key2 => $value1) {if(($key1 >= '1')&&($a[$key][$key1]>'0')){

if(($key2 == 0)&&(!isset($a[$key][$key1][$key2+1]))&&($i == 1)){
echo "				<li>
				".$a[$key][$key1][$key2][0]['data']['link']."";//3rd
  }
 foreach($a[$key][$key1] as $key3 => $value1) { 
//if is first in 2nd menu
if(($key3==1)&&($key2==0)&&($i == 1)){ ?>
				<li><?php echo "
				".$a[$key][$key1][$key2][0]['data']['link']; ?><img alt="more" height="16" class="arrow" src="/images/arrow.png"/>				
<?php 

if ($key3 >= 1){ echo'
					<ul>';	
foreach($a[$key][$key1] as $key4 => $value1) { 
if(($key4 >= 1)){?>						
						<li>
						<?php  echo @$a[$key][$key1][$key4][0]['data']['link'];
						if(@$a[$key][$key1][$key4][1]['data']['link']){?>
<img alt="more" class="arrow2" height="16" src="/images/arrow.png" />
						<?php }

 if(($key4>=1)&&(@$a[$key][$key1][$key4][1]['data']['link'])){
 ?>
 
							<ul>
							<?php 
 foreach(@$a[$key][$key1][$key4] as $key5 => $value){ if(($key5)>=1){echo'	<li>
						';
							echo "		".@$a[$key][$key1][$key4][$key5]['data']['link']; echo '
								';?></li>	
							<?php }} ?></ul><?php }
echo "
						</li>"; }}
echo"
					</ul>
				</li>
"; }}
  }}if(($key2 == 0)&&(!isset($a[$key][$key1][$key2+1]))&&($i == 1)){
echo "
				</li>
";}echo "";
 }

} }if(!isset($a[$key][$key1+1])&&($i == 1)){$done=false;
echo "			</ul>
		</li>
		
";$done=true;if((@$key5 == 1)and($done!==true)){ echo'
		</li>
		
';}
}

if(($key2 > 1)&&($i == 1)&&($key1 == 0)){echo'</li>';}

if(($key2 == 0)&&(!isset($a[$key][$key1][$key2+1]))&&($i == 1)and($done!==true)){
echo "
		</li>
				
";}}
}
if ((@$key3 >= 1)&&($key2 >= 1)&&($key1 >= 1)){ if((@$key5 < 1)and($done!==true)){echo'
			</li>
		
';	}}
if(($key1 == 0)){
echo "
		</li>
		
";}
}
?>
	</ul><?php
echo "	
";
echo "	</div></nav>
";
}
?>