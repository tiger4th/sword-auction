<script type="text/javascript" src="./js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="./js/smoothscroll.js" charset="utf-8"></script>
<script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
<script type="text/javascript">
number = 0;
page = 0;
aid_string = '<?php echo join(",", $aid); ?>';
aid_array = aid_string.split(",");

function getImage(){
	for (i = 0; i < 50; i++) {
		var aid = aid_array[i];

		$.ajax({
			type: "GET",
			url:"http://auctions.yahooapis.jp/AuctionWebService/V2/json/auctionItem?appid=<?php echo $app_id; ?>&auctionID="+aid,
			dataType: "jsonp",
			success: function(data, dataType) {
				write(data);
			},
			error: function() {}
		})
	}
}

function jump(obj){
	targetObj=obj;
	if(targetObj)location.href=targetObj.value;
}

function write(data) {
	// 時間計算
	color = "black";
	myD   = new Date();
	myYear=(myD.getYear()<2000)?1900+myD.getYear() : myD.getYear();
	myNextYear = Date.parse(data.ResultSet.Result.EndTime);
	myMsec = myNextYear-myD.getTime();
	if (myMsec < 1000) {
		myDisp = "終了";
		//return true;
	} else if (myMsec < 60000) {
		color="red"
		myDisp = "まもなく終了";
	} else {
		if(myMsec < 3600000)color="red";
		myNextDay  = Math.floor(myMsec/(1000*60*60*24));
		myMsec     -= (myNextDay*(1000*60*60*24));
		myNextHour = Math.floor(myMsec/(1000*60*60));
		myMsec     -= (myNextHour*(1000*60*60));
		myNextMin  = Math.floor(myMsec/(1000*60));
		myMsec     -= (myNextMin*(1000*60));
		myNextSec  = Math.floor(myMsec/1000);
		myDisp = "残り時間 ";
		if (myNextDay  != 0)myDisp+=myNextDay+"日";
		if (myNextDay  != 0 && (myNextHour != 0 || myNextMin != 0))myDisp += "と ";
		if (myNextHour != 0)myDisp+=myNextHour+"時間 ";
		if (myNextMin  != 0)myDisp+=myNextMin+"分 ";
		//if (myNextHour == 0)myDisp+=myNextSec+"秒";
	}
	if(data.ResultSet.Result.Img.Image1==undefined)data.ResultSet.Result.Img.Image1='./img/noimage.png';

	document.getElementById("img_"+data.ResultSet.Result.AuctionID).src = data.ResultSet.Result.Img.Image1;
	document.getElementById("time_"+data.ResultSet.Result.AuctionID).innerHTML = myDisp;
	document.getElementById("time_"+data.ResultSet.Result.AuctionID).className = color;
}
</script>
<script type="text/javascript">
  window.___gcfg = {lang: 'ja'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20423739-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>