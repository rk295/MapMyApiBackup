# MapMyApi Backup

This is a simple PHP script which connects to [MapMyApi](https://www.mapmyapi.com/) and downloads your workouts. They are saved to disk in JSON files, one file per workout.

This repo includes a copy of the community supported [php](https://github.com/mapmyfitness/mapmyfitness-php-sdk) library for using the MapMy API. I've made a few changes to it, when I get round to it I'll submit a pull request to try and get those changes into their repo.

## Usage

It is intended to be run from inside a webserver, I have a cron job which looks like

<pre>
curl -s http://server/fetchWorkouts.php?quiet
</pre>

### Options

You can pass various options as GET parameters:

* quiet - prints nothing
* debug - prints quite a lot of info
* startedAfter - only fetch workouts after the given date (in YYYY-MM-DD format)

For example:

<pre>
curl -s http://server/fetchWorkouts.php?debug&startedAfter=2014-01-01
</pre>

Will only look for workouts after 1st of Jan 2014 and print some debugging info.

## Configuration

You'll need to do a few things before you can use this.

1. Firstly you need to host it on a web server somewhere which can both see the internet.
2. Take a copy of conf-sample.php and call it conf.php in the same directory.
3. Then you need to register an app at the MapMyAPI developer site. Create an account and then navigate to [here](https://www.mapmyapi.com/apps/mykeys) to create an app.
4. Once you have created your app paste the consumer key and consumer secret into conf.php
5. Load getOauthTokents.php in a browser. the URL will be specific to your install, but something like:
6. Click through to auth your app against your MapMy account, you will be returned to the same page on your server but hopefully there will some OAUTH tokens for you to copy and paste into conf.php
7. Make sure the user your web server is running as can write to the log file and the backup dir defined in the conf.php
8. hit fetchWorkouts.php from a browser. Using no params it ought to do something sensible.

I'm at robin@kearney.co.uk if you want any help.
