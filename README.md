Cache-Control Scanner
=====================

Determines the cache-control setup for some of the web's most popular domains. Eventually, I would like to also track more closely the use of Pragma: no-cache, zero-or-negative Expires headers, and more. Suffice it to say that there are many ways I would enjoy improving this, as time permits.

### Requirements

This project uses various modern browser features, such as MutationObservers, Flexbox, CSS Level 3 transitions and more. Additionally, I use the meter element to depict progress while crawling over domains. The reporting should work in most any browser, but the full experience will require the latest versions of Chrome, Firefox, or Internet Explorer. And even then.

The front-end of this was somewhat rushed; and should be revisited to ensure greater cross-browser compatability, as well as support for somewhat legacy browsers that don't natively support many of the features used in this demo.

### Setup

You will need to be running WAMP Server, MAMP, PHP's Built-in CLI Server, or some other PHP-capable server. Ensure that openssl is enabled; you can do this in php.ini by uncommenting the corresponding .dll and restarting your server.

1. Clone this repo
2. Navigate to your local webserver and access scanner.php

![Screenshot](http://i.imgur.com/Gykvq1a.png)
