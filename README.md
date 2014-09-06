# PageSpeedInsightsChecker



### facilitating the adoption of a culture of continual improvement in web app performance

This script does three things...

* Checks the Google [Page Speed Insights](https://developers.google.com/speed/pagespeed/insights/) desktop and mobile scores for an array of sites you provide
* Sends email notification when scores are below a pre-set threshold
* Generates a "dashboard" web page with the scores

Ideally, you will cron this to run regularly (daily or weekly) so you'll always be proactively updated of your sites' performance. If a desktop or mobile score of one of your properties falls below the threshold score you set, an email will be fired off. It's recommended that this email goes to a distro of stakeholders in your organization (Dev, Ops, Marketing, etc).

Your organization will be able to more easily monitor these performance scores and hard-code them into key performance indicators. 

### what you do

* You need to add four things to PageSpeedInsightschecker.php

   * your key for the Google PageSpeed Insights API, available [here](https://developers.google.com/speed/docs/insights/v1/getting_started)
   * number between 1 and 100 that you consider an acceptable Google PageSpeed Insights score for the sites you're checking
   * one or more sites to check
   * an email address to send the notifications

* Cron PageSpeedInsightschecker.php so it goes off on a regular basis

### screenshots

Here's what the web page dashboard looks like when the script is done running.

![example of PageSpeedInsightsChecker dashboard](https://github.com/cqueern/PageSpeedInsightsChecker/blob/master/PSIC-dashboard-example.png)

And here's a screenshot of the email notification that's generated when the script finds a mobile or desktop score that falls below the threshold.

![example of PageSpeedInsightsChecker email notification](https://github.com/cqueern/PageSpeedInsightsChecker/blob/master/PSIC-email-notification-example.png)


