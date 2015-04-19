<?php

class indexModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function login()
	{
		$sth = $this->db->prepare("select employee.name,user.* from employee inner join user on employee.id = user.employee where 
						user.username = :username and user.password = :password");
		$sth->execute(array(':username' => $_POST['username'], 
			':password' => Hash::create('sha256', $_POST['password'], PASSWORD_HASH_KEY)));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			Session::init();
			Session::set('user_id', $data['id']);
			Session::set('user_employee', $data['employee']);
			Session::set('user_userName', $data['username']);
			Session::set('user_fullName', $data['name']);
			Session::set('user_role', $data['role']);
			Session::set('user_loggedIn', true);

			echo json_encode(array('status' => 'GRANTED'));
		}
		else
		{
			echo json_encode(array('status' => 'DENIED'));
		}
	}

	function getTotalProduct()
	{
		return $this->db->select("select count(id) as total from product");
	}

	function getTotalClass()
	{
		return $this->db->select("select count(id) as total from class");
	}

	function getTotalCostumer()
	{
		return $this->db->select("select count(id) as total from costumer");
	}

	function getTodaysSelling()
	{
		return $this->db->select("select count(id) as total from selling where selldate = :selldate and selling.closing = 1", array(':selldate' => date('Y-m-d')));
	}

	function getTodaysSellingValue()
	{
		return $this->db->select("select sum(sellingdetails.sellprice*sellingdetails.total) as total,selling.closing from sellingdetails 
							inner join selling on selling.id = sellingdetails.selling 
							where selling.selldate = :selldate and selling.cash = 1 and selling.closing = 1",
							array(':selldate' => date('Y-m-d')));
	}
}