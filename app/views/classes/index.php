<!-- Main Row =============================================== --><div class="container-fluid">	<div class="row-fluid">				<div class="well">			<h1 class="text-info">Data Klasifikasi</h1>		</div>		<div class="well">			<div class="pull-right">				<button class="btn btn-success" onClick="showFormAddNew()"><i class="icon-plus icon-white"></i> Tambah Baru</button>			</div>			<br><br>			<table class="table table-bordered table-hover">				<thead>					<tr>						<th width='10%'>Nomor</th>						<th>Klasifikasi</th>						<th width='15%'>Aksi</th>					</tr>				</thead>								<tbody id="tblclass">					<? $counter = 0; foreach ($this->listClass as $key => $value) { $counter++;?>						<tr id="class-<? echo $value['id']; ?>">							<td><? echo $counter; ?></td>							<td><? echo $value['name']; ?><input type="hidden" name="name-<? echo $value['id']; ?>" value="<? echo $value['name']; ?>"></td>							<td>								<div class="btn-group">									<a class="btn btn-info" href="javascript:void(0)"><i class="icon-edit icon-white"></i> Aksi</a>									<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><span class="caret"></span></a>									<ul class="dropdown-menu">										<li>											<a href="javascript:void(0)" onClick="return showFormUpdate(<? echo $value['id']; ?>)">											<i class="icon-pencil"></i> Update</a>										</li>										<li>											<a href="javascript:void(0)" onClick="return hapus(<? echo $value['id']; ?>)">											<i class="icon-remove"></i> Hapus</a>										</li>									</ul>								</div>							</td>						</tr>					<? } ?>				</tbody>			</table>		</div>	</div></div><!-- Form Add Class [modal]===================================== --><div id="formAddNew" class="modal hide fade" tabindex="-1" aria-hidden="true">	<div class="modal-header">		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>		<h3 id="myModalLabel">Tambah Klasifikasi</h3>	</div>	<div class="modal-body">		<form class="form-horizontal">			<div class="control-group">				<label class="control-label" for="inputName">Nama Klasifikasi</label>				<div class="controls">					<input name="inputName" class="span3" type="text">				</div>			</div>			</form>	</div>	<div class="modal-footer">		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>		<button class="btn btn-primary" onClick="addNew()" data-dismiss="modal" aria-hidden="true">Simpan</button>	</div></div><!-- End of Form Add Class [modal] --><!-- Form Update Class [modal]===================================== --><div id="formUpdate" class="modal hide fade" tabindex="-1" aria-hidden="true">	<div class="modal-header">		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>		<h3 id="myModalLabel">Update Klasifikasi</h3>	</div>	<div class="modal-body">		<form class="form-horizontal">			<div class="control-group">				<label class="control-label" for="inputUName">Nama Klasifikasi</label>				<div class="controls">					<input type="hidden" name="inputID">					<input name="inputUName" class="span3" type="text">				</div>			</div>			</form>	</div>	<div class="modal-footer">		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>		<button class="btn btn-primary" onClick="update()" data-dismiss="modal" aria-hidden="true">Simpan</button>	</div></div><!-- End of Form Update Class [modal] --><script type="text/javascript">	function showFormAddNew()	{		$('#formAddNew').modal('show');		$('input[name=inputName]').val('');	}	function showFormUpdate(id)	{		$('#formUpdate').modal('show');		$('input[name=inputID]').val(id);		$('input[name=inputUName]').val($('input[name=name-'+id+']').val());	}	function addNew()	{		var name = $('input[name=inputName]').val();		$.post(site+'classes/addnewclass', 			{name : name}, 			function() {				window.location = site+"classes";		});	}	function update()	{		var id = $('input[name=inputID]').val();		var name = $('input[name=inputUName]').val();		$.post(site+'classes/updateclass', 			{id : id, name : name}, 			function(data) {				window.location = site+"classes";		},'json');	}	function hapus(id)	{		if(confirm("Anda Yakin Akan Menghapus Data Ini?"))		{			$.post(site+'classes/deleteclass', {id : id}, function(){				$('#class-'+id).remove();			});		}	}</script>