<? foreach ($this->listProduct as $key => $value) { ?>	<tr>		<td><? echo $value['code']; ?></td>		<td><a href="javascript:void(0)" onClick="load('product/details/+<? echo $value['id']; ?>', '#content');"><? echo $value['title']; ?></a></td>		<td><? echo $value['writer']; ?></td>		<td><? echo $value['publishername']; ?></td>		<td><? echo $value['classname']; ?></td>		<td><? echo $this->pecah($value['sellprice']); ?></td>		<td><? echo $value['stock']; ?></td>		<td>			<input type="hidden" name="class-<? echo $value['id']; ?>" value="<? echo $value['class']; ?>">			<input type="hidden" name="publisher-<? echo $value['id']; ?>" value="<? echo $value['publisher']; ?>">			<input type="hidden" name="supplier-<? echo $value['id']; ?>" value="<? echo $value['supplier']; ?>">			<input type="hidden" name="code-<? echo $value['id']; ?>" value="<? echo $value['code']; ?>">			<input type="hidden" name="title-<? echo $value['id']; ?>" value="<? echo $value['title']; ?>">			<input type="hidden" name="writer-<? echo $value['id']; ?>" value="<? echo $value['writer']; ?>">			<input type="hidden" name="price-<? echo $value['id']; ?>" value="<? echo $value['price']; ?>">				<input type="hidden" name="sellprice-<? echo $value['id']; ?>" value="<? echo $value['sellprice']; ?>">			<input type="hidden" name="stock-<? echo $value['id']; ?>" value="<? echo $value['stock']; ?>">			<input type="hidden" name="lastopname-<? echo $value['id']; ?>" value="<? echo $value['lastopname']; ?>">			<input type="hidden" name="consignment-<? echo $value['id']; ?>" value="<? echo $value['consignment']; ?>">			<div class="btn-group">				<a class="btn btn-info" href="javascript:void(0)"><i class="icon-edit icon-white"></i> Aksi</a>				<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><span class="caret"></span></a>				<ul class="dropdown-menu">					<li>						<a href="javascript:void(0)" onClick="return selectThis(<? echo $value['id']; ?>)">						<i class="icon-pencil"></i> Lihat Detail</a>					</li>					<li>						<a href="javascript:void(0)" onClick="return showFormUpdateDetails(<? echo $value['id']; ?>)">						<i class="icon-pencil"></i> Update Detail</a>					</li>					<li>						<a href="javascript:void(0)" onClick="return showFormOpname(<? echo $value['id']; ?>)">						<i class="icon-pencil"></i> Stock Opname</a>					</li>					<li>						<a href="javascript:void(0)" onClick="return showFormUpdateClass(<? echo $value['id']; ?>)">						<i class="icon-pencil"></i> Ubah Klasifikasi</a>					</li>					<li>						<a href="javascript:void(0)" onClick="return showFormUpdatePublisher(<? echo $value['id']; ?>)">						<i class="icon-pencil"></i> Ubah Penerbit</a>					</li>					<li>						<a href="javascript:void(0)" onClick="return showFormUpdateConsignment(<? echo $value['id']; ?>)">						<i class="icon-pencil"></i> Set Konsinyasi</a>					</li>					<li>						<a href="javascript:void(0)" onClick="return deleteProduct(<? echo $value['id']; ?>)">						<i class="icon-remove"></i> Hapus</a>					</li>				</ul>			</div>		</td>	</tr><? } ?>