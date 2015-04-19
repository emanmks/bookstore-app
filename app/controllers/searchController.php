<?php

class Search extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->filter = 'title';
		$this->view->param = '';
		$this->view->render('search/index');
	}

	function byTitle($url)
	{
		$slice = explode("_", $url);
		$title = str_replace("space", " ", $slice[1]);

		$this->view->filter = $slice[0];
		$this->view->param = $title;

		$this->view->listProduct = $this->model->searchByTitle($title);
		$this->view->render('search/index');
	}

	function byPublisher($url)
	{
		$slice = explode("_", $url);
		$publisher = str_replace("space", " ", $slice[1]);

		$this->view->filter = $slice[0];
		$this->view->param = $publisher;

		$this->view->listProduct = $this->model->searchByPublisher($publisher);
		$this->view->render('search/index');
	}

	function byWriter($url)
	{	
		$slice = explode("_", $url);
		$name = str_replace("space", " ", $slice[1]);

		$this->view->filter = $slice[0];
		$this->view->param = $name;

		$this->view->listProduct = $this->model->searchByWriter($name);
		$this->view->render('search/index');
	}

	/*function byClass($url)
	{
		$param = explode("_", $url);
		$class = $param[0];
		$title = $param[1];
		$title = str_replace("#", " ", $title);

		$this->view->listProduct = $this->model->searchByClass($class,$title);
		$this->view->render('search/filter', true);
	}*/
}