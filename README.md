# PageSpeedInsightsChecker



### facilitating the adoption of a culture of continual improvement in web app performance

This script does three things...

1. Checks the Google [Page Speed Insights](https://developers.google.com/speed/pagespeed/insights/) desktop and mobile scores for an array of sites you provide
2. Sends email notification when scores are below a pre-set threshold
3. Generates a "dashboard" web page with the scores

Ideally, you will cron this to run regularly (daily or weekly) so you'll always be proactively updated of your sites' performance.

### what you do

You need to add four things to the script.

1. your key for the Google PageSpeed Insights API, available [here](https://developers.google.com/speed/docs/insights/v1/getting_started)
2. number between 1 and 100 that you consider an acceptable Google PageSpeed Insights score for the sites you're checking
3. one or more sites to check
4. an email address to send the notifications


### screenshots

Here's what the web page dashboard looks like when the script is done running.

![example of PageSpeedInsightsChecker dashboard](https://github.com/cqueern/PageSpeedInsightsChecker/blob/master/PSIC-dashboard-example.png)

And here's a screenshot of the email notification that's generated when the script finds a mobile or desktop score that falls below the threshold.

![example of PageSpeedInsightsChecker email notification](https://github.com/cqueern/PageSpeedInsightsChecker/blob/master/PSIC-email-notification-example.png)


