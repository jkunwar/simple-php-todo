<?php
	require_once('settings.php');
	class DB{
		public $mysqli;
		function __construct(){
			$this->mysqli  = new mysqli(DBHOST, DBUSER, DBPASS,  DBNAME);
			if($this->mysqli->connect_errno){
				printf("connection to db failes %s \n",$this->mysqli->connect_errno);
				exit();
			}
		}
		public function __destruct(){
			$this->disconnect();
		}
		public function disconnect(){
			$this->mysqli->close();
		}

		public function insertinto($tablename,$values){
			$rows = array();
			$query = "INSERT INTO `".$tablename."`";
			if(!empty($values)&&is_array($values)){
				$i=1;
				$fields_parts=$values_parts='(';
					foreach($values as $field=>$value){
						if($i==1){
							$fields_parts.='`'.$field.'`';
							$values_parts.="'".$value."'";
						}
						else{
							$fields_parts.=',`'.$field.'`';
							$values_parts.=",'".$value."'";
						}
						$i++;
					}
				$fields_parts.=')';
				$values_parts.=')';
				$query.=$fields_parts.'VALUES'.$values_parts;
				$result = $this->mysqli->query($query) or die($this->mysqli->error);
				return true;
			}
			else
				return false;
		}
		
		function getall($table_name,$condition='',$condition_type='AND'){
			$rows=array();
			$query=" SELECT * FROM `".$table_name."`";
			if(!empty($condition)){
				$query.=" WHERE ";
				if(is_array($condition)){
					$i=1;
					foreach($condition as $field => $value){
						if($i==1)
						   $query.="`".$field."`='".$value."'";
						else
							$query.=" ".$condition_type." `".$field."`='".$value."'";
						   $i++;
					}
				}
				else {
					$query.=$condition;
				}
			}
			$query.=" ORDER BY created_at AND modified_at ASC";
			//echo $query; die;

			$result=$this->mysqli->query($query) or die($this->mysqli->error);
			if($result->num_rows>0){
				while($row=$result->fetch_array()){
					//echo "<pre>";
					//print_r($row);
					 $rows[]=$row;
				}
				$result->free();
			}
			return $rows;
		}
	
		public function getone($table_name,$condition='',$condition_type='AND'){
			$row=array();
			$query=" SELECT * FROM `".$table_name."` ";
			if(!empty($condition)){
				$query.=" WHERE ";
				if(is_array($condition)){
					$i=1;
					foreach($condition as $field => $value){
						if($i==1)
						   $query.="`".$field."`='".$value."'";
						else
							$query.="".$condition_type."`".$field."`='".$value."'";
							$i++;
					}
				}
				else {
					$query.=$condition;
				}
			}
			$query.=" ORDER BY created_at AND modified_at ASC";
			
			$query.=" LIMIT 1";//echo $query; die;
			$result=$this->mysqli->query($query) or die($this->mysqli->error);
			if($result->num_rows>0){
				$row=$result->fetch_array();
				$result->free();
			}
			return $row;
		}

		public function update($table_name,$values,$condition=''){
			$query=" UPDATE `".$table_name."` ";
			if(!empty($values) && is_array($values)){
				$query.=" SET ";
				$i=1;
				foreach($values as $field => $value){
					if($i==1)
					   $query.="`".$field."`='".$value."'";
					else
					   $query.=", `".$field."`='".$value."'";
				   $i++;
				}
				if(!empty($condition)){
					$query.=" WHERE ";
					if(is_array($condition)){
						$i=1;
						foreach($condition as $field => $value){
							if($i==1)
						   		$query.="`".$field."`='".$value."'";
							else
					   			$query.="".$condition_type."`".$field."`='".$value."'";
				   			$i++;
						}
					}
					else{
						$query.=$condition;
					}
				}
				$result=$this->mysqli->query($query) or die($this->mysqli->error);
				return true;
			}
			else
		   		return false;
		}
		
		public function delete($table_name,$condition='',$condition_type='AND'){
			$row=array();
			$query=" DELETE FROM `".$table_name."` ";
			if(!empty($condition)){
				$query.=" WHERE ";
				if(is_array($condition)){
					$i=1;
					foreach($condition as $field => $value){
						if($i==1)
						   $query.="`".$field."`='".$value."'";
						else
						   $query.="".$condition_type."`".$field."`='".$value."'";
					   $i++;
					}
				}
				else{
					$query.=$condition;
				}
				$query.=" LIMIT 1";//echo $query; die;
				$result=$this->mysqli->query($query) or die($this->mysqli->error);
				return true;
			}
			else
				return false;
		}
	}
?>