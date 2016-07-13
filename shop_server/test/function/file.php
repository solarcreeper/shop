<?php
function save($name, $value) {  
    $myfile = fopen($name, "a");
    fwrite($myfile, $value);
    fclose($myfile);
}
?>