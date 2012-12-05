Here is an assortment of scripts that I've made and/or are in the process of making. You can use them if you think they'll be helpful. Below are some notes about about them:

## Markdown to PDF Converter ##

**Work in progress.**

When complete, this will hopefully work along with Hazel and Dropbox to turn a `.md` file into a PDF with the specified styling. The basis of it turns markdown into HTML and `wkpdf` to go from HTML to PDF. In theory it shouldn't be that hard to do, I just haven't hard a need for it yet so haven't put in the time.

## Meetup Photo Downloader ##

This script will download all images at full resolution from a Meetup.com photo gallery. 

Grab to photo album ID from your meetup.com page and run the command like this:

    php ~/path/to/meetup-photo-download.php 1234567 /Directory/To/Save/ filename_prefix.
    
## Random ##

### Garageband to iPad ###

A python script that powers [this service](http://cl.ly/3w1R1h2o1C1v) that converts a Mac `.band` file for use in Garageband for iPad. Pretty handy, though my main use of Garageband at this point is podcasting and Garageband for iPad doesn't do a great job of supporting long projects.

### Get Text ###

A script [I used with Launch Center Pro][text-lcp] as a workaround for appending text to files in Dropbox until there was a better app on the scene. I now [use Notesy][notesy] instead and am just keeping this for reference.

[text-lcp]: http://hackmake.org/2012/06/27/quick-text-and-fast-learning-with-launch-center-pro
[notesy]: http://hackmake.org/2012/10/12/notesy-and-launch-center-pro

### Pythonista Slugger ###

A python script build for use in [Pythonista](http://omz-software.com/pythonista/) that converts a string into a url-ready slug. I use it when copying a title from a draft, convert it, and then have it take my back to Byword.

## Rename Notes ##

**Work in progress.**

A combination of scripts and Hazel rules that checks my Dropbox notes folder for note titles that don't match my tagging convention and list them out in a new note. Editing the text in that note with rename the corresponding note making it easy to review any new notes that were dumped in using nvALT and need to be cleaned up for posterity's sake.