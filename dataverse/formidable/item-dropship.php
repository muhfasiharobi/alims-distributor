<?php
	function default_item_dropship_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-social-dropbox font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Stok Dropship
							</span>
						</div>
					</div>
					<br><br><br>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Item
									</th>
									<th>
										Stok
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$customer_query = mysql_query("SELECT * FROM item_dropship a, item b, user c WHERE a.item_id = b.item_id AND a.user_id = c.user_id AND a.user_id = '".$_SESSION['user_id']."' ORDER BY a.item_dropship_id DESC");
								while ($customer_fetch_array = mysql_fetch_array($customer_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $customer_fetch_array['item_name']; ?>
										</td>
										<td>
											<?php echo $customer_fetch_array['stok']; ?>
										</td>	
									</tr>
							<?php
								$number++;
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>