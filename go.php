<?php
/**
 * 自动跳转页面
 * @copyright (c) Moeblog
 */
//自定义跳转地址
if(strlen($_SERVER['REQUEST_URI']) > 384 ||
    strpos($_SERVER['REQUEST_URI'], "eval(") ||
    strpos($_SERVER['REQUEST_URI'], "base64")) {
        @header("HTTP/1.1 414 Request-URI Too Long");
        @header("Status: 414 Request-URI Too Long");
        @header("Connection: Close");
        @exit;
}
//通过QUERY_STRING取得完整的传入数据，然后取得url=之后的所有值，兼容性更好
$t_url = htmlspecialchars(preg_replace('/^url=(.*)$/i','$1',$_SERVER["QUERY_STRING"]));


//数据处理
if(!empty($t_url)) {
    //判断取值是否加密
    if ($t_url == base64_encode(base64_decode($t_url))) {
        $t_url =  base64_decode($t_url);
    }
    //对取值进行网址校验和判断
    preg_match('/^(http|https|thunder|qqdl|ed2k|Flashget|qbrowser):\/\//i',$t_url,$matches);
if($matches){
    $url=$t_url;
    $title='页面加载中,请稍候...';
} else {
    preg_match('/\./i',$t_url,$matche);
    if($matche){
        $url='http://'.$t_url;
        $title='页面加载中,请稍候...';
    } else {
        $url = 'http://'.$_SERVER['HTTP_HOST'];
        $title='参数错误，正在返回首页...';
    }
}
} else {
    $title = '参数缺失，正在返回首页...';
    $url = 'http://'.$_SERVER['HTTP_HOST'];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="refresh" content="1;url='<?php echo $url;?>';">
<title>页面加载中,请稍候...</title>
<style type="text/css">
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline
}

body {
	background: #000;
}

#loader-container {
	width: 188px;
	height: 188px;
	color: white;
	margin: 0 auto;
	position: absolute;
	top: 50%;
	left: 50%;
	margin-right: -50%;
	transform: translate(-50%, -50%);
	border: 5px solid #3498db;
	border-radius: 50%;
	-webkit-animation: borderScale 1s infinite ease-in-out;
	animation: borderScale 1s infinite ease-in-out;
}

#loadingText {
	font-family: 'Raleway', sans-serif;
	font-size: 1.4em;
	position: absolute;
	top: 50%;
	left: 50%;
	margin-right: -50%;
	transform: translate(-50%, -50%);
}

@-webkit-keyframes borderScale {
	0% {
		border: 5px solid white;
	}

	50% {
		border: 25px solid #3498db;
	}

	100% {
		border: 5px solid white;
	}
}

@keyframes borderScale {
	0% {
		border: 5px solid white;
	}

	50% {
		border: 25px solid #3498db;
	}

	100% {
		border: 5px solid white;
	}
}
</style>
</script>
</head>
<body>

	<canvas id="canvas" style="background:#111"></canvas>

	<script type="text/javascript">

		window.onload = function(){
			//获取画布对象
			var canvas = document.getElementById("canvas");
			//获取画布的上下文
			var context =canvas.getContext("2d");
			//获取浏览器屏幕的宽度和高度
			var W = window.innerWidth;
			var H = window.innerHeight;
			//设置canvas的宽度和高度
			canvas.width = W - 20;
			canvas.height = H - 20;
			//每个文字的字体大小
			var fontSize = 16;
			//计算列
			var colunms = Math.floor(W /fontSize);
			//记录每列文字的y轴坐标
			var drops = [];
			//给每一个文字初始化一个起始点的位置
			for(var i=0;i<colunms;i++){
				drops.push(0);
			}

			//运动的文字
			var str ="javascript html5 canvas";
			//4:fillText(str,x,y);原理就是去更改y的坐标位置
			//绘画的函数
			function draw(){
				context.fillStyle = "rgba(0,0,0,0.05)";
				context.fillRect(0,0,W,H);
				//给字体设置样式
				context.font = "700 "+fontSize+"px  微软雅黑";
				//给字体添加颜色
				context.fillStyle ="#00FF00";//可以rgb,hsl, 标准色，十六进制颜色
				//写入画布中
				for(var i=0;i<colunms;i++){
					var index = Math.floor(Math.random() * str.length);
					var x = i*fontSize;
					var y = drops[i] *fontSize;
					context.fillText(str[index],x,y);
					//如果要改变时间，肯定就是改变每次他的起点
					if(y >= canvas.height && Math.random() > 0.99){
						drops[i] = 0;
					}
					drops[i]++;
				}
			};

			function randColor(){
				var r = Math.floor(Math.random() * 256);
				var g = Math.floor(Math.random() * 256);
				var b = Math.floor(Math.random() * 256);
				return "rgb("+r+","+g+","+b+")";
			}

			draw();
			setInterval(draw,30);
		};

	</script>
<script type="text/javascript">
function alertSet(e) {
	
	document.getElementById("js-alert-box").style.display = "block", document.getElementById("js-alert-head").innerHTML = e;
	var t = 5,
		n = document.getElementById("js-sec-circle");
	document.getElementById("js-sec-text").innerHTML = t, setInterval(function() {
		//禁止其他网站调用此跳转
		//var MyHOST = new RegExp("<?php echo $_SERVER['HTTP_HOST']; ?>");
    	//if (!MyHOST.test(document.referrer)) {
        // 	location.href="http://" + MyHOST;
    	//}
		if (0 == t) location.href = "<?php echo $url;?>";
		else {
			t -= 1, document.getElementById("js-sec-text").innerHTML = t;
			var e = Math.round(t / 5 * 735);
			n.style.strokeDashoffset = e - 735
		}
	}, 970)
} </script>
<script>alertSet("<?php echo $title;?>");</script>
<script>window.scrollTo(0,document.body.scrollHeight);</script>
</body>
</html>
