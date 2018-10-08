
<?php 
if(!defined('SOCKETLABS_INJECTION_API_SAMPLE_ROOT_PATH'))
define('SOCKETLABS_INJECTION_API_SAMPLE_ROOT_PATH', dirname(__DIR__) . '/');

    // check for parameter
    if (isset($_POST['fileNameOfExample'])) {
        runExample($_POST['fileNameOfExample']);
    }

    function  runExample($fileNameOfExample){
 
        $exampleCodePath= "../../ExampleCode/$fileNameOfExample";

        $source = show_source($exampleCodePath);

        return $source;
    }
 ?>