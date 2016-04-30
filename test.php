<?php ini_set('max_execution_time', 14400);?>
<?php include ('database.php')?>
<?php include ('helpers.php')?>
<?php

$handler = fopen('c:\\xampp\htdocs\phptesting\info.txt',"r");

$completedRows = array();

global $name;
global $firm;
global $address;
global $cityState;
global $phone;
global $fax;
global $email;
global $extra1;
global $extra2;
global $extra3;


while(!feof($handler)){
	$buffer= array();
	$completedRows = array();
	$line = fgets($handler);
	//echo $line . '<br>';
	array_push($buffer,$line);;
	$line = fgets($handler);
	//echo $line. '<br>';
	
	
	while(substr($line,0,1)!= "\"") 
		  {
		array_push($buffer,$line);
		$line = fgets($handler);
		//echo $line. '<br>';
						}
		array_push($completedRows, $buffer);
		$buffer = null;
		
		
		
		for($i=0;$i<1;$i++){
			
			//echo	'$i = ' . $i . '<br><br>';
				
				$number = count($completedRows[$i]);
			
			 for($x = 0; $x < $number; $x++) {
				
				if($x > $number){break;}
				
					//var_dump ($completedRows);
					//echo '<br><br>';
					//echo '$i = ' . $i . '<br>';
					//echo '$x = ' . $x . '<br><br>';
					//echo '$number = '. $number. '<br>';
			
					if(strpos($completedRows[$i][$x],'@')){
								$email = $completedRows[$i][$x]; continue;
									}
									
					else if(strpos($completedRows[$i][$x],'ax:')){
								$fax =  $completedRows[$i][$x];continue;
									}
									
					else if(strpos($completedRows[$i][$x],"ffice")){
								$phone =  $completedRows[$i][$x]; continue;
								}
		
									
									
					elseif(is_numeric(substr($completedRows[$i][$x],1,1)) || strpos($completedRows[$i][$x],'box') || 
						strpos($completedRows[$i][$x],'Box') || strpos($completedRows[$i][$x],'mail') || strpos($completedRows[$i][$x],'Mail')|| 
						strpos($completedRows[$i][$x],'mailbox') || strpos($completedRows[$i][$x],'Mailbox')){
								$address =  $completedRows[$i][$x];continue;
									}
									
					elseif(preg_match("/[A-Z][A-Z]/",$completedRows[$i][$x]) && preg_match("/[0-9]{5,}/",$completedRows[$i][$x])){
								$cityState = $completedRows[$i][$x];  continue;
									}
									
					elseif(strpos($completedRows[$i][$x],'Board') || strpos($completedRows[$i][$x],'Certification')){
								$extra1 = $completedRows[$i][$x];continue;
									}
					elseif(isset($extra1)){
								$extra2 = $completedRows[$i][$x];continue;
									}
					elseif(isset($extra2)){
								$extra3 = $completedRows[$i][$x];continue;
									}				
					
					elseif(strpos($completedRows[$i][$x],'The') || strpos($completedRows[$i][$x],'the') || strpos($completedRows[$i][$x],'&') || strpos($completedRows[$i][$x],'Pllc')||
							strpos($completedRows[$i][$x],'LLP') || strpos($completedRows[$i][$x],'PA') || strpos($completedRows[$i][$x],'P.A') || strpos($completedRows[$i][$x],'P.L')||
							strpos($completedRows[$i][$x],'Llc') || strpos($completedRows[$i][$x],'LLC') || strpos($completedRows[$i][$x],'of') || strpos($completedRows[$i][$x],'for')||
							strpos($completedRows[$i][$x],'corp') || strpos($completedRows[$i][$x],'Corp') || strpos($completedRows[$i][$x],'Associates') || strpos($completedRows[$i][$x],'inc')||
							strpos($completedRows[$i][$x],'Inc') || strpos($completedRows[$i][$x],'Corporation') || strpos($completedRows[$i][$x],'corporation') || strpos($completedRows[$i][$x],'Florida')||
							strpos($completedRows[$i][$x],'florida') || strpos($completedRows[$i][$x],'Services') || strpos($completedRows[$i][$x],'State') || strpos($completedRows[$i][$x],'Firm')||
							strpos($completedRows[$i][$x],'and') || strpos($completedRows[$i][$x],'And') || strpos($completedRows[$i][$x],'Et.') || strpos($completedRows[$i][$x],'et.') || strpos($completedRows[$i][$x],'et al')){
								$firm =	$completedRows[$i][$x];continue;
									}
									
					else{if(!isset($name)){
						$name = $completedRows[$i][$x];
						continue;}
									}
									
			
					}
					
			if(!isset($name)){$name = 'X';}
			if(!isset($firm)){$firm = 'X';}
			if(!isset($address)){$address = 'X';}
			if(!isset($cityState)){$cityState = 'X';}
			if(!isset($phone)){$phone = 'X';}
			if(!isset($fax)){$fax = 'X';}
			if(!isset($email)){$email = 'X';}
			if(!isset($extra1)){$extra1 = 'X';}
			if(!isset($extra2)){$extra2 = 'X';}
			if(!isset($extra3)){$extra3 = 'X';}
			
			
			
			
			
			/*
			echo '$name = '. $name. '<br>';
			echo '$firm = '. $firm . '<br>';
			echo '$address = '. $address. '<br>';
			echo '$cityState = '. $cityState . '<br>';
			echo '$phone = '. $phone . '<br>';
			echo '$fax = '. $fax . '<br>';
			echo '$email = '. $email . '<br>';
			echo '$extra1 = '. $extra1 . '<br>';
			echo '$extra2 = '. $extra2 . '<br>';
			echo '$extra3 = '. $extra3 . '<br><br>';
			
			*/
			
			
			$domain = 'http://' . getDomainFromEmail($email);
			$subdomain = 'http://www.' . getDomainFromEmail($email);
			//echo $domain . '<br><br>';
			//echo $subdomain . '<br><br>';
			
					//prepare query
					$user= $con->prepare("
								INSERT INTO list2 (Name,Firm,Address,City,Phone,Fax,Email,Domain,Subdomain,Extra1,Extra2,Extra3)
								VALUES(:Pname,:Pfirm,:Paddress,:PcityState,:Pphone,:Pfax,:Pemail,:Pdomain,:Psubdomain,:Pextra1,:Pextra2,:Pextra3)
								
								");
			
			
					//Set up query fields with variables
					$Execution = $user->execute([
						'Pname' 		=> 	$name,
						'Pfirm' 		=>	$firm,
						'Paddress' 		=>	$address,
						'PcityState'	=>	$cityState,
						'Pphone' 		=>	$phone,
						'Pfax'			=>	$fax,
						'Pemail'		=>	$email,
						'Pdomain'		=>	$domain,
						'Psubdomain'	=>	$subdomain,
						'Pextra1' 		=>	$extra1,
						'Pextra2' 		=>	$extra2,
						'Pextra3' 		=>	$extra3,
					
					
					]);
				
					
					//Flush variables
					$name= null;
					$firm= null;
					$address= null;
					$cityState= null;
					$phone= null;
					$fax= null;
					$email= null;
					$extra1= null;
					$extra2= null;
					$extra3= null;
					$completedRows = null;
					$x = 0;
					$i=0;
					
		}
		
		
   }


fclose($handler);


echo 'Script Complete!';


?>

