<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (!empty($_POST['phone-full'])) {
	$rand = mt_rand(1000,9999);
	$arr1 = json_decode(file_get_contents('array.json'), true);
    array_push($arr1, array($rand =>$_POST['phone-full']));
	file_put_contents("array.json",json_encode($arr1));
	$message = "Hi, You have requested an auth code for my resume? Please use: {$rand} Yours, Sem Schilder";
	require "Services/Twilio.php";
    $AccountSid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    $AuthToken = 'xxxxxxxxxxxxxxxxxxxxx';
    $twillioNumber = '+1 xxx-xxx-xxx s';
    $client = new Services_Twilio($AccountSid, $AuthToken);
	$sms = $client->account->messages->sendMessage($twillioNumber,$_POST["phone-full"],$message);
	}elseif (!empty($_POST['auth'])) {
		$count = 0;
		$phone = '';
		$arr1 = json_decode(file_get_contents('array.json'), true);
		foreach ($arr1 as $row) {
		    if (!$count == 0){
			    if (array_key_exists($_POST['auth'], $row)) {
				    $phone = $row[$_POST['auth']];
				}
			}
			$count++;
		}
		if(!$phone == ""){
			//die('Your Auth is: '.$_POST['auth'].' and number: '.$phone);
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='CV.pdf'");
			readfile("FILENAMEHERE.pdf");
		}else{
			die('You have no permission');
		}
	}else{
		die('You did not provide a phone number or auth code');
	}
}

include('helpers.php')
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sem Schilder</title>
<link href='https://fonts.googleapis.com/css?family=Lato:400,900,400italic,900italic,300,300italic' rel='stylesheet' type='text/css'>
<link href='css/style.css' rel='stylesheet' type='text/css'>
<link href='css/intlTelInput.css' rel="stylesheet" type="text/css">
<link href='css/validation.css' rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<meta name="viewport" content="initial-scale=1.0, width=device-width" />

</head>

<body>
	<div class="container">
		<div class="content">
		<h1 class="name">Sem Schilder</h1>
			<h6 class="fittext">A Dutch Media student who loves to code</h6>
			<p>I am a designer who loves to code. That is why I am able to test my creative mind, ideas and avoid concepts that work great in theory, but would break down in practice.</p>
			<p>This means I can hop in at any stage the project needs me to be. From brainstorming and strategy ideas, to defining the user experience, to interface design, to development. I love to bring great projects to life, no matter the screen size or platform.</p>
			<ul class="social">
				<li class="facebook"><a href="http://facebook.com/xvilo" target="_blank"><i class="fa fa-facebook"></i></a></li>
				<li class="dribbble"><a href="http://dribbble.com/xvilo" target="_blank"><i class="fa fa-dribbble"></i></a></li>
				<li class="github"><a href="http://github.com/xvilo" target="_blank"><i class="fa fa-github"></i></a></li>
				<li class="product-hunt"><a href="https://www.producthunt.com/@xvilo" target="_blank"><i class="fa fa-product-hunt"></i></a></li>
				<li class="steam"><a href="http://steamcommunity.com/id/xvilo" target="_blank"><i class="fa fa-steam"></i></a></li>
			</ul>
			<h1 class="media">Music and Series</h1>
			<h6><i>Things I can't live without...</i></h6>
			<ul class='item-list series'>
			<?php 
			foreach (getTrakt() as $value){
				echo "<li id='{$value->episode->ids->trakt}'><a href='http://trakt.tv//search/tvdb/{$value->episode->ids->tvdb}?id_type=episode' target='_blank'>Watched {$value->episode->title} from {$value->show->title}, ".time2str($value->watched_at)."</a></li>";
				}?>
			</ul>
			<h6></h6>
		</div>
		<section>
			<br>
			<div class="content">
				<h2>Some of my work</h2>
				<ul class="portfolio">
				<li>
					<a href="lingerie-donna/">
						<h3>Lingerie Donna</h3>
						<p>Lingerie e-commerce website based on Magento</p>
					</a>
				</li>
				<li>
					<a href="oranje-boom/">
						<h3>Oranjeboom</h3>
						<p>New-build project for (young) starters</p>
					</a>
				</li>
				<li>
					<a href="itph-academy/">
						<h3>ITPH Academy</h3>
						<p>ICT courses for students and professionals</p>
					</a>
				</li>
				<li>
					<a href="http://youarejust.com/?ref=portfolio" target="_blank">
						<h3>You Are Just</h3>
						<p>Simply discovery what you are!</p>
					</a>
				</li>
				<li>
					<a>
						<h3>Wait, there is more!</h3>
						<p>I would be happy to talk to you about some other projects I worked on and about how my passion for the aesthetic side of the world wide web can make me a useful addition to your team.</p>
					</a>
				</li>
			</ul>
			</div>
		</section>
		<div class="content">
			<h1 class="beautifullcode">I design beautiful code</h1>
			<p>During my current studies I worked as a full-stack designer for 8 months with a Dutch web development studio called Magneet Online. I contributed to many projects and it also helps to keep my knowledge up-to-date.</p>
			<img src="img/logos.png" alt="logos" style="max-width: 100%; margin-bottom: 3em;">
	
		</div>
		<div class="content">
			<h6 class="reverted"><i>And ofcourse...</i></h6>
			<h1 class="internship">I'm looking for an internship.</h1>
			<p>My studie requires a 6-month internship from Januari to July 2016. I would be happy to talk to you about some other projects I worked on and about how my passion for the aesthetic side of the world wide web can make me a useful addition to your team.</p>
			<p>You can take a look at my <a id="go" rel="leanModal" name="signup" href="#signup">resume</a> or <a href="https://nl.linkedin.com/in/semschilder
">Linkedin account</a> and <strong><a href="mailto:me@sem.design">feel free to contact me.</a></strong></p>
		</div>
	</div>
	<div id="signup">
			<div id="signup-ct">
				<div id="signup-header">
					<h2>My Resume</h2>
					<p>Because I don't want my personal stuff spread on the interwebs, it is 'protected'. To be sure you actually <i>want</i> to see it you need to provide your mobile phone number. I will send you the auth code which will allow you to access it.</p>
				</div>
				
				<form id="resume_form" method="post">
     
				  <div class="txt-fld">
				    <label for="">Mobile</label>
				    <input id="phone" class="good_input" name="phone" type="tel" />
				    <input id="hidden" type="hidden" name="phone-full">
				    <p>Or use the auth code</p>
				     <input id="auth" class="good_input" name="auth" type="tel" />
				  </div>
				  <div class="btn-fld">
				  <button type="submit">Go &raquo;</button>
</div>
				 </form>
			</div>
		</div>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
	<script type="text/javascript" src="js/jquery.fittext.js"></script>
	<script type="text/javascript" src="js/intlTelInput.min.js"></script>
	<script type="text/javascript" src="js/phonevalidate.js"></script>
	<script type="text/javascript" src="js/utils.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
</body>

</html>