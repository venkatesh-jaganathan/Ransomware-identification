<?php
$data = "Hello World";

echo crypt($data, '$2a$07$usesomesillystringforsalt$');
?>