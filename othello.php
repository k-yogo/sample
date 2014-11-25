<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>ohello.php</title>
</head>
<body>
<?php
	class Othello{
		private $board = array();
		private $m;
		private $nextPlayer;
		private $countScore = 0;
		private $score_1 = 0;
		private $score_2 = 0;
		private $canContinue;
		function __construct(){
			print "<form name='othello' method='post' action=''>";
			for($i =0; $i < 8; $i++){
				for($j =0; $j < 8; $j++){
					if($i == 3 && $j == 3 || $i == 4 && $j == 4){
						$this->board[$j][$i] = 1;
						print "<input type='hidden' name='ot_".$j.$i."' value=''>";
					}else if($i == 4 && $j == 3 || $i == 3 && $j == 4){
						$this->board[$j][$i] = 2;
						print "<input type='hidden' name='ot_".$j.$i."' value=''>";
					}else{
						$this->board[$j][$i] = 0;
						print "<input type='hidden' name='ot_".$j.$i."' value=''>";
					}
				}
			}
			print "<input type='hidden' name='x' value=''>";
			print "<input type='hidden' name='y' value=''>";
			print "<input type='hidden' name='m' value=''>";
			print "</form>";
			print "<form action='' method='post' name='clear'></form>";
			if(!empty($_POST['m']) && $_POST['m'] == 1){
				$this->m = 1;
			}elseif(!empty($_POST['m']) && $_POST['m'] == 2){
				$this->m = 2;
			}
			if(!empty($_POST['ot_00'])){
				$this->board[0][0] = $_POST['ot_00'];
				print "<script>(function(){document.getElementsByName('ot_00').item(0).value='".$_POST['ot_00']."';})();</script>";
			}
			if(!empty($_POST['ot_10'])){
				$this->board[1][0] = $_POST['ot_10'];
				print "<script>(function(){document.getElementsByName('ot_10').item(0).value='".$_POST['ot_10']."';})();</script>";
			}
			if(!empty($_POST['ot_20'])){
				$this->board[2][0] = $_POST['ot_20'];
				print "<script>(function(){document.getElementsByName('ot_20').item(0).value='".$_POST['ot_20']."';})();</script>";
			}
			if(!empty($_POST['ot_30'])){
				$this->board[3][0] = $_POST['ot_30'];
				print "<script>(function(){document.getElementsByName('ot_30').item(0).value='".$_POST['ot_30']."';})();</script>";
			}
			if(!empty($_POST['ot_40'])){
				$this->board[4][0] = $_POST['ot_40'];
				print "<script>(function(){document.getElementsByName('ot_40').item(0).value='".$_POST['ot_40']."';})();</script>";
			}
			if(!empty($_POST['ot_50'])){
				$this->board[5][0] = $_POST['ot_50'];
				print "<script>(function(){document.getElementsByName('ot_50').item(0).value='".$_POST['ot_50']."';})();</script>";
			}
			if(!empty($_POST['ot_60'])){
				$this->board[6][0] = $_POST['ot_60'];
				print "<script>(function(){document.getElementsByName('ot_60').item(0).value='".$_POST['ot_60']."';})();</script>";
			}
			if(!empty($_POST['ot_70'])){
				$this->board[7][0] = $_POST['ot_70'];
				print "<script>(function(){document.getElementsByName('ot_70').item(0).value='".$_POST['ot_70']."';})();</script>";
			}
			if(!empty($_POST['ot_01'])){
				$this->board[0][1] = $_POST['ot_01'];
				print "<script>(function(){document.getElementsByName('ot_01').item(0).value='".$_POST['ot_01']."';})();</script>";
			}
			if(!empty($_POST['ot_11'])){
				$this->board[1][1] = $_POST['ot_11'];
				print "<script>(function(){document.getElementsByName('ot_11').item(0).value='".$_POST['ot_11']."';})();</script>";
			}
			if(!empty($_POST['ot_21'])){
				$this->board[2][1] = $_POST['ot_21'];
				print "<script>(function(){document.getElementsByName('ot_21').item(0).value='".$_POST['ot_21']."';})();</script>";
			}
			if(!empty($_POST['ot_31'])){
				$this->board[3][1] = $_POST['ot_31'];
				print "<script>(function(){document.getElementsByName('ot_31').item(0).value='".$_POST['ot_31']."';})();</script>";
			}
			if(!empty($_POST['ot_41'])){
				$this->board[4][1] = $_POST['ot_41'];
				print "<script>(function(){document.getElementsByName('ot_41').item(0).value='".$_POST['ot_41']."';})();</script>";
			}
			if(!empty($_POST['ot_51'])){
				$this->board[5][1] = $_POST['ot_51'];
				print "<script>(function(){document.getElementsByName('ot_51').item(0).value='".$_POST['ot_51']."';})();</script>";
			}
			if(!empty($_POST['ot_61'])){
				$this->board[6][1] = $_POST['ot_61'];
				print "<script>(function(){document.getElementsByName('ot_61').item(0).value='".$_POST['ot_61']."';})();</script>";
			}
			if(!empty($_POST['ot_71'])){
				$this->board[7][1] = $_POST['ot_71'];
				print "<script>(function(){document.getElementsByName('ot_71').item(0).value='".$_POST['ot_71']."';})();</script>";
			}
			if(!empty($_POST['ot_02'])){
				$this->board[0][2] = $_POST['ot_02'];
				print "<script>(function(){document.getElementsByName('ot_02').item(0).value='".$_POST['ot_02']."';})();</script>";
			}
			if(!empty($_POST['ot_12'])){
				$this->board[1][2] = $_POST['ot_12'];
				print "<script>(function(){document.getElementsByName('ot_12').item(0).value='".$_POST['ot_12']."';})();</script>";
			}
			if(!empty($_POST['ot_22'])){
				$this->board[2][2] = $_POST['ot_22'];
				print "<script>(function(){document.getElementsByName('ot_22').item(0).value='".$_POST['ot_22']."';})();</script>";
			}
			if(!empty($_POST['ot_32'])){
				$this->board[3][2] = $_POST['ot_32'];
				print "<script>(function(){document.getElementsByName('ot_32').item(0).value='".$_POST['ot_32']."';})();</script>";
			}
			if(!empty($_POST['ot_42'])){
				$this->board[4][2] = $_POST['ot_42'];
				print "<script>(function(){document.getElementsByName('ot_42').item(0).value='".$_POST['ot_42']."';})();</script>";
			}
			if(!empty($_POST['ot_52'])){
				$this->board[5][2] = $_POST['ot_52'];
				print "<script>(function(){document.getElementsByName('ot_52').item(0).value='".$_POST['ot_52']."';})();</script>";
			}
			if(!empty($_POST['ot_62'])){
				$this->board[6][2] = $_POST['ot_62'];
				print "<script>(function(){document.getElementsByName('ot_62').item(0).value='".$_POST['ot_62']."';})();</script>";
			}
			if(!empty($_POST['ot_72'])){
				$this->board[7][2] = $_POST['ot_72'];
				print "<script>(function(){document.getElementsByName('ot_72').item(0).value='".$_POST['ot_72']."';})();</script>";
			}
			if(!empty($_POST['ot_03'])){
				$this->board[0][3] = $_POST['ot_03'];
				print "<script>(function(){document.getElementsByName('ot_03').item(0).value='".$_POST['ot_03']."';})();</script>";
			}
			if(!empty($_POST['ot_13'])){
				$this->board[1][3] = $_POST['ot_13'];
				print "<script>(function(){document.getElementsByName('ot_13').item(0).value='".$_POST['ot_13']."';})();</script>";
			}
			if(!empty($_POST['ot_23'])){
				$this->board[2][3] = $_POST['ot_23'];
				print "<script>(function(){document.getElementsByName('ot_23').item(0).value='".$_POST['ot_23']."';})();</script>";
			}
			if(!empty($_POST['ot_33'])){
				$this->board[3][3] = $_POST['ot_33'];
				print "<script>(function(){document.getElementsByName('ot_33').item(0).value='".$_POST['ot_33']."';})();</script>";
			}
			if(!empty($_POST['ot_43'])){
				$this->board[4][3] = $_POST['ot_43'];
				print "<script>(function(){document.getElementsByName('ot_43').item(0).value='".$_POST['ot_43']."';})();</script>";
			}
			if(!empty($_POST['ot_53'])){
				$this->board[5][3] = $_POST['ot_53'];
				print "<script>(function(){document.getElementsByName('ot_53').item(0).value='".$_POST['ot_53']."';})();</script>";
			}
			if(!empty($_POST['ot_63'])){
				$this->board[6][3] = $_POST['ot_63'];
				print "<script>(function(){document.getElementsByName('ot_63').item(0).value='".$_POST['ot_63']."';})();</script>";
			}
			if(!empty($_POST['ot_73'])){
				$this->board[7][3] = $_POST['ot_73'];
				print "<script>(function(){document.getElementsByName('ot_73').item(0).value='".$_POST['ot_73']."';})();</script>";
			}
			if(!empty($_POST['ot_04'])){
				$this->board[0][4] = $_POST['ot_04'];
				print "<script>(function(){document.getElementsByName('ot_04').item(0).value='".$_POST['ot_04']."';})();</script>";
			}
			if(!empty($_POST['ot_14'])){
				$this->board[1][4] = $_POST['ot_14'];
				print "<script>(function(){document.getElementsByName('ot_14').item(0).value='".$_POST['ot_14']."';})();</script>";
			}
			if(!empty($_POST['ot_24'])){
				$this->board[2][4] = $_POST['ot_24'];
				print "<script>(function(){document.getElementsByName('ot_24').item(0).value='".$_POST['ot_24']."';})();</script>";
			}
			if(!empty($_POST['ot_34'])){
				$this->board[3][4] = $_POST['ot_34'];
				print "<script>(function(){document.getElementsByName('ot_34').item(0).value='".$_POST['ot_34']."';})();</script>";
			}
			if(!empty($_POST['ot_44'])){
				$this->board[4][4] = $_POST['ot_44'];
				print "<script>(function(){document.getElementsByName('ot_44').item(0).value='".$_POST['ot_44']."';})();</script>";
			}
			if(!empty($_POST['ot_54'])){
				$this->board[5][4] = $_POST['ot_54'];
				print "<script>(function(){document.getElementsByName('ot_54').item(0).value='".$_POST['ot_54']."';})();</script>";
			}
			if(!empty($_POST['ot_64'])){
				$this->board[6][4] = $_POST['ot_64'];
				print "<script>(function(){document.getElementsByName('ot_64').item(0).value='".$_POST['ot_64']."';})();</script>";
			}
			if(!empty($_POST['ot_74'])){
				$this->board[7][4] = $_POST['ot_74'];
				print "<script>(function(){document.getElementsByName('ot_74').item(0).value='".$_POST['ot_74']."';})();</script>";
			}
			if(!empty($_POST['ot_05'])){
				$this->board[0][5] = $_POST['ot_05'];
				print "<script>(function(){document.getElementsByName('ot_05').item(0).value='".$_POST['ot_05']."';})();</script>";
			}
			if(!empty($_POST['ot_15'])){
				$this->board[1][5] = $_POST['ot_15'];
				print "<script>(function(){document.getElementsByName('ot_15').item(0).value='".$_POST['ot_15']."';})();</script>";
			}
			if(!empty($_POST['ot_25'])){
				$this->board[2][5] = $_POST['ot_25'];
				print "<script>(function(){document.getElementsByName('ot_25').item(0).value='".$_POST['ot_25']."';})();</script>";
			}
			if(!empty($_POST['ot_35'])){
				$this->board[3][5] = $_POST['ot_35'];
				print "<script>(function(){document.getElementsByName('ot_35').item(0).value='".$_POST['ot_35']."';})();</script>";
			}
			if(!empty($_POST['ot_45'])){
				$this->board[4][5] = $_POST['ot_45'];
				print "<script>(function(){document.getElementsByName('ot_45').item(0).value='".$_POST['ot_45']."';})();</script>";
			}
			if(!empty($_POST['ot_55'])){
				$this->board[5][5] = $_POST['ot_55'];
				print "<script>(function(){document.getElementsByName('ot_55').item(0).value='".$_POST['ot_55']."';})();</script>";
			}
			if(!empty($_POST['ot_65'])){
				$this->board[6][5] = $_POST['ot_65'];
				print "<script>(function(){document.getElementsByName('ot_65').item(0).value='".$_POST['ot_65']."';})();</script>";
			}
			if(!empty($_POST['ot_75'])){
				$this->board[7][5] = $_POST['ot_75'];
				print "<script>(function(){document.getElementsByName('ot_75').item(0).value='".$_POST['ot_75']."';})();</script>";
			}
			if(!empty($_POST['ot_06'])){
				$this->board[0][6] = $_POST['ot_06'];
				print "<script>(function(){document.getElementsByName('ot_06').item(0).value='".$_POST['ot_06']."';})();</script>";
			}
			if(!empty($_POST['ot_16'])){
				$this->board[1][6] = $_POST['ot_16'];
				print "<script>(function(){document.getElementsByName('ot_16').item(0).value='".$_POST['ot_16']."';})();</script>";
			}
			if(!empty($_POST['ot_26'])){
				$this->board[2][6] = $_POST['ot_26'];
				print "<script>(function(){document.getElementsByName('ot_26').item(0).value='".$_POST['ot_26']."';})();</script>";
			}
			if(!empty($_POST['ot_36'])){
				$this->board[3][6] = $_POST['ot_36'];
				print "<script>(function(){document.getElementsByName('ot_36').item(0).value='".$_POST['ot_36']."';})();</script>";
			}
			if(!empty($_POST['ot_46'])){
				$this->board[4][6] = $_POST['ot_46'];
				print "<script>(function(){document.getElementsByName('ot_46').item(0).value='".$_POST['ot_46']."';})();</script>";
			}
			if(!empty($_POST['ot_56'])){
				$this->board[5][6] = $_POST['ot_56'];
				print "<script>(function(){document.getElementsByName('ot_56').item(0).value='".$_POST['ot_56']."';})();</script>";
			}
			if(!empty($_POST['ot_66'])){
				$this->board[6][6] = $_POST['ot_66'];
				print "<script>(function(){document.getElementsByName('ot_66').item(0).value='".$_POST['ot_66']."';})();</script>";
			}
			if(!empty($_POST['ot_76'])){
				$this->board[7][6] = $_POST['ot_76'];
				print "<script>(function(){document.getElementsByName('ot_76').item(0).value='".$_POST['ot_76']."';})();</script>";
			}
			if(!empty($_POST['ot_07'])){
				$this->board[0][7] = $_POST['ot_07'];
				print "<script>(function(){document.getElementsByName('ot_07').item(0).value='".$_POST['ot_07']."';})();</script>";
			}
			if(!empty($_POST['ot_17'])){
				$this->board[1][7] = $_POST['ot_17'];
				print "<script>(function(){document.getElementsByName('ot_17').item(0).value='".$_POST['ot_17']."';})();</script>";
			}
			if(!empty($_POST['ot_27'])){
				$this->board[2][7] = $_POST['ot_27'];
				print "<script>(function(){document.getElementsByName('ot_27').item(0).value='".$_POST['ot_27']."';})();</script>";
			}
			if(!empty($_POST['ot_37'])){
				$this->board[3][7] = $_POST['ot_37'];
				print "<script>(function(){document.getElementsByName('ot_37').item(0).value='".$_POST['ot_37']."';})();</script>";
			}
			if(!empty($_POST['ot_47'])){
				$this->board[4][7] = $_POST['ot_47'];
				print "<script>(function(){document.getElementsByName('ot_47').item(0).value='".$_POST['ot_47']."';})();</script>";
			}
			if(!empty($_POST['ot_57'])){
				$this->board[5][7] = $_POST['ot_57'];
				print "<script>(function(){document.getElementsByName('ot_57').item(0).value='".$_POST['ot_57']."';})();</script>";
			}
			if(!empty($_POST['ot_67'])){
				$this->board[6][7] = $_POST['ot_67'];
				print "<script>(function(){document.getElementsByName('ot_67').item(0).value='".$_POST['ot_67']."';})();</script>";
			}
			if(!empty($_POST['ot_77'])){
				$this->board[7][7] = $_POST['ot_77'];
				print "<script>(function(){document.getElementsByName('ot_77').item(0).value='".$_POST['ot_77']."';})();</script>";
			}
			if(!empty($_POST['m'])){
				$this->moveOthello($_POST['x'],$_POST['y'],$_POST['m']);
			}else{
				$this->m = 2;
			}
			if ($this->m == 2 && $this->checkNext(2) == 1) {
				$this->checkNext(1) != 2;
				$this->m = 1;
			}elseif ($this->m == 1 && $this->checkNext(1) == 2) {
				$this->checkNext(2) != 1;
				$this->m = 2;
			}elseif (($this->m == 1 && $this->checkNext(1) == 2 && $this->checkNext(2) == 1) || ($this->m == 2 && $this->checkNext(2) == 1 && $this->checkNext(1) == 2)){
				$this->showOthello();
				$this->endProcess();
				return;
			}
			$this->showOthello();
			print $this->nextPlayer;
			print "<br><a href='' onclick='document.clear.submit(); return false;'>Reset</a>";
			if($this->countScore == 0){
				$this->endProcess();
			}
		}
		function showOthello(){
			for($i =0; $i < 8; $i++){
				for($j =0; $j < 8; $j++){
					if($this->board[$j][$i] == 0){
						print "<a href='' onclick=\"setOthello(".$j.",".$i.",".$this->m."); return false;\">";
					}
					print $this->board[$j][$i];
					if ($this->board[$j][$i] == 1) {
						$this->score_1++;
					}elseif ($this->board[$j][$i] == 2) {
						$this->score_2++;
					}
					if($this->board[$j][$i] == 0){
						print "</a>";
					}
				}
				print "<br>";
			}
		}
		private function getEightLine($x, $y){
			for ($i = $y, $n = 0; $i >= 0; $i--, $n++) { 
				$this->eightLine[0][$n] = $this->board[$x][$i];
			}
			for ($i = $x, $j = $y, $n = 0; $i <= 7 && $j >= 0; $i++, $j--, $n++) {
				$this->eightLine[1][$n] = $this->board[$i][$j];
			}
			for ($i = $x, $n = 0; $i <= 7; $i++, $n++) { 
				$this->eightLine[2][$n] = $this->board[$i][$y];
			}
			for ($i = $x, $j = $y, $n = 0; $i <= 7 && $j <= 7; $i++, $j++, $n++) {
				$this->eightLine[3][$n] = $this->board[$i][$j];
			}
			for ($i = $y, $n = 0; $i <= 7; $i++, $n++) { 
				$this->eightLine[4][$n] = $this->board[$x][$i];
			}
			for ($i = $x, $j = $y, $n = 0; $i >= 0 && $j <= 7; $i--, $j++, $n++) {
				$this->eightLine[5][$n] = $this->board[$i][$j];
			}
			for ($i = $x, $n = 0; $i >= 0; $i--, $n++) { 
				$this->eightLine[6][$n] = $this->board[$i][$y];
			}
			for ($i = $x, $j = $y, $n = 0; $i >= 0 && $j >= 0; $i--, $j--, $n++) {
				$this->eightLine[7][$n] = $this->board[$i][$j];
			}
		}
		private function moveOthello($x, $y, $m){
			if($m==1 || $m==2){
				$this->getEightLine($x, $y);
				for ($i=0; $i < 8; $i++) {
					if(count($this->eightLine[$i]) > 2 && $this->eightLine[$i][0] == 0 && $m != $this->eightLine[$i][1] && $this->eightLine[$i][1] != 0){
						if ($m == $this->eightLine[$i][2] && $this->eightLine[$i][2] != 0) {
							$this->changeOthello(2, $i, $x, $y, $m);
						}elseif (count($this->eightLine[$i]) > 3 && $this->eightLine[$i][3] != 0) {
							if ($m == $this->eightLine[$i][3]) {
								$this->changeOthello(3, $i, $x, $y, $m);
							}elseif (count($this->eightLine[$i]) > 4 && $this->eightLine[$i][4] != 0) {
								if ($m == $this->eightLine[$i][4]) {
									$this->changeOthello(4, $i, $x, $y, $m);
								}elseif (count($this->eightLine[$i]) > 5 && $this->eightLine[$i][5] != 0) {
									if ($m == $this->eightLine[$i][5]) {
										$this->changeOthello(5, $i, $x, $y, $m);
									}elseif (count($this->eightLine[$i]) > 6 && $this->eightLine[$i][6] != 0) {
										if ($m == $this->eightLine[$i][6]) {
											$this->changeOthello(6, $i, $x, $y, $m);
										}elseif (count($this->eightLine[$i]) > 7 && $this->eightLine[$i][7] != 0) {
											if($m == $this->eightLine[$i][7]){
												$this->changeOthello(7, $i, $x, $y, $m);
											}else{
											}
										}else{
										}
									}else{
									}
								}else{
								}
							}else{
							}
						}else{
						}
					}else{
					}
				}
			}else{
			}
			unset($this->eightLine);
		}
		private function changeOthello($n, $i, $x, $y, $m){
			if ($i == 0) {
				for ($j=0; $j <= $n; $j++) { 
					$this->board[$x][($y-$j)] = $m;
					print "<script>(function(){document.getElementsByName('ot_".$x.($y-$j)."').item(0).value='".$m."';})();</script>";
				}
				if($_POST['m'] == 2){
					$this->m =1;
				}elseif ($_POST['m'] == 1) {
					$this->m =2;
				}
			}elseif ($i == 1) {
				for ($j=0; $j <= $n; $j++) { 
					$this->board[($x+$j)][($y-$j)] = $m;
					print "<script>(function(){document.getElementsByName('ot_".($x+$j).($y-$j)."').item(0).value='".$m."';})();</script>";
				}
				if($_POST['m'] == 2){
					$this->m =1;
				}elseif ($_POST['m'] == 1) {
					$this->m =2;
				}
			}elseif ($i == 2) {
				for ($j=0; $j <= $n; $j++) { 
					$this->board[($x+$j)][$y] = $m;
					print "<script>(function(){document.getElementsByName('ot_".($x+$j).$y."').item(0).value='".$m."';})();</script>";
				}
				if($_POST['m'] == 2){
					$this->m =1;
				}elseif ($_POST['m'] == 1) {
					$this->m =2;
				}
			}elseif ($i == 3) {
				for ($j=0; $j <= $n; $j++) { 
					$this->board[($x+$j)][($y+$j)] = $m;
					print "<script>(function(){document.getElementsByName('ot_".($x+$j).($y+$j)."').item(0).value='".$m."';})();</script>";
				}
				if($_POST['m'] == 2){
					$this->m =1;
				}elseif ($_POST['m'] == 1) {
					$this->m =2;
				}
			}elseif ($i == 4) {
				for ($j=0; $j <= $n; $j++) { 
					$this->board[$x][($y+$j)] = $m;
					print "<script>(function(){document.getElementsByName('ot_".$x.($y+$j)."').item(0).value='".$m."';})();</script>";
				}
				if($_POST['m'] == 2){
					$this->m =1;
				}elseif ($_POST['m'] == 1) {
					$this->m =2;
				}
			}elseif ($i == 5) {
				for ($j=0; $j <= $n; $j++) { 
					$this->board[($x-$j)][($y+$j)] = $m;
					print "<script>(function(){document.getElementsByName('ot_".($x-$j).($y+$j)."').item(0).value='".$m."';})();</script>";
				}
				if($_POST['m'] == 2){
					$this->m =1;
				}elseif ($_POST['m'] == 1) {
					$this->m =2;
				}
			}elseif ($i == 6) {
				for ($j=0; $j <= $n; $j++) { 
					print "<script>(function(){document.getElementsByName('ot_".($x-$j).$y."').item(0).value='".$m."';})();</script>";
					$this->board[($x-$j)][$y] = $m;
				}
				if($_POST['m'] == 2){
					$this->m =1;
				}elseif ($_POST['m'] == 1) {
					$this->m =2;
				}
			}elseif ($i == 7) {
				for ($j=0; $j <= $n; $j++) { 
					$this->board[($x-$j)][($y-$j)] = $m;
					print "<script>(function(){document.getElementsByName('ot_".($x-$j).($y-$j)."').item(0).value='".$m."';})();</script>";
				}
				if($_POST['m'] == 2){
					$this->m =1;
				}elseif ($_POST['m'] == 1) {
					$this->m =2;
				}
			}
		}
		private function checkNext($nextOthello){
			$next = 0;
			for($i =0; $i < 8; $i++){
				for($j =0; $j < 8; $j++){
					if ($this->board[$j][$i] == 0) {
						$this->countScore++;
						$this->getEightLine($j, $i);
						for ($l=0; $l < 8; $l++) { 
							if(count($this->eightLine[$l]) > 2 && $this->eightLine[$l][0] == 0 && $nextOthello != $this->eightLine[$l][1] && $this->eightLine[$l][1] != 0){
								if ($nextOthello == $this->eightLine[$l][2] && $this->eightLine[$l][2] != 0) {
									$next++;
								}elseif (count($this->eightLine[$l]) > 3 && $this->eightLine[$l][3] != 0) {
									if ($nextOthello == $this->eightLine[$l][3]) {
										$next++;
									}elseif (count($this->eightLine[$l]) > 4 && $this->eightLine[$l][4] != 0) {
										if ($nextOthello == $this->eightLine[$l][4]) {
											$next++;
										}elseif (count($this->eightLine[$l]) > 5 && $this->eightLine[$l][5] != 0) {
											if ($nextOthello == $this->eightLine[$l][5]) {
												$next++;
											}elseif (count($this->eightLine[$l]) > 6 && $this->eightLine[$l][6] != 0) {
												if ($nextOthello == $this->eightLine[$l][6]) {
													$next++;
												}elseif (count($this->eightLine[$l]) > 7 && $this->eightLine[$l][7] != 0) {
													if($nextOthello == $this->eightLine[$l][7]){
														$next++;
													}else{
													}
												}else{
												}
											}else{
											}
										}else{
										}
									}else{
									}
								}else{
								}
							}else{
							}
						}
					}
				}
			}
			if($next == 0 && $nextOthello == 1){
				return 2;
			}elseif ($next == 0 && $nextOthello == 2) {
				return 1;
			}else{
				$this->nextPlayer = $this->m."の番です。";
			}
			unset($this->eightLine);
		}
		private function endProcess(){
			print "終わりです。<br>";
			print "1: ".$this->score_1."個<br>";
			print "2: ".$this->score_2."個<br>";
			if($this->score_1 > $this->score_2){
				print "1の勝ちです。";
			}else if($this->score_2 > $this->score_1){
				print "2の勝ちです。";
			}else{
				print "引き分けです。";
			}
			print "<br><a href='' onclick='document.clear.submit(); return false;'>はじめからやる。</a>";
		}
	}
	$x = new Othello();
?>
	<script>
		function setOthello(x, y, m){
			document.getElementsByName('x').item(0).value = x;
			document.getElementsByName('y').item(0).value = y;
			document.getElementsByName('m').item(0).value = m;
			document.othello.submit();
		}
	</script>
</body>
</html>