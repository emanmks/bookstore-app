<?php

class classesModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	/* Class */
	function addNewClass()
	{
		$data = array('name' => $_POST['name']);

		$this->db->insert("class", $data);
	}

	function updateClass()
	{
		$id = $_POST['id'];
		$data = array('name' => $_POST['name']);

		$this->db->update("class", $data, "id = $id");
	}

	function deleteClass()
	{
		$id = $_POST['id'];
		$this->db->delete("class", "id = $id");
	}

	function getListClass()
	{
		return $this->db->select("select * from class order by name asc");
	}
	/* End of Class */

	/* Classification */
	function addNewClassification()
	{
		$data = array('product' => $_POST['product'], 'class' => $_POST['class']);

		$this->db->insert("classification", $data);
	}

	function deleteClassification()
	{
		$id = $_POST['id'];

		$this->db->delete("classification", "id = $id");
	}
}