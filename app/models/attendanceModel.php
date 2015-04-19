<?php

class attendanceModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNewIn()
	{
		$data = array('employee' => $_POST['employee'], 'attdate' => date('Y-m-d H:i:s'));

		$this->db->insert("attin", $data);
	}

	function addNewOut()
	{
		$data = array('employee' => $_POST['employee'], 'attdate' => date('Y-m-d H:i:s'));

		$this->db->insert("attout", $data);
	}

	function deleteIn()
	{
		$id = $_POST['id'];

		$this->db->delete("attin", "id = $id");
	}

	function deleteOut()
	{
		$id = $_POST['id'];

		$this->db->delete("attout", "id = $id");
	}

	function getListAttIn($date)
	{
		return $this->db->select("select employee.code,employee.name,attin.id,attin.attdate from employee 
								inner join attin on employee.id = attin.employee where date(attin.attdate) = :date order by attin.id desc",
								array(':date' => date('Y-m-d', strtotime($date))));
	}

	function getListAttOut($date)
	{
		return $this->db->select("select employee.code,employee.name,attout.id,attout.attdate from employee 
								inner join attout on employee.id = attout.employee where date(attout.attdate) = :date order by attout.id desc",
								array(':date' => date('Y-m-d', strtotime($date))));
	}
}