<?php

class consignmentModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('name' => $_POST['name']);

		$this->db->insert("writer", $data);
	}

	function update()
	{
		$id = $_POST['id'];
		$data = array('name' => $_POST['name']);

		$this->db->update("writer", $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete("writer", "id = $id");
	}

	function getList()
	{
		return $this->db->select("select * from writer order by name asc");
	}
}