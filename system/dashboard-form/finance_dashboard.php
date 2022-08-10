<?php
	function form_initial_finance_dashboard()
	{
		$tgl_sekarang = date('Y-m-d');
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered dashboard-stat2">
						<?php
							$tbl_billing_target_value_on_day = mysql_query("SELECT SUM((d.sales_order_detail_product_sell_quantity * d.sales_order_detail_product_sell_price) - d.sales_order_detail_piece_discount) AS billing_target_on_day FROM billing_plan a, billing_plan_detail b, sales_invoice c, sales_order_detail d WHERE a.billing_plan_active = '1' AND c.sales_invoice_status = 'Posted' AND a.billing_plan_id = b.billing_plan_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND a.billing_plan_date = '".$tgl_sekarang."'");
							$data_tbl_billing_target_value_on_day = mysql_fetch_array($tbl_billing_target_value_on_day);
		
							$billing_target_value_indo = format_angka($data_tbl_billing_target_value_on_day['billing_target_on_day']);
							
							$tbl_billing_visit_on_day = mysql_query("SELECT SUM(d.billing_visit_detail_nominal) AS billing_visit_on_day FROM billing_plan a, billing_plan_detail b, billing_visit c, billing_visit_detail d WHERE a.billing_plan_active = '1' AND a.billing_plan_id = b.billing_plan_id AND b.billing_plan_detail_id = c.billing_plan_detail_id AND c.billing_visit_id = d.billing_visit_id");
							$data_tbl_billing_visit_on_day = mysql_fetch_array($tbl_billing_visit_on_day);
							
							$data_tbl_billing_visit_on_day_indo = format_angka($data_tbl_billing_visit_on_day['billing_visit_on_day']);
							
							$prosentase_billing_visit_on_day = round(($data_tbl_billing_visit_on_day['billing_visit_on_day'] / $data_tbl_billing_target_value_on_day['billing_target_on_day']) * 100, 2);
							
						?>
						<div class="display">
							<div class="number">
								<small class="font-red">
									TARGET ON DAY (IN VALUE)
								</small>
								<h3 class="font-red">
									<span>
										<?php echo $billing_target_value_indo ?>
									</span>
								</h3>
							</div>
							<div class="icon">
								<i class="icon-credit-card"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
							<?php
								if ($prosentase_billing_visit_on_day >= 90)
								{
							?>
								<span style="width: <?php echo $prosentase_billing_visit_on_day?>%;" class="blue progress-bar progress-bar-success"></span>
							<?php
								}
								elseif ($prosentase_billing_visit_on_day >= 80 && $prosentase_billing_visit_on_day <= 89)
								{
							?>
								<span style="width: <?php echo $prosentase_billing_visit_on_day?>%;" class="green progress-bar progress-bar-success"></span>
							<?php
								}
								elseif ($prosentase_billing_visit_on_day >= 60 && $prosentase_billing_visit_on_day <= 79)
								{
							?>
								<span style="width: <?php echo $prosentase_billing_visit_on_day?>%;" class="yellow progress-bar progress-bar-success"></span>
							<?php
								}
								else
								{
							?>
								<span style="width: <?php echo $prosentase_billing_visit_on_day?>%;" class="red progress-bar progress-bar-success"></span>
							<?php
								}
							?>
							</div>
							<div class="status">
								<div class="font-blue status-title">
									ACTUAL (IN VALUE)
								</div>
								<?php
									if ($prosentase_billing_visit_on_day >= 90)
									{
								?>
									<div class="font-blue status-number">
										<?php echo $prosentase_billing_visit_on_day ?> %
									</div>
								<?php
									}
									elseif ($prosentase_billing_visit_on_day >= 80 && $prosentase_billing_visit_on_day <= 89)
									{
								?>
									<div class="font-green status-number">
										<?php echo $prosentase_billing_visit_on_day ?> %
									</div>
								<?php
									}
									elseif ($prosentase_billing_visit_on_day >= 60 && $prosentase_billing_visit_on_day <= 79)
									{
								?>
									<div class="font-yellow status-number">
										<?php echo $prosentase_billing_visit_on_day ?> %
									</div>
								<?php
									}
									else
									{
								?>
									<div class="font-red status-number">
										<?php echo $prosentase_billing_visit_on_day ?> %
									</div>
								<?php
									}
								?>
							</div>
						</div>
						<br />
						<div class="display">
							<div class="number">
								<h3 class="font-blue">
									<span>
										<?php echo $data_tbl_billing_visit_on_day_indo ?>
									</span>
								</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>