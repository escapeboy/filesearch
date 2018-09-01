<?php namespace FileSearch;

use FileSearch\Models\Words;
use Illuminate\Support\Collection;

class Search {

    private $path, $query;
    private $files = [];
    private $query_result = [];


    function __construct($query='', $path='./')
    {
        $this->path = realpath($path);
        $this->query = $query;

        return $this;
    }

    public function getDatabase()
    {
        $query_words = explode(' ', $this->query);
        $result = new Collection();
        foreach($query_words as $word){
            $db_result = Words::with('file')
                ->whereLength(strlen($word))
                ->where('word', 'like', $word)
                ->get();
            $result = $result->merge($db_result);
        }
        foreach($result as $word){
            $this->query_result[$word->file->name][$word->line] = file($word->file->name)[$word->line];
        }
        return new Collection($this->query_result);
    }

    public function get()
    {
        $this->_check_input();
        $this->_files();
        foreach($this->files as $file){
            $this->searchIn($file);
        }
        return new Collection($this->query_result);
    }

    private function _files($path=null)
    {
        if(!is_null($path)) $this->path = $path;
        $items = new \DirectoryIterator($this->path);
        foreach ($items as $item) {
            if ($item->isDot() || !$item->isReadable()) {
                continue;
            }
            if ($item->isDir()) {
                $this->_files($item->getRealPath());
            } elseif ($item->isFile()) {
                $this->files[] = $item->getRealPath();
            }
        }
    }

    public function searchIn($file, $query=null)
    {
        if(!is_null($query)) $this->query = $query;

        $lines = file($file);
        foreach($lines as $key => $line){
            if(stripos($line, $this->query) !== false){
                $this->query_result[$file][$key] = $line;
            }
        }
    }

    private function _check_input()
    {
        if(empty($this->query)){
            throw new \Exception('No query specified.', 406);
        }
        if(empty($this->path)){
            throw new \Exception('No path specified.', 406);
        }
        if(!file_exists($this->path)){
            throw new \Exception('Path not found.', 404);
        }
    }
}