<?php 
function generarcombo($data)
	{
		$comb=array();		
				foreach($data as $obj){
					$comb[$obj['v1']]=$obj['v2'];
				}
		
 		return $comb;		
	}



?>