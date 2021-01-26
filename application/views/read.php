<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Todo App </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url('assests/css/datePicker.css'); ?>">
	<script type="text/javascript" src="<?php echo base_url('assests/js/datePicker.js'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".postedDate").datepicker({
				autoclose: true,
				format: "yyyy-mm-dd"
			});
		});
	</script>
</head>
<body>
	<div class="container">
		<div class="row">
			<ul class="nav nav-tabs navbar-inverse">
				<li role="presentation" class="active"><a href="<?= base_url() ?>read/getToDoData">Home</a></li>
			</ul>
		</div>
		<hr />  
		<!-- Search form (start) -->
		<div class="row">	
			<form method='post' class="form" action="<?= base_url() ?>read/getToDoData" >
				<div class="form-group col-xs-12 col-sm-6 col-md-5 col-lg-4">
					<input type='text' name='search' class="form-control" placeholder="To do" value='<?= $search ?>'>
				</div>

				<div class="form-group col-xs-12 col-sm-6 col-md-5 col-lg-2">
					<input type='text' name='SubmitedDate' class="form-control postedDate " placeholder="Submited Date" value='<?= $SubmitedDate ?>'>
				</div>

				<div class="form-group col-xs-12 col-sm-6 col-md-2 col-lg-2">
					<input type='submit' class="btn btn-primary form-control" name='submit' value='Search'>
				</div>

			</form>

			<div class="form-group col-xs-12 col-sm-6 col-md-2 col-lg-2">
				<a href="<?php echo site_url('read/insertToDo'); ?>">
					<button class="btn btn-primary form-control"> Add To do</button>
				</a>
			</div>
		</div>
		<br/>

		<div class="row">
			<div class="col-md-12">

				<!--- Success Message --->
				<?php if ($this->session->flashdata('success')) { ?> 
					<p style="font-size: 20px; color:green"><?php echo $this->session->flashdata('success'); ?></p>
				<?php }?>
				<!---- Error Message ---->
				<?php if ($this->session->flashdata('error')) { ?>
					<p style="font-size: 20px; color:red"><?php echo $this->session->flashdata('error'); ?></p>
				<?php } ?> 


				<div class="table-responsive">                
					<table id="mytable" class="table table-bordred table-striped">                 
						<thead>
							<th>S.No</th>
							<th>To do</th>
							<th>Submited Date</th>
							<th>TO do TimeStamp</th>
							<th>Edit</th>
							<th>Delete</th>
						</thead>
						<tbody>    
							<?php 
							if(count($result) != 0){
								$cnt=1;
								foreach($result as $row)
								{               
									?>  
									<tr>
										<td><?php echo htmlentities($cnt); ?></td>
										<td><?php echo htmlentities($row["toDo"]); ?></td>
										<td><?php echo htmlentities($row["SubmitedDate"]); ?></td>
										<td><?php echo htmlentities($row["PostingDate"]); ?></td>
										<td>
											<?php 
													//for passing row id to controller
											echo  anchor("read/getDetail/{$row['id']}",' ','class="btn btn-primary btn-xs glyphicon glyphicon-edit"')?>
										</td>
										<td>
											<?php 
													//for passing row id to controller
											echo anchor("read/deleteToDo/{$row['id']}",' ','class="glyphicon glyphicon-remove-sign btn-danger btn-xs"')?>
										</td>
									</tr>
									<?php 
											// for serial number increment
									$cnt++;
								} 
							}else{
								echo "<tr>";
								echo "<td colspan='6'>No record found.</td>";
								echo "</tr>";
							} ?>
						</tbody>      
					</table>
				</div>

				<!-- Paginate -->
				<div style='margin-top: 10px;'>
					<?php echo $pagination; ?>
				</div>

			</div>
		</div>
	</div>
</body>
</html>
