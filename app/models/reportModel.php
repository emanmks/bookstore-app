<?php

class reportModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getCostumerDetails($costumer)
	{
		return $this->db->select("select * from costumer where id = :id", array(':id' => $costumer));
	}

	/**
	 * Retail Report
	 */
	function getListRetail($first,$last)
	{
		return $this->db->select("select selling.*,sum(sellingdetails.sellprice*sellingdetails.total) as total from selling inner join sellingdetails on
								selling.id = sellingdetails.selling 
								where selling.costumer = 0 and selling.cash = 1 
								and selling.closing = 1 
								and selling.selldate between :first and :last 
								group by selling.selldate",
								array(':first' => $first, ':last' => $last));
	}

	function getListDailyRetail($date)
	{
		return $this->db->select("select selling.*,sum(sellingdetails.sellprice) as total from selling inner join sellingdetails on
								selling.id = sellingdetails.selling 
								where selling.costumer = 0 and selling.cash = 1 
								and selling.closing = 1 
								and selling.selldate = :date
								group by selling.id",
								array(':date' => $date));
	}

	function getRetailDetails($id)
	{
		return $this->db->select("select employee.name as employeename,selling.* from employee inner join selling on employee.id = selling.employee
								where selling.id = :id",
								array(':id' => $id));
	}

	function getListRetailDetails($selling)
	{
		return $this->db->select("select product.*,sellingdetails.* from (select publisher.name as publishername,product.* from publisher 
										inner join product on publisher.id = product.publisher) as product inner join sellingdetails
								on product.id = sellingdetails.product where sellingdetails.selling = :selling", 
								array(':selling' => $selling));
	}

	/**
	 * Wholesale Report
	 */
	function getListWholesale($first,$last)
	{
		return $this->db->select("select selling.sellingid,selling.code,selling.selldate,selling.closing,selling.costumername,selling.cash,
								selling.total,loan.total as loantotal,loan.dp,loan.balance 
								from (select selling.id as sellingid,selling.code,selling.selldate,selling.closing,selling.costumername,selling.cash,
								sum(sellingdetails.sellprice*sellingdetails.total) as total
								from 
									(select costumer.name as costumername,selling.* from costumer 
										left outer join selling on costumer.id = selling.costumer) as selling 
								left outer join sellingdetails on
								selling.id = sellingdetails.selling 
								group by sellingdetails.selling) as selling left outer join loan on selling.sellingid = loan.selling
								where selling.selldate between :first and :last and selling.closing = 1",
								array(':first' => $first, ':last' => $last));
	}

	function getWholesaleDetails($id)
	{
		return $this->db->select("select costumer.name as costumername,employee.name as employeename,selling.* from (costumer,employee) 
								inner join selling on costumer.id = selling.costumer and employee.id = selling.employee
								where selling.id = :id",
								array(':id' => $id));
	}

	function getListWholesaleDetails($selling)
	{
		return $this->db->select("select product.*,sellingdetails.* from (select publisher.name as publishername,product.* from publisher 
										inner join product on publisher.id = product.publisher) as product inner join sellingdetails
								on product.id = sellingdetails.product where sellingdetails.selling = :selling", 
								array(':selling' => $selling));
	}

	/**
	 * Loan Report
	 */
	function getListLoan()
	{
		return $this->db->select("select costumer.id as costumerid,costumer.name as costumername,selling.id as sellingid,selling.code as sellingcode,
								loan.* from (costumer,selling) 
								inner join loan on costumer.id = loan.costumer and selling.id = loan.selling");
	}

	function getLoanDetails($id)
	{
		return $this->db->select("select selling.code as sellcode,selling.selldate,
								costumer.id as costumerid, costumer.code as costumercode, costumer.name as costumername,
								employee.id as employeeid, employee.code as employeecode, employee.name as employeename,
								loan.* from (costumer,employee,selling)
								inner join loan on costumer.id = loan.costumer and employee.id = loan.employee and selling.id = loan.selling 
								where loan.id = :id", 
								array(':id' => $id));
	}

	function getLoanHistoryCostumer($costumer)
	{
		return $this->db->select("select costumer.id as costumerid,costumer.name as costumername,loan.* from costumer 
								inner join loan on costumer.id = loan.costumer where loan.costumer = :costumer", 
								array(':costumer' => $costumer));
	}

	function getLoanHistoryPayment($loan)
	{
		return $this->db->select("select employee.name as employeename,loanpayment.* from employee inner join loanpayment on
								employee.id = loanpayment.employee where loanpayment.loan = :loan", array(':loan' => $loan));
	}

	function getListLoanBySettlement($status)
	{
		return $this->db->select("select costumer.name as costumername,employee.name as employeename,loan.* from (costumer,employee)
								inner join loan on 
								costumer.id = loan.costumer and employee.id = loan.employee 
								where loan.settled = :status order by loan.id desc", array(':status' => $status));
	}

	/**
	 * Payment Report
	 */
	function getListPayment($first,$last)
	{
		return $this->db->select("select loan.*,loanpayment.*,employee.name as employeename from 
									((select costumer.name as costumername,loan.* from costumer inner join loan on 
									costumer.id = loan.costumer) as loan,employee) inner join loanpayment on loan.id = loanpayment.loan
								and employee.id = loanpayment.employee
								where loanpayment.paydate between :first and :last", array(':first' => $first, ':last' => $last));
	}

	/**
	 * Cosignment Report
	 */
	function getListConsignment($first,$last)
	{
		return $this->db->select("select product.*,selling.code,selling.selldate,sellingdetails.* from 
									((select supplier.name as suppliername,product.* from supplier inner join product on
									supplier.id = product.supplier where product.consignment = 1) as product,selling) inner join sellingdetails on 
								product.id = sellingdetails.product and selling.id = sellingdetails.selling 
								where selling.selldate between :fisrt and :last", 
								array(':fisrt' => $first, ':last' => $last));
	}

	function getListConsignmentSupplier($supplier)
	{
		return $this->db->select("select product.*,selling.code,selling.selldate,sellingdetails.* from 
									((select supplier.name as suppliername,product.* from supplier inner join product on
									supplier.id = product.supplier where product.consignment = 1) as product,selling) inner join sellingdetails on 
								product.id = sellingdetails.product and selling.id = sellingdetails.selling 
								where product.supplier = :supplier", 
								array(':supplier' => $supplier));
	}

	function getListConsignmentSupplierDate($supplier,$first,$last)
	{
		return $this->db->select("select product.*,selling.code,selling.selldate,sellingdetails.* from 
									((select supplier.name as suppliername,product.* from supplier inner join product on
									supplier.id = product.supplier where product.consignment = 1) as product,selling) inner join sellingdetails on 
								product.id = sellingdetails.product and selling.id = sellingdetails.selling 
								where product.supplier = :supplier and selling.selldate between :fisrt and :last", 
								array(':supplier' => $supplier, ':fisrt' => $first, ':last' => $last));
	}

	/**
	* Stock Reports
	**/
	function getListPublisher()
	{
		return $this->db->select("select * from publisher");
	}

	function getListStock()
	{
		return $this->db->select("select product.*,publisher.name from publisher inner join product on publisher.id = product.publisher where product.publisher = 2");
	}

	function getListStockFiltered($publisher)
	{
		return $this->db->select("select product.*,publisher.name from publisher inner join product on publisher.id = product.publisher where product.publisher = :publisher", array(':publisher' => $publisher));
	}
}