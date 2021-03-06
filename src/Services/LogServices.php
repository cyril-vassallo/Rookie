<?php


namespace App\Services;

class LogServices
{
    protected $date;
    protected $fileName;
    protected $data;

    /**
     * Constructor
     */
    public function __construct()
    {
      $this->verb = $_SERVER['REQUEST_METHOD'];
      $this->route = $_SERVER['REQUEST_URI'];
      $this->ip = $_SERVER['REMOTE_ADDR'];
      $this->date = date("Y-m-d", time());
      $this->fileName = $this->date . ".log";
    }


  /**
   * Add a new log - Create log file is not exist
   *
   * @return void
   */
    public function add(string $message)
    {
      $this->data = " | Method : " . $this->verb . " | Route : " . $this->route . " | IP : " . $this->ip . "| Message : " . $message ;
      file_put_contents(__DIR__ . "/../../Logs/" . $this->fileName, "Date : " . date("Y-m-d") . " | Heure : " . date("H-i-s") . $this->data . "\n", FILE_APPEND);
    }
}

