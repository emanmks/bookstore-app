<?php

class publisherModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('name' => $_POST['name']);

		$this->db->insert("publisher", $data);
	}

	function update()
	{
		$id = $_POST['id'];
		$data = array('name' => $_POST['name']);

		$this->db->update("publisher", $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete("publisher", "id = $id");
	}

	function getList()
	{
		return $this->db->select("select * from publisher order by name asc");
	}
}