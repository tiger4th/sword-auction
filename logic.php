<?php
$vcurl = 'http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=3146778&pid=883039550&vc_url=';

// カテゴリ取得
$c = $root;
if(isset($_GET['c'])){
	$c = $_GET['c'];
}

$api_url = 'http://auctions.yahooapis.jp/AuctionWebService/V2/categoryTree?appid='.$app_id.'&category='.$c;
$category = simplexml_load_file($api_url);
$category = json_decode(json_encode($category), true);

if($category['@attributes']['totalResultsReturned'][0] <= 0){
	echo 'ただいまご利用いただけません。しばらくお待ちください。<br /><a href="http://tiger4th.com/auc/">トップページに戻る</a>';
	exit;
}

// パンくず
$bread = explode('>', $category["Result"]["CategoryPath"]);
$bread_id = explode(',', $category["Result"]["CategoryIdPath"]);
array_shift($bread);
array_shift($bread_id);

// プラットフォーム
$p = 'gr';
if (isset($_GET['p'])) {
	$p = $_GET['p'];
}

$plat = 'GREE';
switch ($p) {
	case 'gr':
		$plat = 'GREE';
		break;
	case 'mo':
		$plat = 'モバゲー';
		break;
	case 'mi':
		$plat = 'mixi';
		break;
	case 'ot':
		$plat = '';
		break;
}

// クエリ
$q = '';
if (isset($_GET['q']) && $_GET['q'] != '') {
	$q = $_GET['q'];
}

// ソート順
$s = 'end';
if (isset($_GET['s']) && $_GET['s'] != '') {
	$s = $_GET['s'];
}

// 昇順降順
$o = 'a';
if (isset($_GET['o']) && $_GET['o'] != '') {
	$o = $_GET['o'];
}

// 画像有無
$t = 1;
if (isset($_GET['t']) && $_GET['t'] == 0) {
	$t = 0;
}

// ページ番号
$n = 1;
if (isset($_GET['n']) && $_GET['n'] != '') {
	$n = $_GET['n'];
}

if ($q != '') {
	$url = 'http://auctions.yahooapis.jp/AuctionWebService/V2/search?appid='.$app_id.'&query='.$q.'&sort='.$s.'&order='.$o.'&thumbnail='.$t.'&page='.$n.'&category='.$c;
} else {
	$url = 'http://auctions.yahooapis.jp/AuctionWebService/V2/categoryLeaf?appid='.$app_id.'&sort='.$s.'&order='.$o.'&thumbnail='.$t.'&page='.$n.'&category='.$c;
}

$res = simplexml_load_file($url);
$res = json_decode(json_encode($res), true);

if($res['@attributes']['totalResultsReturned'][0] <= 0){
	$link = '';
} else {
	// オークションIDリスト 50件
	foreach ($res["Result"]["Item"] as $val) {
		$aid[] = $val["AuctionID"];
		$title[$val["AuctionID"]] = $val["Title"];
		$item_url[$val["AuctionID"]] = $vcurl . $val["AuctionItemUrl"];
		$price[$val["AuctionID"]] = number_format($val["CurrentPrice"]);
		$bidorbuy[$val["AuctionID"]] = number_format($val["BidOrBuy"]);
		$bids[$val["AuctionID"]] = number_format($val["Bids"]);
	}
	
	$so = "01";
	if ($s == "cbids" && $o == "a")        $so = "01";
	elseif ($s == "cbids" && $o == "d")    $so = "02";
	elseif ($s == "bids" && $o == "a")     $so = "03";
	elseif ($s == "bids" && $o == "d")     $so = "04";
	elseif ($s == "end" && $o == "a")      $so = "05";
	elseif ($s == "end" && $o == "d")      $so = "06";
	elseif ($s == "bidorbuy" && $o == "a") $so = "07";
	elseif ($s == "bidorbuy" && $o == "d") $so = "08";
	
	// Y!URL
	if ($q != '') {
		$link = 'http://auctions.search.yahoo.co.jp/search?mode=1&n=50&b='.(($n-1)*50+1).'&p='.$q."&select=".$so."&thumb=".$t."&auccat=".$c;
	} else {
		$link = 'http://category.auctions.yahoo.co.jp/list/'.$c.'/?mode=1&select='.$so;
	}

	$link = $vcurl.rawurlencode($link);
}

?>