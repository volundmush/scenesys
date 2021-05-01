<?php

require_once "vendor/autoload.php";

use MudString\PennMUSH;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;

$t = PennMUSH::decode("Have some \002chru\003very red\002c/\003 text!\n");
$tr = $t->render(true, true, true, true);
print($tr . "\n");

$t2 = PennMUSH::ansi_function("#4582b4", "Dragons for everyone!\n");
$t2r =$t2->render(true, true, true, true);
print($t2r . "\n");

$conv = new AnsiToHtmlConverter();

$c = $conv->convert($tr);
$c2 = $conv->convert($t2r);

$arr = array();
array_push($arr, ["owner"=>"me", "text"=>$c]);
array_push($arr, ["owner"=>"me", "text"=>$c2]);

$scene = ["title"=>"a test", "poses"=>$arr];

echo json_encode($scene);

?>
