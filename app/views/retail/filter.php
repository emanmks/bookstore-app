<? $count = 0; $total = 0;foreach ($this->listTransaction as $key => $value) { 	$count++;  	$value['closing'] == 1 ? $total += $value['total'] : $total += 0; ?>	<tr id="details-<? echo $value['id']; ?>">		<td><? echo $count; ?></td>		<td>			<? echo $value['closing'] == 0 ? 					"<span class='text-error'><strong>#".$value['code']."</strong></span>" : 					"<span class='text-success'><strong>#".$value['code']."</strong></span>"; ?>		</td>		<td><span class="pull-right"><? echo $this->pecah($value['total']); ?></span></td>		<td>			<div class="btn-group">				<a class="btn btn-info" href="javascript:void(0)"><i class="icon-edit icon-white"></i> Aksi</a>				<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><span class="caret"></span></a>				<ul class="dropdown-menu">					<li>						<a href="javascript:void(0)" onClick="return selectThis(<? echo $value['sellingid']; ?>)">						<i class="icon-pencil"></i> Lihat Detail</a>					</li>					<? if($value['closing'] == 0) : ?>						<li>							<a href="javascript:void(0)" onClick="load('retail/newtransaction/'+<? echo $value['sellingid']; ?>,'#content');">							<i class="icon-ok"></i> Lanjutkan Transaksi</a>						</li>					<? endif; ?>				</ul>			</div>		</td>	</tr><? } ?>	<tr>		<td colspan="2"><span class="pull-right"><strong>Total Penjualan</strong></span></td>		<td><span class="pull-right"><strong><? echo $this->pecah($total); ?></strong></span></td>		<td></td>	</tr>