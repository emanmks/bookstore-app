<?php

class employeeModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('code' => $this->getCode(),
					'name' => $_POST['name'],
					'birthplace' => $_POST['birthplace'],
					'birthdate' => date('Y-m-d', strtotime($_POST['birthdate'])),
					'address' => $_POST['address'],
					'phone' => $_POST['phone']);

		$this->db->insert("employee", $data);
	}

	function getCode()
	{
		$id = 0;
		$sth = $this->db->prepare("select id from employee order by id desc limit 1");
		$sth->execute();

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$id = $data['id'] + 1;
		}
		else
		{
			$id = 1;
		}

		return '20'.$id;
	}

	function update()
	{
		$id = $_POST['id'];

		$data = array('name' => $_POST['name'],
					'birthplace' => $_POST['birthplace'],
					'birthdate' => date('Y-m-d', strtotime($_POST['birthdate'])),
					'address' => $_POST['address'],
					'phone' => $_POST['phone']);

		$this->db->update("employee", $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];

		$this->db->delete("employee", "id = $id");
	}

	function getList()
	{
		return $this->db->select("select * from employee order by id asc");
	}

	function getDetails($id)
	{
		return $this->db->select("select * from employee where id = :id", array(':id' => $id));
	}
}