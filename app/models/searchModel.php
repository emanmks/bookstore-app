<?php

class searchModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getListClass()
	{
		return $this->db->select("select * from class");
	}

	function searchByTitle($title)
	{
		return $this->db->select("select class.name as classname, publisher.name as publishername, supplier.name as suppliername,product.* from product 
								left outer join class on product.class = class.id 
								left outer join publisher on product.publisher = publisher.id 
								left outer join supplier on product.supplier = supplier.id 
								where product.title like '%$title%' order by product.title asc");
	}

	function searchByPublisher($publisher)
	{
		return $this->db->select("select class.name as classname, publisher.name as publishername, supplier.name as suppliername,product.* from product 
								left outer join class on product.class = class.id 
								left outer join publisher on product.publisher = publisher.id 
								left outer join supplier on product.supplier = supplier.id 
								where publisher.name like '%$publisher%' order by publishername asc");
	}

	function searchByWriter($writer)
	{
		return $this->db->select("select class.name as classname, publisher.name as publishername, supplier.name as suppliername,product.* from product 
								left outer join class on product.class = class.id 
								left outer join publisher on product.publisher = publisher.id 
								left outer join supplier on product.supplier = supplier.id 
								where product.writer like '%$writer%' order by product.writer asc");
	}

	/*function searchByClass($class,$title)
	{
		return $this->db->select("select class.name as classname, publisher.name as publishername, supplier.name as suppliername,product.* from product 
								left outer join class on product.class = class.id 
								left outer join publisher on product.publisher = publisher.id 
								left outer join supplier on product.supplier = supplier.id 
								where product.class = :class product.title like '%$title%' order by product.title asc", array(':class' => $class));
	}*/
}