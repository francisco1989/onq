<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Unity Web Player | CARDFPS</title>
		<script type='text/javascript' src='https://ssl-webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/jquery.min.js'></script>
		<script type="text/javascript">
		<!--
		var unityObjectUrl = "http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject2.js";
		if (document.location.protocol == 'https:')
			unityObjectUrl = unityObjectUrl.replace("http://", "https://ssl-");
		document.write('<script type="text\/javascript" src="' + unityObjectUrl + '"><\/script>');
		-->
		</script>
		<script type="text/javascript">
		<!--
		//new
			function getSearchParameters() {
				  var prmstr = window.location.search.substr(1);
				  return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
			}

			function transformToAssocArray( prmstr ) {
				var params = {};
				var prmarr = prmstr.split("&");
				for ( var i = 0; i < prmarr.length; i++) {
					var tmparr = prmarr[i].split("=");
					params[tmparr[0]] = tmparr[1];
				}
				return params;
			}
			
			var params = getSearchParameters();
			
			//document.write(params.test);
			params.test = decodeURIComponent(params.test);
			var config = {
				width: 1024, 
				height: 600,
				params: { enableDebugging:"0" }
				
			};
			var u = new UnityObject2(config);
			
			//new shit
			function OnUnityReady(arg)
			{
				u.getUnity().SendMessage("StartSphere", "Init", params.test);
			}
			
			function GameDone(arg)
			{
				var str = arg;
				var strArray = str.split("|");
				var deckID = strArray[0];
				var userName = strArray[1];
				var gameTime = strArray[2];
				
			}
			//hides url parameters
			if(typeof window.history.pushState == 'function') {
				window.history.pushState({}, "Hide", "../Games/Builds.php?");
			}
			
			jQuery(function() {

				var $missingScreen = jQuery("#unityPlayer").find(".missing");
				var $brokenScreen = jQuery("#unityPlayer").find(".broken");
				$missingScreen.hide();
				$brokenScreen.hide();

				u.observeProgress(function (progress) {
					switch(progress.pluginStatus) {
						case "broken":
							$brokenScreen.find("a").click(function (e) {
								e.stopPropagation();
								e.preventDefault();
								u.installPlugin();
								return false;
							});
							$brokenScreen.show();
						break;
						case "missing":
							$missingScreen.find("a").click(function (e) {
								e.stopPropagation();
								e.preventDefault();
								u.installPlugin();
								return false;
							});
							$missingScreen.show();
						break;
						case "installed":
							$missingScreen.remove();
						break;
						case "first":
						break;
					}
				});
				u.initPlugin(jQuery("#unityPlayer")[0], "Builds.unity3d");
			});
		-->
		</script>
		<style type="text/css">
		
		
		body {
			font-family: Helvetica, Verdana, Arial, sans-serif;
			background:linear-gradient(rgba(4,95,248,1), rgba(4,27,159,1));
			color: white;
			text-align: center;
		}
		a:link, a:visited {
			color: #bfbfbf;
		}
		a:active, a:hover {
			color: #bfbfbf;
		}
		p.header {
			font-size: small;
		}
		p.header span {
			font-weight: bold;
		}
		p.footer {
			font-size: x-small;
		}
		div.content {
			margin: auto;
			width: 1024px;
		}
		div.broken,
		div.missing {
			margin: auto;
			position: relative;
			top: 50%;
			width: 193px;
		}
		div.broken a,
		div.missing a {
			height: 63px;
			position: relative;
			top: -31px;
		}
		div.broken img,
		div.missing img {
			border-width: 0px;
		}
		div.broken {
			display: none;
		}
		div#unityPlayer {
			cursor: default;
			height: 600px;
			width: 1024px;
		}
	
		</style>
	</head>
	<body>
		<p class="header"><span>Unity Web Player | </span>CARD-FPS</p>
		<div class="content">
			<div id="unityPlayer">
				<div class="missing">
					<a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now!">
						<img alt="Unity Web Player. Install now!" src="http://webplayer.unity3d.com/installation/getunity.png" width="193" height="63" />
					</a>
				</div>
			</div>
		</div>
		<p class="footer">&laquo; created with <a href="http://unity3d.com/unity/" title="Go to unity3d.com">Unity</a> &raquo;</p>
	</body>
</html>
