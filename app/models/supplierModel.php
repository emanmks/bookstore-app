<?php

class supplierModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('name' => $_POST['name']);

		$this->db->insert("supplier", $data);
	}

	function update()
	{
		$id = $_POST['id'];
		$data = array('name' => $_POST['name']);

		$this->db->update("supplier", $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete("supplier", "id = $id");
	}

	function getList()
	{
		return $this->db->select("select * from supplier order by name asc");
	}

	function getJsonListSupplier()
	{
		$name = $_POST['param'];
		$jsonData = $this->db->select("select * from supplier where name like '%$name%'");
		echo json_encode($jsonData);
	}
}