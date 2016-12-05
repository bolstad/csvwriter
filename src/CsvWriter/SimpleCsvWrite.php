<?php


namespace CsvWriter;


class SimpleCsvWrite {


	private $fileName;
	private $logFileHeaderSet;
	private $orderLog;
	private $folderName = 'data/';
	private $orderLogfile;

	function __construct( $fileName, $directoryName ) {

		$this->fileName = $fileName;
		$this->folderName = $directoryName;

		$this->logFileHeaderSet = 0;

		$this->verifyDirectory( $directoryName );

		$this->orderLogfile = $directoryName .   '/'. $fileName;
		$this->orderLog = new WriteFile( $this->orderLogfile );

	}


	function verifyDirectory( $directoryName ) {
		// If dir exist everything is fine and dandy
		if ( file_exists( $directoryName ) && is_dir( $directoryName ) )
			return 1;

		// If if exist a file with our dirname, abort
		if ( file_exists( $directoryName ) && !is_dir( $directoryName ) )
			throw new \Exception( "Exist but is not an directory: $directoryName" );

		// At last, create the dir
		if ( !mkdir( $directoryName ) )
			throw new \Exception( "Failed to create directory: $directoryName" );

		return 1;
	}

	/* From: http://www.php.net/manual/en/function.str-getcsv.php#88773 and http://www.php.net/manual/en/function.str-getcsv.php#91170 */
	function str_putcsv( $input, $delimiter = ',', $enclosure = '"' ) {
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
			$this->logFileHeaderSet++;
		}
		$orderRowData = array_values( $data );
		$orderRowDataLine =  $this->str_putcsv( $orderRowData );
		$this->orderLog->writeLine( $orderRowDataLine );
	}


}
