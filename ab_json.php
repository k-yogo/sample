<?php
	$pdo = new PDO('mysql:dbname=test; host=localhost; charset=utf8', 'root');
	if (!empty($_POST['turn'])) {
		if ($_POST['turn'] == 'A') {
			$st = $pdo->query("UPDATE ab SET turn ='B' WHERE id=1");
			$st = $pdo->query("UPDATE ab SET ab ='A' WHERE id=".$_POST['id']);
		}elseif ($_POST['turn'] == 'B') {
			$st = $pdo->query("UPDATE ab SET turn ='A' WHERE id=1");
			$st = $pdo->query("UPDATE ab SET ab ='B' WHERE id=".$_POST['id']);
		}
	};
	if (!empty($_POST['reset'])) {
		$st = $pdo->query("UPDATE ab SET ab ='?'");
		$st = $pdo->query("UPDATE ab SET turn ='A' WHERE id=1");
	};
	$st = $pdo->query("SELECT * FROM ab");
	$i = 0;
	$abc = array();
	while ($row = $st->fetch()) {
		$abc[$row['id']] = array(
			'id' => $row['id'],
			'ab' => $row['ab'],
			'turn' => $row['turn'],
		);
	};
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($abc);