<?php
	include_once('_includes/db.php');
	$db=new DB();

	if(isset($_GET['id'])){
		$task_id=$_GET['id'];
		$task=$db->getone('list',array('id'=>$task_id));
		if(empty($task)){	
			echo "There is no task!" ;exit();
		}
		if($db->delete('list',array('id'=>$task_id))){
			header('Location: index.php');
		}
	}
	else
		header('Location: index.php');

?>
