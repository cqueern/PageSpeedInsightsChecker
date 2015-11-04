<?php

//credits: underlying code used here comes from Michael Schrenk's terrific book "Webbots, Spiders, and Screen Scrapers: A Guide to Developing Internet Agents with PHP/CURL". You can pick up a copy at the following URL...
// http://www.amazon.com/Webbots-Spiders-Screen-Scrapers-Developing/dp/1593273975


//There are 4 variables you need to enter in the script. 

//Variable 1. enter the key for the Google PageSpeed Insights API. An API key can be obtained by following the instructions here: https://developers.google.com/speed/docs/insights/v1/getting_started
$key = "paste your key in between these quotes";

//Variable 2. enter the number between 1 and 100 that you consider an acceptable Google PageSpeed Insights score here
$pageSpeedThreshold = 75;

//Variable 3. enter the host(s) you would like to check below
$hostarray = array(
"example.com",
"cool-website.net",
"high-performance-website.org"
);

//Variable 4. enter the email address you want to receive alerts
$notification_email_address   = "yourEmailAddress@example.com";

//That's it!


include("LIB_http.php");
include("LIB_mail.php");



//Start the timer
set_time_limit(0);
$time_start = microtime(true);

//how many hosts are being analyzed?
$numHosts = count($hostarray);

//begin prepping the email notification 
	$webbot_email_address         = "pageSpeedInsightsCheckerDaemon@".$_SERVER['SERVER_NAME'];
	$psi_lookupddress['from']    = $webbot_email_address;
 	$psi_lookupddress['to']    = $notification_email_address;
	$subject = "ALERT! One or more of our hosts are underperforming!";
	$message = "\"Fast and optimized pages lead to higher visitor engagement, retention, and conversions.\" - Google.\n\nThe Google PageSpeed Insights tool reports that one or more hosts are performing poorly when we checked at ".date("r").". These are not acceptable because they received a score less than ".$pageSpeedThreshold.".\n\n";
$message = $message . "*******************\n\n";


//here we gooooo!
print<<<_HTML_
<!DOCTYPE html>
<html>
<head>
<title>Google PageSpeed Insights Checker</title>
<meta charset="utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name=viewport content="width=device-width, initial-scale=1">
<link rel="preload" href="//fonts.googleapis.com/css?family=PT+Sans">
<link rel="preload" href="//fonts.googleapis.com/css?family=Open+Sans:400,800">
<link rel="preload" href="/css/flexslider.css">
<link rel="preload" href="/css/FNTcss.css">
<link rel="prerender" href="//developers.google.com/speed/pagespeed/insights/">
<link rel="dns-prefetch" href="//chart.googleapis.com">
_HTML_;

echo "\r\n";
//this will insert code into the HEAD section which tells the browser to prefetch DNS information about each of the hosts we analyze
for ($i = 0, $num_domains = count($hostarray); $i < $num_domains; $i++) {
	echo "<link rel=\"dns-prefetch\" href=\"//".$hostarray[$i]."\">\r\n";
	}

echo "<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Open+Sans:400,800\" type=\"text/css\">\r\n";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/FNTcss.css\" media=\"all\" />\r\n";
echo "<link rel=\"stylesheet\" href=\"css/flexslider.css\" type=\"text/css\" />\r\n";
echo "<link href=\"https://fonts.googleapis.com/css?family=PT+Sans\" rel=\"stylesheet\" type=\"text/css\" />";
echo "</head>\r\n";
echo "<body>\r\n";
echo "<h1>Google PageSpeed Insights Results</h1>\r\n";

echo "<p class=\"main\">This page provides scores from <a href=\"https://developers.google.com/speed/pagespeed/insights/\" target=\"_blank\">Google Page Speed Insights</a> for the Desktop and Mobile versions of ".$numHosts." host(s). Our organization considers any score below ".$pageSpeedThreshold." unacceptable.</p>\r\n";
echo "<section>\r\n";	
echo "<table>";




for ($i = 0, $num_domains = count($hostarray); $i < $num_domains; $i++) {


//request the scores as soon as possible
//begin the desktop query
$desktop_psi_lookup = json_decode(file_get_contents("https://www.googleapis.com/pagespeedonline/v1/runPagespeed?url=http://".$hostarray[$i]."&key=".$key."&prettyprint=true"), true);
$desktop_psi_lookup_score = (int) $desktop_psi_lookup['score'];

//begin the mobile query
$mobile_psi_lookup = json_decode(file_get_contents("https://www.googleapis.com/pagespeedonline/v1/runPagespeed?url=http://".$hostarray[$i]."&key=".$key."&prettyprint=true&strategy=mobile"), true);
$mobile_psi_lookup_score = (int) $mobile_psi_lookup['score'];


echo "<tr>";
echo "<td>";
echo "<h2>".$hostarray[$i]."</h2>\r\n";
echo "</td>";
echo "<td>";
echo "</td>";
echo "</tr>";
echo "<tr>";


//start echoing the responses
//desktop results
echo "<td>";
echo "<h3>Desktop score</h3>\r\n";
echo "<img width=\"180\" height=\"100\" src=\"https://chart.googleapis.com/chart?chs=180x100&cht=gom&chd=t:".$desktop_psi_lookup_score."&chco=dd4b39,dd4b39,dd4b39,dd4b39,fda100,fda100,009a2d&chxt=x,y&chxl=0:|".$desktop_psi_lookup_score."|1:|slow|fast\">";

	if ($desktop_psi_lookup_score < $pageSpeedThreshold) {

			//echo "<p class=\"main\"><font color=\"red\">Warning - this score is unacceptably low!</font></p>\r\n";
			$message = $message . "The desktop score for ".$hostarray[$i]." was only ".$desktop_psi_lookup_score. "!\nInformation on how to improve this host can be found at https://developers.google.com/speed/pagespeed/insights/?url=".$hostarray[$i]."&tab=desktop .\n\n";


			}
echo "</td>";


//mobile results
echo "<td>";
echo "<h3>Mobile score</h3>\r\n";
echo "<img width=\"180\" height=\"100\" src=\"https://chart.googleapis.com/chart?chs=180x100&cht=gom&chd=t:".$mobile_psi_lookup_score."&chco=dd4b39,dd4b39,dd4b39,dd4b39,fda100,fda100,009a2d&chxt=x,y&chxl=0:|".$mobile_psi_lookup_score."|1:|slow|fast\">";

	if ($mobile_psi_lookup_score < $pageSpeedThreshold) {

			//echo "<p class=\"main\"><font color=\"red\">Warning - this score is unacceptably low!</font></p>\r\n";
			$message = $message . "The mobile score for ".$hostarray[$i]." was only ".$mobile_psi_lookup_score. "!\nInformation on how to improve this host can be found at https://developers.google.com/speed/pagespeed/insights/?url=".$hostarray[$i]."&tab=mobile .\n\n";


			}

echo "</td>\r\n";
echo "</tr>\r\n";
echo "<tr>\r\n";
echo "<td>\r\n";
echo "<br><br>\r\n";
echo "</td>\r\n";
echo "<td>\r\n";
echo "<br><br>\r\n";
echo "</td>\r\n";
echo "</tr>\r\n";
				
}
echo "</table>\r\n";
echo "</section>\r\n";	



//end stopwatch
$time_end = microtime(true);
$time = $time_end - $time_start;
$roundedTime = round($time,2);




//here we start writing the end of the email report
$message = $message . "*******************\n\n";
$message = $message . "If you would like to see the full report, which includes the scores which performed well, visit the following link (be patient; it could take up to ".$roundedTime." seconds to resolve in your browser):\nhttp://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."\n\nFight for improvement! Never give up, never surrender!";



//fire off that email report!

	formatted_mail($subject, $message, $psi_lookupddress, $content_type="text/plain");
	
// If you only want it sent out every Sunday, you can use the code below...
/*
if (date("D") == "Sun")

{
	formatted_mail($subject, $message, $psi_lookupddress, $content_type="text/plain");
}
*/


$queryTimeRatio = $time/count($hostarray);
$roundedQueryTimeRatio = round($queryTimeRatio,2);

echo "<hr>\r\n<footer>\r\n";
echo "<table>\r\n<tr class=\"row\">\r\n<td>\r\n<img src=\"/img/clock_32.png\" height=\"32\" width=\"32\">\r\n</td>\r\n<td>\r\n<p class=\"main\">This page took $roundedTime seconds to run, and we queried for ".count($hostarray)." host(s). On average, the ratio between the number of seconds per host and the number of hosts should be approximately 7 to 1. Ratio in this case: $roundedQueryTimeRatio. </p>\r\n</td>\r\n</tr>\r\n</table>\r\n"; 
echo "</html>";
//done writing the page output after the lines above
//that's all folks
?>
