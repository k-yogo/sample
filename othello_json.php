<?php
	$pdo = new PDO('mysql:dbname=test; host=localhost; charset=utf8', 'root', 'root');
	$st = $pdo->query("SELECT * FROM othello");

	$othello = array();
	while ($row = $st->fetch()) {
		$othello[$row['id']] = array(
			'id' => $row['id'],
			'disc' => $row['disc'],
			'turn' => $row['turn'],
		);
	};

	if (!empty($_POST['id'])) {
		$disc_location = $_POST['id'];
		$turn = $_POST['turn'];
		$x = placeOthello($disc_location, $turn);
		$st = $pdo->query("SELECT * FROM othello");
		if ($x == true){
			while ($row = $st->fetch()) {
				$othello[$row['id']] = array(
					'id' => $row['id'],
					'disc' => $row['disc'],
					'turn' => $row['turn'],
				);
			};
			if ($turn == 1 && checkNext(2) == 2) {
				$pdo->query("UPDATE othello SET turn = 2 WHERE id=1");
			}elseif ($turn == 2 && checkNext(1) == 1) {
				$pdo->query("UPDATE othello SET turn = 1 WHERE id=1");
			}elseif ($turn == 1 && checkNext(2) == 1 && checkNext(1) == 1) {
				$pdo->query("UPDATE othello SET turn = 1 WHERE id=1");
			}elseif ($turn == 2 && checkNext(1) == 2 && checkNext(2) == 2) {
				$pdo->query("UPDATE othello SET turn = 2 WHERE id=1");
			}elseif ($turn == 1 && checkNext(2) == 1 && checkNext(1) == 2) {
				$pdo->query("UPDATE othello SET turn = 3 WHERE id=1");
			}elseif ($turn == 2 && checkNext(1) == 2 && checkNext(2) == 1) {
				$pdo->query("UPDATE othello SET turn = 3 WHERE id=1");
			}
		}
	}elseif (!empty($_POST['reset'])) {
		$st = $pdo->query("UPDATE othello SET disc = 0");
		$st = $pdo->query("UPDATE othello SET disc =1 WHERE id=28 OR id=37");
		$st = $pdo->query("UPDATE othello SET disc =2 WHERE id=29 OR id=36");
		$st = $pdo->query("UPDATE othello SET turn = 2 WHERE id=1");
	};
	$eightLine = array();

	function getEightLine($l){
		global $othello, $eightLine;
		// 上方向のチェック
		for ($i = $l, $n = 0; $i >= 1; $i -= 8, $n++) {
			$eightLine[0][$n] = $othello[$i]['disc'];
		}
//		echo "上: ";
//		foreach ($eightLine[0] as $key => $value) {
//			echo $key.": ".$value."/";
//		}
//		echo "<br>";
// 右上方向のチェック
		for ($i = $l, $n = 0; $i >= 1; $i -= 7, $n++) {
			if (($i - 1) % 8 == 0 && $i != $l) {
				break;
			}else{
				$eightLine[1][$n] = $othello[$i]['disc'];
			}
		}
//		echo "右上: ";
//		foreach ($eightLine[1] as $key => $value) {
//			echo $key.": ".$value."/";
//		}
//		echo "<br>";
// 右方向のチェック
		for ($i = $l, $n = 0;$n <= 7 - (($l -1) % 8); $i++, $n++) {
			$eightLine[2][$n] = $othello[$i]['disc'];
		}
//		echo "右: ";
//		foreach ($eightLine[2] as $key => $value) {
//			echo $key.": ".$value."/";
//		}
//		echo "<br>";
// 右下方向のチェック
		for ($i = $l, $n = 0; $i <= 64; $i += 9, $n++) {
			if (($i - 1) % 8 == 0 && $i != $l) {
				break;
			}else{
				$eightLine[3][$n] = $othello[$i]['disc'];
			}
		}
//		echo "右下: ";
//		foreach ($eightLine[3] as $key => $value) {
//			echo $key.": ".$value."/";
//		}
//		echo "<br>";
// 下方向のチェック
		for ($i = $l, $n = 0; $i <= 64; $i += 8, $n++) {
			$eightLine[4][$n] = $othello[$i]['disc'];
		}
//		echo "下: ";
//		foreach ($eightLine[4] as $key => $value) {
//			echo $key.": ".$value."/";
//		}
//		echo "<br>";
// 左下方向のチェック
		for ($i = $l, $n = 0; $i <= 64; $i += 7, $n++) {
			if ($i % 8 == 0 && $i != $l) {
				break;
			}else{
				$eightLine[5][$n] = $othello[$i]['disc'];
			}
		}
//		echo "左下: ";
//		foreach ($eightLine[5] as $key => $value) {
//			echo $key.": ".$value."/";
//		}
//		echo "<br>";
// 左方向のチェック
		for ($i = $l, $n = 0; $n <= (($l - 1) % 8); $i--, $n++) {
			$eightLine[6][$n] = $othello[$i]['disc'];
		}
//		echo "左: ";
//		foreach ($eightLine[6] as $key => $value) {
//			echo $key.": ".$value."/";
//		}
//		echo "<br>";
// 左上方向のチェック
		for ($i = $l, $n = 0; $i >= 1; $i -= 9, $n++) {
			if ($i % 8 == 0 && $i != $l) {
				break;
			}else{
				$eightLine[7][$n] = $othello[$i]['disc'];	
			}
		}
//		echo "左上: ";
//		foreach ($eightLine[7] as $key => $value) {
//			echo $key.": ".$value."/";
//		}
//		echo "<br>";
//		echo "<br>";
	};

	function placeOthello($l, $t){
		$changed = false;
		global $eightLine;
		getEightLine($l);
		if($t==1 || $t==2){
			for ($i=0; $i < 8; $i++) {
				if(count($eightLine[$i]) > 2 && $eightLine[$i][0] == 0 && $t != $eightLine[$i][1] && $eightLine[$i][1] != 0){
					if ($t == $eightLine[$i][2] && $eightLine[$i][2] != 0) {
						changeOthello($l, $t, $i, 2);
						$changed = true;
					}elseif (count($eightLine[$i]) > 3 && $eightLine[$i][3] != 0) {
						if ($t == $eightLine[$i][3]) {
							changeOthello($l, $t, $i, 3);
							$changed = true;
						}elseif (count($eightLine[$i]) > 4 && $eightLine[$i][4] != 0) {
							if ($t == $eightLine[$i][4]) {
								changeOthello($l, $t, $i, 4);
								$changed = true;
						}elseif (count($eightLine[$i]) > 5 && $eightLine[$i][5] != 0) {
								if ($t == $eightLine[$i][5]) {
									changeOthello($l, $t, $i, 5);
									$changed = true;
							}elseif (count($eightLine[$i]) > 6 && $eightLine[$i][6] != 0) {
									if ($t == $eightLine[$i][6]) {
										changeOthello($l, $t, $i, 6);
										$changed = true;
									}elseif (count($eightLine[$i]) > 7 && $eightLine[$i][7] != 0) {
										if($t == $eightLine[$i][7]){
											changeOthello($l, $t, $i, 7);
											$changed = true;
										}
									}
								}
							}
						}
					}
				}
			}
		}
		unset($GLOBALS['eightLine']);
		return $changed;
	};

	function changeOthello($l, $t, $w, $n){
		global $pdo, $st;
		if ($w == 0) {
			for ($i=$l, $j=0; $j < $n; $i-=8, $j++) { 
				$st = $pdo->query("UPDATE othello SET disc ='".$t."' WHERE id=".$i);
			}
		}elseif ($w == 1) {
			for ($i=$l, $j=0; $j < $n; $i-=7, $j++) { 
				$st = $pdo->query("UPDATE othello SET disc ='".$t."' WHERE id=".$i);
			}
		}elseif ($w == 2) {
			for ($i=$l, $j=0; $j < $n; $i++, $j++) { 
				$st = $pdo->query("UPDATE othello SET disc ='".$t."' WHERE id=".$i);
			}
		}elseif ($w == 3) {
			for ($i=$l, $j=0; $j < $n; $i+=9, $j++) { 
				$st = $pdo->query("UPDATE othello SET disc ='".$t."' WHERE id=".$i);
			}
		}elseif ($w == 4) {
			for ($i=$l, $j=0; $j < $n; $i+=8, $j++) { 
				$st = $pdo->query("UPDATE othello SET disc ='".$t."' WHERE id=".$i);
			}
		}elseif ($w == 5) {
			for ($i=$l, $j=0; $j < $n; $i+=7, $j++) { 
				$st = $pdo->query("UPDATE othello SET disc ='".$t."' WHERE id=".$i);
			}
		}elseif ($w == 6) {
			for ($i=$l, $j=0; $j < $n; $i--, $j++) { 
				$st = $pdo->query("UPDATE othello SET disc ='".$t."' WHERE id=".$i);
			}
		}elseif ($w == 7) {
			for ($i=$l, $j=0; $j < $n; $i-=9, $j++) { 
				$st = $pdo->query("UPDATE othello SET disc ='".$t."' WHERE id=".$i);
			}
		}
	};

	function checkNext($t){
		$next = false;
		for ($j=1; $j <= 64; $j++) { 
			global $eightLine;
			getEightLine($j);
			// echo $j;
			for ($i=0; $i < 8; $i++) {
				if(count($eightLine[$i]) > 2 && $eightLine[$i][0] == 0 && $t != $eightLine[$i][1] && $eightLine[$i][1] != 0){
					if ($t == $eightLine[$i][2] && $eightLine[$i][2] != 0) {
						$next = true;
					}elseif (count($eightLine[$i]) > 3 && $eightLine[$i][3] != 0) {
						if ($t == $eightLine[$i][3]) {
							$next == true;
						}elseif (count($eightLine[$i]) > 4 && $eightLine[$i][4] != 0) {
							if ($t == $eightLine[$i][4]) {
								$next == true;
							}elseif (count($eightLine[$i]) > 5 && $eightLine[$i][5] != 0) {
								if ($t == $eightLine[$i][5]) {
									$next == true;
								}elseif (count($eightLine[$i]) > 6 && $eightLine[$i][6] != 0) {
									if ($t == $eightLine[$i][6]) {
										$next == true;
									}elseif (count($eightLine[$i]) > 7 && $eightLine[$i][7] != 0) {
										if($t == $eightLine[$i][7]){
											$next == true;
										}
									}
								}
							}
						}
					}
				}
			}
		// print_r($eightLine);
		unset($GLOBALS['eightLine']);
		}
		if ($next == true && $t == 1) {
			return 1;
		}elseif ($next == true && $t == 2) {
			return 2;
		}elseif ($next == false && $t == 1) {
			return 2;
		}elseif ($next == false && $t == 2) {
			return 1;
		}
	};

//	$board .= "<table><tr>";
//	for ($i = 1; $i <= 64; $i++) {
//		$board .= "<td>".$othello[$i]['disc']."</td>";
//		if ($i%8 == 0) {
//			$board .= "</tr>";
//		};
//	};
//	echo "next is ".(checkNext(2));
//	echo $board;

	$st = $pdo->query("SELECT * FROM othello");
	$othello = array();
	while ($row = $st->fetch()) {
		$othello[$row['id']] = array(
			'id' => $row['id'],
			'disc' => $row['disc'],
			'turn' => $row['turn'],
		);
	};
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($othello);