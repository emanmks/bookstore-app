<?php

class userModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('employee' => $_POST['employee'],
					'username' => $_POST['username'],
					'password' => Hash::create('SHA256', $_POST['password'], PASSWORD_HASH_KEY),
					'role' => $_POST['role']);

		$this->db->insert("user", $data);
	}

	function updateDetails()
	{
		$id = $_POST['id'];
		$data = array('username' => $_POST['username'], 'role' => $_POST['role']);

		$this->db->update("user", $data, "id = $id");
	}

	function updatePassword()
	{
		$id = $_POST['id'];
		$data = array('password' => Hash::create('SHA256', $_POST['password'], PASSWORD_HASH_KEY));

		$this->db->update("user", $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];

		$this->db->delete("user", "id = $id");
	}

	function getList()
	{
		return $this->db->select("select employee.code as employeecode,employee.name as employeename,user.* from employee inner join user on
								employee.id = user.employee");
	}

	function getListEmployee()
	{
		return $this->db->select("select id,code,name from employee");
	}
}