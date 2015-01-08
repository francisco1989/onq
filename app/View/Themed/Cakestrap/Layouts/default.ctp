<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'ONQ');
?>
<?php echo $this->Html->docType('html5'); ?> 
<html>
	<head>
	<style>
	/*sign up button*/
	a.signbutton {
		position: relative;
		bottom: -10px;
		float: left;
		display: inline;
		font-size: 110%;
		width: auto;
		font-weight:normal;
		font-size: 110%;
		padding: 4px 18px;
		background:linear-gradient(rgba(4,95,248,1), rgba(4,27,159,1));
		border-color: #2d6324;
		color: #fff;
		text-shadow: rgba(0, 0, 0, 0.5) 0px -1px 0px;
		border:1px solid #bbb;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		text-decoration: none;
		user-select: none;
	}
	
	a.signbutton:hover{
		background: #045ff8;
		color: #fff;
	}
	
	form .submit input[type=submit] {
		position: relative;
		bottom: -10px;
		float: left;
		display: inline;
		font-size: 110%;
		width: auto;
		font-weight:normal;
		font-size: 110%;
		padding: 4px 18px;
		background:linear-gradient(rgba(4,95,248,1), rgba(4,27,159,1));
		border-color: #2d6324;
		color: #fff;
		text-shadow: rgba(0, 0, 0, 0.5) 0px -1px 0px;
		border:1px solid #bbb;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		text-decoration: none;
		user-select: none;
	}
	
	form .submit input[type=submit]:hover {
		background: #045ff8;
	}
	
	/*Label on login*/
	label {
		font-size: 110%;
		margin-bottom:3px;
		padding: 1%;
	}

	/*text area login*/
	input, textarea {
		clear: both;
		font-size: 80%;
		font-family: "frutiger linotype", "lucida grande", "verdana", sans-serif;
		padding: 1%;
		width:100%;
		vertical-align:top;
	}

	

	/** Layout **/
	#container {
		text-align: left;
	}
	/*login form top right of screen*/	
	div.loginform{
		position:absolute;
		top:10px;
		right:50px;
		line-height:10px;
		color: #fa8a05;
		font-size:10px;
		text-align:left;
	}
	#header{
		position:relative;
		top: -20px;
		width: 100%;
		padding: 60px;
		background: url('../img/logo.png') left top no-repeat, linear-gradient(rgba(4,95,248,1), rgba(3,17,95,1));
	}
	#header h1 {
		position:relative;
		top: -20px;
		width: 20%;
		padding: 60px;
		line-height:10px;
		color: #fa8a05;
		font-size:15px;
		text-align:left;
	}
	#header h1 a {
		color: #fff;
		background: #003d4c;
		font-weight: normal;
		text-decoration: none;
		
	}
	#header h1 a:hover {
		color: #fff;
		background: #003d4c;
		text-decoration: underline;
	}
	#content{
		background: #fff;
		clear: both;
		color: #333;
		padding: 10px 20px 40px 20px;
		overflow: auto;
	}
	
	#footer {
		position:relative;
		bottom:0;
		z-index:999999;
		height:60px;
		width: 100%;
		text-align: right;
		background: linear-gradient(rgba(4,95,248,1), rgba(3,17,95,1));
		background-attachment: scroll;
	}
	
	.modal-body 
	{
		max-height: 800px;
	}
	
	</style>
		<h1>
		
		</h1>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $cakeDescription ?>:

		</title>
		<?php
			echo $this->Html->meta('icon');
			
			echo $this->fetch('meta');

			echo $this->Html->css('bootstrap');
			echo $this->Html->css('main');

			echo $this->fetch('css');
			
			echo $this->Html->script('libs/jquery-1.10.2.min');
			echo $this->Html->script('libs/bootstrap.min');
			
			echo $this->fetch('script');
		?>
	</head>

	<body>

		<div id="main-container">
		
			<div id="header" class="container">
				<?php echo $this->element('menu/top_menu'); ?>
			</div><!-- /#header .container -->
			
			<div id="content" class="container">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div><!-- /#content .container -->
			
			<div id="footer" class="container">
				<?php //Silence is golden ?>
			</div><!-- /#footer .container -->
			
		</div><!-- /#main-container -->
		
		<div class="container">
			<div class="well well-sm">
				<small>
					<?php echo $this->element('sql_dump'); ?>
				</small>
			</div><!-- /.well well-sm -->
		</div><!-- /.container -->
		
	</body>

</html>