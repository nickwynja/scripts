#!/bin/bash

I=$1
PATH='/Users/nickwynja/Dropbox/\[Drop\]/\[Convert\]/'
#PATH = '/Users/brain/Dropbox/\[Drop\]/\[Convert\]/'
#FILENAME=$(basename "$I")
#NAME="${filename%.*}"
NAME='this'
echo $1

/bin/markdown2 $I > /tmp/$NAME.html
/usr/bin/wkpdf --source /tmp/$NAME.html --output $PATH $NAME .pdf
/usr/bin/rm /tmp/$NAME.html