csvwriter
=========

Simple system for writing an array to CSV row by row

```php 

date_default_timezone_set('Europe/Stockholm');

$ding = new CsvWriter\SimpleCsvWrite('out.csv','data/');
$demo = array('id'=>1,'name'=>'A nice name','city'=>'location');
$ding->writeCsv($demo);

```
