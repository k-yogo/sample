<?php
    $pdo = new PDO('mysql:dbname=test; host=localhost; charset=utf8', 'root');
    if (!empty($_POST['part']) && !empty($_POST['name'])) {
        $st = $pdo->prepare("INSERT INTO beastie_boys VALUES(?, ?, ?)");
        $st->execute(array(NULL, $_POST['part'], $_POST['name']));
    }
    $i = 0;
    $x = '';
    if (!empty($_POST['delete'])) {
        $st = $pdo->query("SELECT * FROM beastie_boys");
        while ($row = $st->fetch()) {
            global $i, $x;
            if ($i == $_POST['delete']) {
                $x = $row['id'];
            }
            $i += 1;
        }
    };
    $st = $pdo->query("DELETE FROM beastie_boys WHERE id=".$x);
    $st = $pdo->query("SELECT * FROM beastie_boys");
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