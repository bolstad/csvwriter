<?php 

namespace CsvWriter;

class WriteFile {
  public $lineEnding="\n";
  private $file;
  private $fileHandle;

  function __construct($file,$mode='w'){
    $this->file=$file;
    if ( !$this->fileHandle = fopen( $this->file, $mode ) ) {
      throw new \Exception("Cannot open file ($this->file)");
    }
  }

  function write( $str = '' ) {
    if ( fwrite( $this->fileHandle, $str ) === FALSE ) {
        throw new \Exception("Cannot write to file ($this->file)");
    }
  }

  function writeLine( $str = '' ) {
    if ( fwrite( $this->fileHandle, $str.$this->lineEnding ) === FALSE ) {
        throw new \Exception("Cannot write to file ($this->file)");
    }
  }

    function __destruct() {
      fclose( $this->fileHandle );
    }
  }
