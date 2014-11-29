<?php
	// 絵札すべてを格納した配列変数を作成する。
	$mark = array('S', 'H', 'D', 'C');
	// 番号すべてを格納した配列変数を作成する。
	$number = array('A', '2', '3', '4', '5', '6', '7', '8', '9', 'X', 'J', 'Q', 'K');
	// すべてのカードの種類を格納する配列変数$cardを初期化する。
	$card = array();
	// シャッフルし、人数分に分けたカードを格納する配列変数$cardsを初期化する。
	$cards = array();
	// 絵札それぞれの、すべての番号のカードの種類を絵札と番号を"-"でつないで、$cardに格納する。
	foreach ($mark as $mark_value) {
		foreach ($number as $number_value) {
			array_push($card, $mark_value."-".$number_value);
		}
	};
	// すべてのカードの種類を格納した$cardの順番をシャッフルする。
	shuffle($card);
	// htmlから受け取ったmemberの値がerrorだった場合不正のメッセージのみを、$cards[0]に格納し返す。
	if (!empty($_POST['member']) && $_POST['member'] == "error") {
		$cards[0] = "入力値が無いか、値が不正です。";
	// htmlから受け取ったmemberの値が52未満だった場合、受け取った人数分に分けた配列を返す関数serveを、引数を受け取った人数に設定して、実行し、$cardsに結果を格納する。
	}elseif (!empty($_POST['member']) && $_POST['member'] < 52) {
		$member = $_POST['member'];
		serve($member);
	// htmlから受け取ったmemberの値が52以上だった場合、空の要素を$cards[0]に格納し、返す。
	}else{
		$cards[0] = "";
	}
	function serve($member){
		// $cardと$cardsがグローバル関数であることを宣言する。
		global $card, $cards;
		// 引数の人数$member分を一周として、シャッフルしたカードの種類をそれぞれの配る人毎に格納して、2次元配列にする。
		foreach ($card as $i => $v) $cards[$i % $member][] = $v;
		// 生成した2次元配列の各要素を","でつなぎ、$cardsに1次元配列として戻す。
		$cards = array_map(function ($l) { return implode(',', $l); }, $cards);
	}
	// 配列をjsonオブジェクトに変換して、表示する。
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($cards);