<?php

namespace Rookie\DataComponents;

class LogMaker
{
    protected $verb;
    protected $route;
    protected $ip;
    protected $fileName;


    public function __construct()
    {
      $this->verb = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD']: '---';
      $this->route = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '---' ;
      $this->ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR']: '---' ;
      $this->fileName = date("Y-m-d", time()) . ".log";
    }

    /**
     * Add a new log - Create log file if not exist
     */
    public function add($argument): void
    {
      $data = " | Method : " . $this->verb . " | Route : " . $this->route . " | IP : " . $this->ip . "| Message : " . json_encode($argument, JSON_UNESCAPED_SLASHES);
      file_put_contents(__DIR__ . "/../../Logs/" . $this->fileName, "Date : " . date("Y-m-d") . " | Heure : " . date("H-i-s") . $data . "\n", FILE_APPEND);
    }
}
