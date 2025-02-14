<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<i class="fa fa-money"></i> <strong> SUBCONTRACTORS INVOICES</strong>
				</div>
				<div class="panel-body">

					<a class='btn btn-success btn-block' href='<?php echo base_url('workorders/add_invoice/') ?>'>
						<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span> Add Subcontractor Invoice
					</a>

					<br>
					<?php
					if ($information) {
					?>
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
							<thead>
								<tr>
									<th class='text-center' width="10%">Date of Issue</th>
									<th class='text-center' width="30%">Subcontractor</th>
									<th class='text-center' width="15%">Invoice Number</th>
									<th class='text-center' width="20%">Amount</th>
									<th class='text-center' width="15%">Invoice</th>
									<th class='text-center' width="10%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($information as $lista) :
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['date_issue'] . "</td>";
									echo "<td>" . $lista['company'] . "</td>";
									echo "<td class='text-center'>" . $lista['invoice_number'] . "</td>";
									echo "<td class='text-right'>$ " . number_format($lista['invoice_amount'], 2) . "</td>";
									echo "<td class='text-right'>";
									if($lista["file"]){ ?>
										<a href="<?php echo base_url('files/sub_invoices/' .$lista["file"]) ?>" target="_blank">View Invoice</a>
									<?php }
									echo "</td>";
									echo "<td class='text-center'>";
									echo "<a class='btn btn-success btn-xs' href='" . base_url('workorders/add_invoice/' . $lista['id_subcontractor_invoice']) . "' title='Edit'> <span class='glyphicon glyphicon-edit' aria-hidden='true'></a>";
									echo "</td>";
									echo "</tr>";
								endforeach;
								?>
							</tbody>
						</table>
					<?php } ?>

				</div>


				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- Tables -->
<script>
	$(document).ready(function() {
		$('#dataTables').DataTable({
			responsive: true,
			"ordering": false,
			paging: false,
			"searching": false,
			"info": false
		});
	});
</script>