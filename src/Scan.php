<?php namespace FileSearch;

use FileSearch\Models\Files;

class Scan
{

    private $path;
    private $files = [];
    private $scan_result = [];

    function __construct($path = './')
    {
        $this->path = realpath($path);
        $this->_check_input();
        $this->_files();
        foreach ($this->files as $file) {
            $this->scan_result[$file] = $this->_scan($file);
        }

        return $this;
    }

    private function _check_input()
    {
        if (empty($this->path)) {
            throw new \Exception('No path specified.', 406);
        }
        if (!file_exists($this->path)) {
            throw new \Exception('Path not found.', 404);
        }
    }

    private function _files($path = null)
    {
        if (!is_null($path)) {
            $this->path = $path;
        }
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

    private function _scan($file)
    {
        $lines = file($file);
        $result = [];
        foreach ($lines as $key => $line) {
            $result[$key] = $this->_extractWords($line);
        }

        return $result;
    }

    private function _extractWords($string)
    {
        $words = explode(' ', preg_replace('/[^\w ]+/', '', $string));
        $words = array_filter($words, function ($word) {
            return strlen($word) > 3;
        });

        return $words;
    }

    public function get()
    {
        return $this->scan_result;
    }

    public function save()
    {
        foreach ($this->scan_result as $filename => $lines) {
            $file = Files::firstOrCreate(['name' => $filename]);
            $file->words()->delete();
            foreach ($lines as $line_num => $words) {
                foreach ($words as $word) {
                    $file->words()->create([
                        'word'   => $word,
                        'length' => strlen($word),
                        'line'   => $line_num,
                    ]);
                }
            }
        }
    }
}