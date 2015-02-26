<?php
	$tag = $_GET[tag];
	$tagup = strtoupper($tag);
	$css = $_GET[css];
	$amount = $_GET[amount];
	$debug = $_GET[debug];
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    	<?php
			print "<link rel='stylesheet' type='text/css' href='./css/{$css}.css'>";
		?>
	</head>
	<body class="body">
		<div class="headline">
    		<img class="logo" src="https://lh3.ggpht.com/vFpQP39LB60dli3n-rJnVvTM07dsvIzxrCL5xMiy1V4GV4unC1ifXkUExQ4N-DBCKwI=w300">
			<?php
            	print "<h1>#{$tagup}</h1>";
			?>
		</div>
		<div id="instafeed">
		</div>
        <script>
			imgstart = 0;
			<?php
				print "img = {$amount} - 1;";
				print "imgload = {$amount};";
				print "debug = {$debug};";
			?>
			function checkimages() {		
				var json = new XMLHttpRequest();
				var d = new Date();
				t = d.getTime();
				<?php
					print "var tag = ".'"'."{$tag}".'"'.";"
				?>
				var url = "./feed.php?tag=" + [tag] + "&" + [t];
				json.onreadystatechange=function() {
					if (json.readyState == 4 && json.status == 200) {
						var parser = JSON.parse(json.responseText);
						if (img > imgload -1) {
							img = 0;
							if (debug == 1) {
								console.log("img reset from plus");
							}
						}
						for (; imgstart < imgload; img--, imgstart++) {
							if (debug == 1) {
								console.log("///////////////////////////////////////////////////////////");
								console.log("starting imgstartload");
								console.log("///////////////////////////////////////////////////////////");
							}
							imgstartload(parser, img);
							if (debug == 1) {
								console.log("stopping imgstartload");
								console.log("///////////////////////////////////////////////////////////");
								console.log("imgstartload img=" + img);
								console.log("imgstartload imgload=" + imgload);
								console.log("imgstartload imgstart=" + imgstart);
							}
						}
						if (img < 0) {
							img = 0;
							if (debug == 1) {
								console.log("img reset from minus");
							}
						}
						for (; img < imgload && imgstart > imgload -1 && img > -1; img++) {
							if (debug == 1) {
								console.log("///////////////////////////////////////////////////////////");
								console.log("starting imgrefresh");
								console.log("///////////////////////////////////////////////////////////");
							}
							imgrefresh(parser, img);
							if (debug == 1) {
								console.log("stopping imgrefresh");
								console.log("///////////////////////////////////////////////////////////");
								console.log("imgrefresh img=" + img);
								console.log("imgrefresh imgload=" + imgload);
								console.log("imgrefresh imgstart=" + imgstart);
							}
						}
					}
				}
				json.open("GET", url, true);
				json.send();
			}
			function imgrefresh(parser, img) {
				var div = document.getElementById("images" + img);
				div.src = parser[img].images.standard_resolution.url;
			}
			function imgstartload(parser, img) {
				var imagesdiv = document.querySelector("#instafeed");
				var div = document.createElement("img");
				div.id = "images" + img;
				imagesdiv.insertBefore(div, imagesdiv.firstChild);
			}
			checkimages();
			setInterval(checkimages, 5000);
        </script>
	</body>
</html>
