<?php

$result = $config->getInvoiceHistory();
$invoiceData = $result->fetch_All();
?>
<div>
	<table class="table table-bordered" id="wang-dataTable">
		<thead>
		<tr>
			<th class="text-center">#</th>
			<th>Amount</th>
			<th>User</th>
			<th>Plate number</th>
			<th>Date</th>
			<!--<th>Amount</th>-->
			<th class="text-center">Action</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$s_sn = 1;
		foreach($invoiceData as $row){
			$user = $config->getUserById($row[1]);
			$user_info = $result->fetch_assoc();
			?>
			<tr>
				<td class="text-center"><?php echo $s_sn; ?></td>
				<td><?php echo $row[4]; ?></td>
				<td><?php echo $user_info['name']; ?></td>
				<td><?php echo $row[7]; ?></td>
				<td><?php echo $row[2]; ?></td>
				<td class="text-center">
					<a href="home.php?query=deletecouponhistory&id=<?php echo $row[0]; ?>">
						<i class="far fa-trash-alt" style="float:right;"></i>
					</a>
				</td>
			</tr>
			<?php $s_sn++; }?>
		</tbody>
	</table>
</div>
