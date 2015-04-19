<?php

class placeModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('name' => $_POST['name']);

		$this->db->insert("place", $data);
	}

	function update()
	{
		$id = $_POST['id'];
		$data = array('name' => $_POST['name']);

		$this->db->update("place", $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete("place", "id = $id");
	}

	function getList()
	{
		return $this->db->select("select * from place order by name asc");
	}
}