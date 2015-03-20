<?php


class writeFile {
  public $lineEnding="\n";
  private $file;
  private $fileHandle;

  function __construct($file,$mode='w'){
    $this->file=$file;
    if ( !$this->fileHandle = fopen( $this->file, $mode ) ) {
      throw new Exception("Cannot open file ($this->file)");
    }
  }

  function write( $str = '' ) {
    if ( fwrite( $this->fileHandle, $str ) === FALSE ) {
        throw new Exception("Cannot write to file ($this->file)");
    }
  }

  function writeLine( $str = '' ) {
    if ( fwrite( $this->fileHandle, $str.$this->lineEnding ) === FALSE ) {
        throw new Exception("Cannot write to file ($this->file)");
    }
  }

    function __destruct() {
      fclose( $this->fileHandle );
    }
  }


class SimpleCsvWrite {


	private $fileName;
	private $fileHandle;
	private $logFileHeaderSet;
	private $orderLog;
	private $folderName = 'data/'; 
	private $orderLogfileExtension = '.csv';
	private $orderLogfile;

	function __construct( $fileName ) {
		$this->fileName=$fileName;
		$this->logFileHeaderSet = 0;
	    $this->orderLogfile=($this->folderName.$this->fileName.'_'.date("o_m_d_Hi").".".$this->orderLogfileExtension);
	    $this->orderLog = new writeFile($this->orderLogfile);

	}


	/* From: http://www.php.net/manual/en/function.str-getcsv.php#88773 and http://www.php.net/manual/en/function.str-getcsv.php#91170 */
	function str_putcsv( $input, $delimiter = ';', $enclosure = '"' ) {
		// Open a memory "file" for read/write...
		$fp = fopen( 'php://temp', 'r+' );
		// ... write the $input array to the "file" using fputcsv()...
		fputcsv( $fp, $input, $delimiter, $enclosure );
		// ... rewind the "file" so we can read what we just wrote...
		rewind( $fp );
		// ... read the entire line into a variable...
		$data = fread( $fp, 1048576 );
		// ... close the "file"...
		fclose( $fp );
		// ... and return the $data to the caller, with the trailing newline from fgets() removed.
		return rtrim( $data, "\n" );
	}


	function writeCsv( $data ) {
		if ( $this->logFileHeaderSet == 0 ) {
			$orderRowHeader = array_keys( $data );
			$orderRowHeaderLine = $this->str_putcsv( $orderRowHeader );
			$this->orderLog->writeLine( $orderRowHeaderLine );
			echo $orderRowHeaderLine . "\n";
			$this->logFileHeaderSet++;
			print_r( $orderRowHeader );
			//                die;
		}
		print_r( $data );
		$orderRowData = array_values( $data );
		$orderRowDataLine =  $this->str_putcsv( $orderRowData );

		echo "$orderRowDataLine\n";
		print_r( $orderRowData );

		$this->orderLog->writeLine( $orderRowDataLine );
	}


}
