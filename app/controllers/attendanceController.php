<?php

class Attendance extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
}