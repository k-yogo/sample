<?php
	$pdo = new PDO('mysql:dbname=test; host=localhost; charset=utf8', 'root', 'root');
	$st = $pdo->query("SELECT * FROM othello");

	$othello = array();
	$eightLine = array();

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
			if ($turn == 1 && checkNext(2) == true) {
				$pdo->query("UPDATE othello SET turn = 2 WHERE id=1");
			}elseif ($turn == 2 && checkNext(1) == true) {
				$pdo->query("UPDATE othello SET turn = 1 WHERE id=1");
			}elseif ($turn == 1 && checkNext(2) == false && checkNext(1) == true) {
				$pdo->query("UPDATE othello SET turn = 1 WHERE id=1");
			}elseif ($turn == 2 && checkNext(1) == false && checkNext(2) == true) {
				$pdo->query("UPDATE othello SET turn = 2 WHERE id=1");
			}elseif (checkNext(1) == false && checkNext(2) == false) {
				$pdo->query("UPDATE othello SET turn = 3 WHERE id=1");
			}
		}
	}elseif (!empty($_POST['reset'])) {
		$st = $pdo->query("UPDATE othello SET disc = 0");
		$st = $pdo->query("UPDATE othello SET disc =1 WHERE id=28 OR id=37");
		$st = $pdo->query("UPDATE othello SET disc =2 WHERE id=29 OR id=36");
		$st = $pdo->query("UPDATE othello SET turn = 2 WHERE id=1");
	};

	function getEightLine($l){
		// 上方向のチェック
		for ($i = $l, $n = 0; $i >= 1; $i -= 8, $n++) {
			$GLOBALS['eightLine'][0][$n] = $GLOBALS['othello'][$i]['disc'];
		}
		// 右上方向のチェック
		for ($i = $l, $n = 0; $i >= 1; $i -= 7, $n++) {
			if (($i - 1) % 8 == 0 && $i != $l) {
				break;
			}else{
				$GLOBALS['eightLine'][1][$n] = $GLOBALS['othello'][$i]['disc'];
			}
		}
		// 右方向のチェック
		for ($i = $l, $n = 0;$n <= 7 - (($l -1) % 8); $i++, $n++) {
			$GLOBALS['eightLine'][2][$n] = $GLOBALS['othello'][$i]['disc'];
		}
		// 右下方向のチェック
		for ($i = $l, $n = 0; $i <= 64; $i += 9, $n++) {
			if (($i - 1) % 8 == 0 && $i != $l) {
				break;
			}else{
				$GLOBALS['eightLine'][3][$n] = $GLOBALS['othello'][$i]['disc'];
			}
		}
		// 下方向のチェック
		for ($i = $l, $n = 0; $i <= 64; $i += 8, $n++) {
			$GLOBALS['eightLine'][4][$n] = $GLOBALS['othello'][$i]['disc'];
		}
		// 左下方向のチェック
		for ($i = $l, $n = 0; $i <= 64; $i += 7, $n++) {
			if ($i % 8 == 0 && $i != $l) {
				break;
			}else{
				$GLOBALS['eightLine'][5][$n] = $GLOBALS['othello'][$i]['disc'];
			}
		}
		// 左方向のチェック
		for ($i = $l, $n = 0; $n <= (($l - 1) % 8); $i--, $n++) {
			$GLOBALS['eightLine'][6][$n] = $GLOBALS['othello'][$i]['disc'];
		}
		// 左上方向のチェック
		for ($i = $l, $n = 0; $i >= 1; $i -= 9, $n++) {
			if ($i % 8 == 0 && $i != $l) {
				break;
			}else{
				$GLOBALS['eightLine'][7][$n] = $GLOBALS['othello'][$i]['disc'];	
			}
		}
	};

	function placeOthello($l, $t){
		$changed = false;
		getEightLine($l);
		if($t==1 || $t==2){
			for ($i=0; $i < 8; $i++) {
				if(count($GLOBALS['eightLine'][$i]) > 2 && $GLOBALS['eightLine'][$i][0] == 0 && $t != $GLOBALS['eightLine'][$i][1] && $GLOBALS['eightLine'][$i][1] != 0 && $GLOBALS['eightLine'][$i][2] != 0){
					if ($t == $GLOBALS['eightLine'][$i][2]) {
						changeOthello($l, $t, $i, 2);
						$changed = true;
					}elseif (count($GLOBALS['eightLine'][$i]) > 3 && $GLOBALS['eightLine'][$i][3] != 0) {
						if ($t == $GLOBALS['eightLine'][$i][3]) {
							changeOthello($l, $t, $i, 3);
							$changed = true;
						}elseif (count($GLOBALS['eightLine'][$i]) > 4 && $GLOBALS['eightLine'][$i][4] != 0) {
							if ($t == $GLOBALS['eightLine'][$i][4]) {
								changeOthello($l, $t, $i, 4);
								$changed = true;
							}elseif (count($GLOBALS['eightLine'][$i]) > 5 && $GLOBALS['eightLine'][$i][5] != 0) {
									if ($t == $GLOBALS['eightLine'][$i][5]) {
										changeOthello($l, $t, $i, 5);
										$changed = true;
								}elseif (count($GLOBALS['eightLine'][$i]) > 6 && $GLOBALS['eightLine'][$i][6] != 0) {
									if ($t == $GLOBALS['eightLine'][$i][6]) {
										changeOthello($l, $t, $i, 6);
										$changed = true;
									}elseif (count($GLOBALS['eightLine'][$i]) > 7 && $GLOBALS['eightLine'][$i][7] != 0) {
										if($t == $GLOBALS['eightLine'][$i][7]){
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
			getEightLine($j);
			for ($i=0; $i < 8; $i++) {
				if(count($GLOBALS['eightLine'][$i]) > 2 && $GLOBALS['eightLine'][$i][0] == 0 && $t != $GLOBALS['eightLine'][$i][1] && $GLOBALS['eightLine'][$i][1] != 0 && $GLOBALS['eightLine'][$i][2] != 0){
					if ($t == $GLOBALS['eightLine'][$i][2]) {
						$next = true;
					}elseif (count($GLOBALS['eightLine'][$i]) > 3 && $GLOBALS['eightLine'][$i][3] != 0) {
						if ($t == $GLOBALS['eightLine'][$i][3]) {
							$next = true;
						}elseif (count($GLOBALS['eightLine'][$i]) > 4 && $GLOBALS['eightLine'][$i][4] != 0) {
							if ($t == $GLOBALS['eightLine'][$i][4]) {
								$next = true;
							}elseif (count($GLOBALS['eightLine'][$i]) > 5 && $GLOBALS['eightLine'][$i][5] != 0) {
								if ($t == $GLOBALS['eightLine'][$i][5]) {
									$next = true;
								}elseif (count($GLOBALS['eightLine'][$i]) > 6 && $GLOBALS['eightLine'][$i][6] != 0) {
									if ($t == $GLOBALS['eightLine'][$i][6]) {
										$next = true;
									}elseif (count($GLOBALS['eightLine'][$i]) > 7 && $GLOBALS['eightLine'][$i][7] != 0) {
										if($t == $GLOBALS['eightLine'][$i][7]){
											$next = true;
										}
									}
								}
							}
						}
					}
				}
			}
			unset($GLOBALS['eightLine']);
		}
		return $next;
	};

	$st = $pdo->query("SELECT * FROM othello");
	while ($row = $st->fetch()) {
		$othello[$row['id']] = array(
			'id' => $row['id'],
			'disc' => $row['disc'],
			'turn' => $row['turn'],
		);
	};
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($othello);