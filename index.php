<?php
	include('_includes/db.php');
	$db = new DB();

	$is_update = 0;
	if(isset($_GET['id'])){
		$is_update = 1;
		$task_id = $_GET['id'];
		$lists = $db->getone('list',array('id'=>$task_id));

	}
	$tasks = $db->getall('list');
	//echo "<pre>"; print_r($tasks);die();

	if(isset($_POST['submit'])){
		$description = trim($_POST['description']);

		if(empty($description)){
			$error = "Fill this field first";
		}

		if(!empty($description)){
			$new_data = ['description' => $description ];
					
					if($is_update == 1){
						if($db->update('list',$new_data,array('id'=>$task_id))){
							header('Location: index.php');
						}
					}
					else{
						if($db->insertinto('list',$new_data)){
							header('Location: index.php');
						}
					}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To do list</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="todo">
		<div class="container">
		    <div class="row">
		        <div class="col-md-8 col-md-offset-2">
        			<h3>Your To Do List</h3>
        			<form action="" method="post">
        				<input type="text" name="description" value="<?php if($is_update == 1) echo $lists["description"]; ?>" placeholder="Type your task here"  class="form-control" required>
        				<input type="submit" name="submit" value="<?php if($is_update == 1) echo "Edit Item"; else echo "Add To List"; ?>" class="btn submit">
        			</form>
        			
        			<table class="table">
        			<?php  if(!empty($tasks)){ ?>
        				<tr>
        					<!-- <th></th> -->
        					<th>Task</th>
        					<th>Created At</th>
        					<th>Modified At</th>
        					<th>Action</th>
        				</tr>
        				<?php foreach ($tasks as $task):?>
        				<tr>
        					<td class="description"><?php echo $task['description']; ?></td>
        					<td><?php echo $task['created_at']; ?></td>
        					<td><?php echo $task['modified_at']; ?></td>
        					<td>
        						<?php echo "<a href=\"index.php?id=".$task['id']."\" > Edit 	</a> |
        						<a href=\"delete.php?id=".$task['id']."\" onclick=\"return(confirm('Are you sure you have completed this task?'));\" > Delete</a>"; ?>
        					</td>
        				</tr>
        			<?php endforeach; ?>
        			<?php }
        				else echo "<p class='blank'>There is no task stored</p>"; ?>
    		    	</table>
		    	  </div>
		    </div>
		</div>
	</div>
    <script src="js/jquery.min.js"></script>
    
</body>
</html>