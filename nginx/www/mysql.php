<?php

$db = new PDO('mysql:host=mysql56;dbname=mysql', 'root', 'root');

try {

    foreach ($db->query('select * from user') as $row){

    print_r($row);

    }

    $db = null; //关闭数据库

} catch (PDOException $e) {

    echo $e->getMessage();

}

?>
