<!-- Main Row 
=============================================== -->
<div class="container-fluid">
	<div class="row-fluid">

		<div class="well">
			<h2 class="text-info"><a href="<? echo URL; ?>report/stock">Laporan Stock</a></h2>
		</div>

		<div class="well">
			<select name="filterPublisher" onChange="filterProduct()">
				<option value="">--Pilih Penerbit</option>
				<? foreach ($this->listPublisher as $key => $value) { ?>
					<option value="<? echo $value['id']; ?>"><? echo $value['name']; ?></option>
				<? } ?>
			</select>
			
			<div id="printArea">
				<table style="border:none; width:100%;">
					<tr>
						<th colspan="3"><center>LAPORAN STOK</center></th>
					</tr>
					<tr>
						<td colspan="3"><br></td>
					</tr>
					<tr>
						<td width:'40%'>
							<p>
								TOKO BUKU TOHA PUTRA<br>
								Cabang MAKASSAR<br>
								Jl. Sultan Alauddin No. 18-19 Komp. Ruko Permata Sari<br>
								Telp : 0411-868601, FAX : 0411-868177<br>
							</p>
						</td>
						<td width:'20%'></td>
						<td width:'40%'></td>
					</tr>
					<tr>
						<td colspan="3"><br></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><small class="pull-right">Tanggal Cetak : <? echo date('d-m-Y'); ?></small></td>
					</tr>
				</table>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">Penerbit</th>
							<th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">Judul</th>
							<th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">Stok</th>
							<th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">Harga Pokok</th>
							<th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">Harga Jual</th>
							<th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">Bruto</th>
							<th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">Netto</th>
						</tr>
					</thead>
				

					<tbody>
					<? foreach ($this->listStock as $key => $value) { ?>
						<tr>
							<td><? echo $value['name']; ?></td>
							<td><? echo $value['title']; ?></td>
							<td><? echo $value['stock']; ?></td>
							<td><? echo $this->pecah($value['price']); ?></td>
							<td><? echo $this->pecah($value['sellprice']); ?></td>
							<td><? echo $this->pecah($value['stock']*$value['sellprice']); ?></td>
							<td><? echo $this->pecah($value['stock']*($value['sellprice']-$value['price'])); ?></td>
						</tr>
					<? } ?>
					</tbody>
				</table>
			</div>

			<div class="pull-right">
				<button class="btn btn-inverse" onClick="printArea()"><i class="icon-print icon-white"></i> Cetak</button>
			</div>
			<br>

		</div>
	</div>
</div>

<script type="text/javascript">
	function filterProduct()
	{
		var publisher = $('select[name=filterPublisher]').val();
		window.location = site+"report/stock/"+publisher;
	}
</script>