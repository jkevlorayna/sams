<?php 


$slim_app->get('/generate/barcode/:number',function($number){


		echo '<ul style="list-style:none;">';
		$x=1; 
		while($x<=$number) {


		$chars ="123456789";//length:36
		$final_rand='';
		for($i=0;$i<10; $i++)
		{
			$final_rand .= $chars[ rand(0,strlen($chars)-1)];
		}

		$pin =  $final_rand;
		
		echo '
		<li style="display:inline;float:left;border:1px dashed;margin-right:10px;margin-bottom:10px;">
			<img  src="/core/class/barcode.php?codetype=Code128&size=80&text='.$pin.'"  style="margin-top:5px;" />
			<br>
			<center>'.$pin.'</center>
		</li>
			';
		
		$x++;
		} 
		echo '</ul>';


});


?>