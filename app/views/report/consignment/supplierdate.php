<!-- Main Row =============================================== --><div class="container-fluid">	<div class="row-fluid">		<div class="well">			<h2 class="text-info"><a href="<? echo URL; ?>report/consign">Laporan Penjualan Konsinyasi</a></h2>		</div>		<div class="well">			<input id="inputFilterFirstDate" class="span2" type="text" data-provide="datepicker" value="<? echo $this->firstDate; ?>"> S/D 			<input id="inputFilterLastDate" class="span2" type="text" data-provide="datepicker" value="<? echo $this->lastDate; ?>">			<div id="printArea">				<table style="border:none; width:100%;">					<tr>						<th colspan="3"><center>LAPORAN PENJUALAN KONSINYASI</center></th>					</tr>					<tr>						<td colspan="3"><br></td>					</tr>					<tr>						<td width:'40%'>							<p>								TOKO BUKU TOHA PUTRA<br>								Cabang MAKASSAR<br>								Jl. Sultan Alauddin No. 18-19 Komp. Ruko Permata Sari<br>								Telp : 0411-868601, FAX : 0411-868177<br>							</p>						</td>						<td width:'20%'></td>						<td width:'40%'>							SUPPLIER:<br/>							<p><? echo $this->detailConsignment['suppliername']; ?></p>						</td>					</tr>					<tr>						<td colspan="3"><br></td>					</tr>					<tr>						<td><small>PERIODE: <? echo date('d-m-Y', strtotime($this->firstDate)); ?> S/D <? echo date('d-m-Y', strtotime($this->lastDate)); ?></small></td>						<td></td>						<td><small class="pull-right">Tanggal Cetak : <? echo date('d-m-Y'); ?></small></td>					</tr>				</table>				<table class="table table-bordered">					<thead>						<tr>							<th>Tanggal</th>							<th>Kode</th>							<th>Judul / Nama Produk</th>							<th>Supplier</th>							<th><span class="pull-right">Jumlah</span></th>							<th><span class="pull-right">Harga (Rp)</span></th>							<th><span class="pull-right">Bruto (Rp)</span></th>							<th><span class="pull-right">Diskon(%)</span></th>							<th><span class="pull-right">Total (Rp)</span></th>						</tr>					</thead>									<tbody>					<? $sumQty = 0; $sumPrice = 0; $sumBruto = 0; $sumDiscount = 0; $sumTotal = 0;						foreach ($this->listConsignment as $key => $value) { 							$sumQty += $value['total'];							$sumPrice += $value['price'];							$sumBruto += $value['total']*$value['price'];							$sumDiscount += $value['discount']*$value['total'];							$sumTotal += $value['sellprice']*$value['total']; ?>						<tr>							<td><? echo $value['selldate']; ?></td>							<td><? echo $value['code']; ?></td>							<td><? echo $value['title']; ?></td>							<td><a href="javascript:void(0)" onclick="consignSupplier(<? echo $value['supplier']; ?>)"><? echo $value['suppliername']; ?></a></td>							<td><span class="pull-right"><? echo $value['total']; ?></span></td>							<td><span class="pull-right"><? echo $this->pecah($value['price']); ?></span></td>							<td><span class="pull-right"><? echo $this->pecah($value['price']*$value['total']); ?></span></td>							<td><span class="pull-right"><? echo ($value['discount']/$value['price'])*100; ?></span></td>							<td><span class="pull-right"><? echo $this->pecah($value['sellprice']*$value['total']); ?></span></td>						</tr>					<? } ?>						<tr>							<td colspan="4"><span class="pull-right">TOTAL</span></td>							<td><span class="pull-right"><? echo $sumQty; ?></span></td>							<td><span class="pull-right"><? echo $this->pecah($sumPrice); ?></span></td>							<td><span class="pull-right"><? echo $this->pecah($sumBruto); ?></span></td>							<td><span class="pull-right"><? echo $this->pecah($sumDiscount); ?></span></td>							<td><span class="pull-right"><? echo $this->pecah($sumTotal); ?></span></td>						</tr>					</tbody>				</table>			</div>			<div class="pull-right">				<button class="btn btn-inverse" onClick="printArea()"><i class="icon-print icon-white"></i> Cetak</button>			</div>			<br>		</div>	</div></div><script type="text/javascript">	$(function(){		$('#inputFilterFirstDate').datepicker({format: 'yyyy-mm-dd', autoclose : true});		$('#inputFilterLastDate').datepicker({format: 'yyyy-mm-dd', autoclose : true});		$('#inputFilterLastDate').on('changeDate', function(){			filterByDate();		});	})	function filterByDate()	{		var first = $('#inputFilterFirstDate').val();		var last = $('#inputFilterLastDate').val();		if(first != '' && last != '')		{			load("report/consign/"+first+"_"+last,'#content');		}	}</script>