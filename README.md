PageSpeedInsightsChecker
========================

Does three things:

1. Checks the Google Page Speed Insights desktop and mobile scores for an array of sites you provide
2. Sends email notification when scores are below a pre-set threshold
3. Generates a "dashboard" web page with the scores


![example of PageSpeedInsightsChecker dashboard](https://github.com/cqueern/PageSpeedInsightsChecker/blob/master/PSIC-dashboard-example.png)



![example of PageSpeedInsightsChecker email notification](https://github.com/cqueern/PageSpeedInsightsChecker/blob/master/PSIC-email-notification-example.png)


You need to add four things to the script.

1. your key for the Google PageSpeed Insights API
2. number between 1 and 100 that you consider an acceptable Google PageSpeed Insights score for the sites you're checking
3. one or more sites to check
4. an email address to send the notifications