<?php
    $pdo = new PDO('mysql:dbname=test; host=localhost; charset=utf8', 'root');
    $st = $pdo->query("SELECT * FROM cream");
    $i = 0;
    $rs = array();
    while ($row = $st->fetch()) {
        global $i, $rs;
        $rs[$i] = array(
            'part' => $row['part'],
            'name' => $row['name']
        );
        $i += 1;
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($rs);