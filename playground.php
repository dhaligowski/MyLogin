<?php

$arr = ['first', 'second', 'third'];
$arr = ['first' => 1, 'second' => 2, 'third' => 3];
$arr = ['first' => ["1a" => "a"], 'second' => 2, 'third' => ["3c" => "c"]];

echo "<pre>";
var_dump($arr);
echo "<pre>";
echo "<pre>";
print_r($arr);
echo "<pre>";
echo $arr['first']["1a"];
echo $arr['third']["3c"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    HELLO WORLD:
</body>

</html>