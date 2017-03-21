<?php

$info = file_get_contents("http://api.urbandictionary.com/v0/random");
$defs = json_decode($info,true);

if(array_key_exists('theme_color',$_GET) && $_GET['theme_color'] != ""){
	$theme_color = '#' . $_GET['theme_color'];
}
else{
	$rand = rand(82,178);
	$colors = [178,82,$rand];
	shuffle ($colors);
	$theme_color = 'rgb('.$colors[0].','.$colors[1].','.$colors[2].')';
}

$word = $defs['list'][0]['word'];
$def = $defs['list'][0]['definition'];

?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>SQUEEB!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="SQUEEB!">
  <meta name="author" content="SQUEEB!">


<link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
<script>
setTimeout(function(){
location.reload();

}, 20000);
</script>
<style>
/* http://meyerweb.com/eric/tools/css/reset/ 
   v2.0 | 20110126
   License: none (public domain)
*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}

body{
background:<?php print $theme_color; ?>;
color:black;
font-family: 'Playfair Display', serif;
padding:0 30px;

}
#squeeb_holder{
padding:100px 0;
}
#word{
text-align:center;
word-break: break-all;
font-size:10em;
padding:30px;
margin:0;
}
#def{
    margin: 0 auto;
    font-size: 1.8em;
    padding: 20px;
    max-width: 960px;
    text-align: center;
    font-weight: 100;
    line-height: 122%;
}
@media (max-width: 600px) {
  body{
    font-size:0.5em;
    padding:0 30px;
  }
  #def{
    text-align:left;
}
}
</style>


</head>

<body>
<div id="squeeb_holder">
<h1 id="word"><?php print $word ?></h1>
<p id="def"><?php print $def ?></p>
</div>
<script type="application/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script type="application/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

</body>
</html>


