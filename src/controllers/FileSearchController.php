<?php

namespace FileSearch\Controllers;

use App\Http\Controllers\Controller;
use FileSearch\Search;
use Illuminate\Http\Request;

class FileSearchController extends Controller
{

    private $data = [];

    public function __construct()
    {

    }

    public function index(Request $r)
    {
        if($r->has('q')){
            $search = new Search($r->get('q'), app_path());
            $this->data['items'] = $search->getDatabase();
        }
        if($r->wantsJson() || $r->has('debug')){
            return response()->json($this->data['items']);
        }
        return view('filesearch::search', $this->data);
    }
}