<?php

function query($query, $conn = false){
	
	/* 
	* set the database connection globally
	* or pass the database connection as second parameter in function call (optional)
	*/
	
	if(!$conn && trim($conn) == ''){
		global $conn;
	}
        
	if(isset($query) && !empty($query)){

		$query = trim($query);

		$result = mysqli_query($conn, $query);

		$query_type = trim(strtolower(explode(" ", $query)[0]));

		if($query_type == "select"){
			 if($result && mysqli_num_rows($result)>0){
				$data = [];
				while($row = mysqli_fetch_assoc($result)){
					foreach($row as $key=>$val){
						$row[$key] = str_replace("\'", "'", $val);
					}
					$data[] = $row;
				}
				return $data;
			}else
				return false;
		}
		elseif($query_type == "insert"){
			$id = mysqli_insert_id($conn);
			if($id){
				return $id;
			}else{
				return false;
			}
		}else{
			if($result && mysqli_affected_rows($conn)>0)
				return true;
			else
				return false;
		}
	}
	else{
		return false;
	}
}

?>
