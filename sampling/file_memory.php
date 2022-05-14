<?php
$str = 'Hello there';
$fp = fopen('php://memory', 'rw');
fputs($fp, $str);
fputs($fp, $str);
rewind($fp);
var_dump(stream_get_contents($fp));
fclose($fp);