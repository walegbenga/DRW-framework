<?php

namespace Generic\Paginator;

/**
 * Validation Rule interface
 *
 * A generic Rule that asserts whether the given validation
 * data is valid or not.
 *
 * @package Validation
 * @author Gbenga Ogunbule <walegbenga807@gmail.com>
 **/

class Paginate
{
	private $pagename;
	private $totalpages;
	private $recordsperpage;
	private $maxpagesshown;
	private $currentstartpage;
	private $currentendpage;
	private $currentpage;
	//next and previous inactive
	private $spannextinactive;
	private $spanpreviousinactive;
	//first and last inactive
	private $firstinactivespan;
	private $lastinactivespan;
	//must match $_GET['offset'] in calling page
	private $firstparamname = "offset";
	//use as "&amp;name=value" pair for getting
	private $params;
	//css class names
	private $divwrappername = "navigator";
	private $pagedisplaydivname = "totalpagesdisplay";
	private $inactivespanname = "inactive";
	//text for navigation
	private $strfirst = "|&lt;";
	private $strnext = "Next";
	private $strprevious = "Prev";
	private $strlast = "&gt;|";
	//for error reporting
	private $errorstring;

	public function __construct($pagename, $totalrecords, $recordsperpage, $recordoffset, $maxpagesshown = 4, $params = "")
	{
		$this->pagename = $pagename;
		$this->recordsperpage = $recordsperpage;
		$this->maxpagesshown = $maxpagesshown;
		//already urlencoded
		$this->params = $params;

		//check recordoffset a multiple of recordsperpage
		$this->checkRecordOffset($recordoffset, $recordsperpage) or die($this->errorstring);
		$this->setTotalPages($totalrecords, $recordsperpage);
		$this->calculateCurrentPage($recordoffset, $recordsperpage);
		$this->createInactiveSpans();
		$this->calculateCurrentStartPage();
		$this->calculateCurrentEndPage();
	}

	private function checkRecordOffset($recordoffset, $recordsperpage){
		$bln = true;
		
		if($recordoffset%$recordsperpage != 0){
			$this->errorstring = "Error - not a multiple of records per page.";
			$bln = false;
		}
		return $bln;
	}

	private function setTotalPages($totalrecords, $recordsperpage){
		$this->totalpages = ceil($totalrecords/$recordsperpage);
	}

	private function calculateCurrentPage($recordoffset, $recordsperpage){
		$this->currentpage = $recordoffset/$recordsperpage;
	}

	private function createInactiveSpans(){
		$this->spannextinactive = "<span class=\"". "$this->inactivespanname\">$this->strnext</span>\n";
		$this->lastinactivespan = "<span class=\"". "$this->inactivespanname\">$this->strlast</span>\n";
		$this->spanpreviousinactive = "<span class=\"". "$this->inactivespanname\">$this->strprevious</span>\n";
		$this->firstinactivespan = "<span class=\"". "$this->inactivespanname\">$this->strfirst</span>\n";
	}

	private function calculateCurrentStartPage(){
		$temp = floor($this->currentpage/$this->maxpagesshown);
		$this->currentstartpage = $temp * $this->maxpagesshown;
	}

	private function calculateCurrentEndPage(){
		$this->currentendpage = $this->currentstartpage + $this->maxpagesshown;
		if($this->currentendpage > $this->totalpages){
			$this->currentendpage = $this->totalpages;
		}
	}

	public function getNavigator()
	{
		$strnavigator = "<div class=\"$this->divwrappername\">\n";
		//output movefirst button
		if($this->currentpage == 0){
			$strnavigator .= $this->firstinactivespan;
		}else{
			$strnavigator .= $this->createLink(0, $this->strfirst);
		}
	}

	private function createLink($offset, $strdisplay ){
		$strtemp = "<a href=\"$this->pagename?$this->firstparamname=";
		$strtemp .= $offset;
		$strtemp .= "$this->params\">$strdisplay</a>\n";
		return $strtemp;
	}

	//output moveprevious button
	if($this->currentpage == 0){
		$strnavigator .= $this->spanpreviousinactive;
}else{
$strnavigator .= $this->createLink($this->currentpage-1, $this-
>strprevious);
}
}