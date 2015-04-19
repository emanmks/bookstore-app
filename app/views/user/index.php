<div class="container-fluid">
	<div class="row-fluid">
		<div class="well">
			<h1 class="text-info">Data User</h1>
		</div>
	</div>
	
	<div class="pull-right"> 
	<button class="btn btn-success" onClick="showFormAddUser()">Tambah Baru</button> 
	</div> <br><br>

	<div id="dataview">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Nama Karyawan</th>
					<th>Nama User</th>
					<th>Hak Akses</th>
					<th width="10%">Aksi</th>
				</tr>	
			</thead>
			<tbody>
				<? foreach ($this->listUser as $key => $value) { ?>
					<tr>
						<td><? echo $value['employeename']; ?></td>
						<td>
							<? echo $value['username']; ?>
							<input type="hidden" name="username-<? echo $value['id']; ?>" value="<? echo $value['username']; ?>">
						</td>
						<td>
							<? switch ($value['role']) {
								case 'admin':
									echo 'Administrator';
									break;
								case 'cashier':
									echo 'Kasir';
									break;
								case 'inventory':
									echo 'Inventory';
									break;
								default:
									echo 'Tidak Diketahui';
									break;
							} ?>
						</td>
						<td>
							<input type="hidden" name="role-<? echo $value['id']; ?>" value="<? echo $value['role']; ?>">
							<div class="btn-group">
								<a class="btn btn-info" href="javascript:void(0)"><i class="icon-edit icon-white"></i> Aksi</a>
								<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li>
										<a href="javascript:void(0)" onClick="showFormUpdatePassword(<? echo $value['id']; ?>)">
										<i class="icon-list-alt"></i> Update Password</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="resetPassword(<? echo $value['id']; ?>)">
										<i class="icon-list-alt"></i> Reset Password</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="showFormUpdate(<? echo $value['id']; ?>)">
										<i class="icon-list-alt"></i> Update</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="deleteUser(<? echo $value['id']; ?>)">
										<i class="icon-remove"></i> Hapus</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>	
				<? } ?>
			</tbody>
		</table>
	</div>	
		
</div>

<!-- Form Update Password [modal]
===================================== -->
<div id="formUpdatePassword" class="modal hide fade" tabindex="-1" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Update Password</h3>
	</div>

	<div class="modal-body">
		<form class="form-horizontal">
			<input type="hidden" name="inputPUserID">

			<div class="control-group">
				<label class="control-label" for="inputUserPassword">Password Baru</label>
				<div class="controls">
					<input type="password" name="inputUserPassword" class="span2">
				</div>
			</div>
		</form>
	</div>

	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		<button class="btn btn-primary" onClick="changePassword()" data-dismiss="modal" aria-hidden="true">Update Password!!</button>
	</div>
</div>
<!-- End of Form Reset Password [modal] -->

<!-- Form Update [modal]
===================================== -->
<div id="formUpdate" class="modal hide fade" tabindex="-1" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Set Hak Ases</h3>
	</div>

	<div class="modal-body">
		<form class="form-horizontal">
			<input type="hidden" name="inputUUserID">
			<div class="control-group">
				<label class="control-label" for="inputUserName">Nama User</label>
				<div class="controls">
					<input name="inputUserName" class="span2" type="text">
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="inputRole">Hak Akses</label>
				<div class="controls">
					<select name="inputRole">
						<option value="">--Pilih</option>
						<option value="admin">Administrator</option>
						<option value="cashier">Kasir</option>
						<option value="inventory">Inventory</option>
					</select>
				</div>
			</div>
		</form>
	</div>

	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		<button class="btn btn-primary" onClick="update()" data-dismiss="modal" aria-hidden="true">Terapkan</button>
	</div>
</div>
<!-- End of Form Reset Password [modal] -->

<!-- Form Add User [modal]
===================================== -->
<div id="formAddNewUser" class="modal hide fade" tabindex="-1" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Tambah User</h3>
	</div>

	<div class="modal-body">
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label" for="inputNewEmployee">Karyawan</label>
				<div class="controls">
					<select name="inputNewEmployee" class="span3">
						<option value="0">--Pilih Pegawai</option>
						<? foreach ($this->listEmployee as $key => $value) { ?>
							<option value="<? echo $value['id']; ?>"><? echo $value['code'].'-'.$value['name']; ?></option>
						<? } ?>
					</select>
				</div>
			</div>	

			<div class="control-group">
				<label class="control-label" for="inputNewUserName">Nama User</label>
				<div class="controls">
					<input name="inputNewUserName" class="span2" type="text">
				</div>
			</div>	

			<div class="control-group">
				<label class="control-label" for="inputNewUserPassword">Password</label>
				<div class="controls">
					<input type="password" name="inputNewUserPassword" class="span2">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="inputNewRole">Hak Akses</label>
				<div class="controls">
					<select name="inputNewRole">
						<option value="">--Pilih</option>
						<option value="admin">Administrator</option>
						<option value="cashier">Kasir</option>
						<option value="inventory">Inventory</option>
					</select>
				</div>
			</div>
		</form>
	</div>

	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		<button class="btn btn-primary" onClick="addNew()" data-dismiss="modal" aria-hidden="true">Tambah User</button>
	</div>
</div>
<!-- End of Add User [modal] -->

<script type="text/javascript">
	function addNew()
	{
		var employee = $('select[name=inputNewEmployee]').val();
		var username = $('input[name=inputNewUserName]').val();
		var password = $('input[name=inputNewUserPassword]').val();
		var role = $('select[name=inputNewRole]').val();

		if(employee != 0 || username != '' || password != '' || role != '')
		{
			$.ajax({
				type:'POST',
				url:site+'/user/addnew',
				data:{employee : employee, username : username, password : password, role : role},
				dataType:'json',
				cache:false,
				success:function()
				{
					window.location = site+"user";
				}
			});
		}
		else
		{
			window.alert('Mohon Lengkapi Data yang harus Diinput');
		}
		
	}

	function changePassword(id)
	{
		var id = $('input[name=inputPUserID]').val();
		var password = $('input[name=inputUserPassword]').val();

		if(id != '' || password != '')
		{
			$.ajax({
				type:'POST',
				url:site+'/user/updatepassword',
				data:{id : id, password : password},
				dataType:'json',
				cache:false,
				success:function()
				{
					window.location = site+"user";
				}
			});
		}
		else
		{
			window.alert('Mohon Lengkapi Data yang harus Diinput');
		}
	}

	function resetPassword(id)
	{
		var password = 'tohaputra';

		if(id != '' || password != '')
		{
			$.ajax({
				type:'POST',
				url:site+'/user/updatepassword',
				data:{id : id, password : password},
				dataType:'json',
				cache:false,
				success:function()
				{
					window.alert('Password telah direset ke Password default');
					window.location = site+"user";
				}
			});
		}
		else
		{
			window.alert('Mohon Lengkapi Data yang harus Diinput');
		}
	}

	function update()
	{
		var id = $('input[name=inputUUserID]').val();
		var username = $('input[name=inputUserName]').val();
		var role = $('select[name=inputRole]').val();

		if(id != '' || role != '' || username != '')
		{
			$.ajax({
				type:'POST',
				url:site+'/user/updatedetails',
				data:{id : id, username : username, role : role},
				dataType:'json',
				cache:false,
				success:function()
				{
					window.location = site+"user";
				}
			});
		}
		else
		{
			window.alert('Mohon Lengkapi Data yang harus Diinput');
		}
	}

	function deleteUser(id)
	{
		if(confirm("Anda Yakin Akan Menghapus User Ini?"))
		{
			$.ajax({
				type:'POST',
				url:site+'/user/delete',
				data:{id : id},
				dataType:'json',
				cache:false,
				success:function()
				{
					window.location = site+"user";
				}
			});
		}
	}

	function showFormUpdatePassword(id)
	{
		$('#formUpdatePassword').modal('show');
		$('input[name=inputPUserID]').val(id);
		$('input[name=inputUserPassword]').val('');
	}

	function showFormUpdate(id)
	{
		$('#formUpdate').modal('show');
		$('input[name=inputUUserID]').val(id);
		$('input[name=inputUserName]').val($('input[name=username-'+id+']').val());
		$('select[name=inputRole]').val($('input[name=role-'+id+']').val());
	}

	function showFormAddUser()
	{
		$('#formAddNewUser').modal('show');
	}
</script>