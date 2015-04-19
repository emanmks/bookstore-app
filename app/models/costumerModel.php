<?php

class costumerModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('code' => $this->getCode(),
					'name' => $_POST['name'],
					'address' => $_POST['address'],
					'phone' => $_POST['phone']);

		$this->db->insert("costumer", $data);
	}

	function getCode()
	{
		$id = 0;
		$sth = $this->db->prepare("select id from costumer order by id desc limit 1");
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

		return '30'.$id;
	}

	function update()
	{
		$id = $_POST['id'];
		$data = array('name' => $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone']);

		$this->db->update("costumer", $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];

		$this->db->delete("costumer", "id = $id");
	}

	function getList()
	{
		return $this->db->select("select * from costumer order by id desc");
	}

	function getListJson()
	{
		$name = $_POST['param'];
		$jsonData = $this->db->select("select id,name from costumer where name like '%$name%'");

		echo json_encode($jsonData);
	}	
}