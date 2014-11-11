<?php
	$pdo = new PDO('mysql:dbname=test; host=localhost; charset=utf8', 'root');
	$st = $pdo->query("SELECT * FROM cream");
	$rs = array();
	while ($row = $st->fetch()) {
		$rs += array (
			$row['part'] => $row['name']
		);
	}
	$st = $pdo->query("SELECT * FROM cream");
	while ($row = $st->fetch()) {
		$rs += array (
			$row['id'] => $row['part']
		);
	}
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($rs);