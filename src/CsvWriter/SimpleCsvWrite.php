<?php




class SimpleCsvWrite {


	private $fileName;
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
		$filePipe = fopen( 'php://temp', 'r+' );
		// ... write the $input array to the "file" using fputcsv()...
		fputcsv( $filePipe, $input, $delimiter, $enclosure );
		// ... rewind the "file" so we can read what we just wrote...
		rewind( $filePipe );
		// ... read the entire line into a variable...
		$data = fread( $filePipe, 1048576 );
		// ... close the "file"...
		fclose( $filePipe );
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
