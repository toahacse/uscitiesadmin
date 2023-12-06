<?php

namespace Toaha\UsCitiesAdmin\Http\Controllers;

use App\Http\Controllers\Controller;

class UsCitiesFileUploadController extends Controller
{
	
    public function index()
	{
		$rowsPerPage = 20;
		return view("uscitiesadmin::us-cities.index", compact('rowsPerPage'));
	}

    public function import()
	{
		return view("uscitiesadmin::us-cities.import");
	}

}
