

		<div class = "container">

			<?php
				if($this->session->flashdata('success_msg'))
				{
			?>
					<div class = "alert alert-success">
						<?php echo $this->session->flashdata('success_msg'); ?>
					</div>
			<?php	
				}
			?>

			<?php
				if($this->session->flashdata('error_msg'))
				{
			?>
					<div class = "alert alert-danger">
						<?php echo $this->session->flashdata('error_msg'); ?>
					</div>
			<?php	
				}
			?>

			<h1 align = "center">Welcome to X-O Games</h1><br>
			<h3 align = "center">เริ่มเกมส์กันเลยยยย ....</h3>
			<form action = "<?php echo base_url('MainContro/submitVsCpu'); ?>" method = "post", class = "form-horizontal">

					<div class = "form-group">
						<label for = "player1name" class = "col-md-2 text-right">ชื่อผู (x): </label>
						<div class = "col-md-10">
							<input type="text" name="player1name" class = "form-control" placeholder="กรุณากรอกชื่อของคุณ" required>
						</div>
					</div>

					<div class = "form-group">
							<input type="submit" name="btnSave" class = "btn btn-success btn-lg center" value = "เริ่มเกมส์">
					</div>
			</form>

			<div style="margin: 0 18%; margin-top: 70px;">
				<h3 class="text-center">5 อันดันล่าสุดดด !!</h3>
				<table class="table table-striped table-bordered  table-responsive">
					<thead>
						<tr> 
							<th  class="text-center" >Match No.</th>
							<th  class="text-center">Player 1 </th>
							<th  class="text-center">Player 2 </th>
							<th  class="text-center">Winner</th>
						</tr>
						</thead>
						<tbody>
						<?php 
							$i = 1;
							if($games)
							{
								foreach($games as $name)
								{

						?>
						<tr>
							<td class="text-center"><?php echo $i; ?></td>
							<td><?php echo $name->player1name; ?></td>
							<td><?php echo $name->player2name; ?></td>
							<td><?php echo $name->winner; ?></td>
						</tr>
						<?php	$i++;
								}
							}else{
						?>
							<tr>
								<td class="text-center" colspan="4">ไม่พบข้อมูล</td>
							</tr> 
						<?php } ?>
					</tbody>
				</table>
			</div>

		</div>

		
	