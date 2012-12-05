#!/bin/bash

# Schedule this to run once a day with cron. Doesn't matter what time since it parses yesterday's hits (by default).
# I only tested this on the Marco.org server, which runs CentOS (RHEL). No idea how it'll work on other distributions, but it's pretty basic.

# Required variables:

if [ "$1" == "hackmake.org" ]; then
        LOG_FILE="/var/log/httpd/hackmake-access_log"
	REPORT_NAME="hackmake-daily-report"
fi

if [ "$1" == "nickwynja.com" ]; then
        LOG_FILE="/var/log/httpd/nickwynja-access_log"
	REPORT_NAME="nickwynja-daily-report"
fi

RSS_URI="/rss"
REPORT_PATH="/home/blog/Dropbox/Notes/"

# --- Optional customization ---

# Date expression for yesterday
DATE="-1 day" 

# Locale for printf number formatting (e.g. "10000" => "10,000")
LANG=en_US

# Date format in Apache log
LOG_FDATE=`date -d "$DATE" '+%d/%b/%Y'`

# Date format for report
REPORT_FDATE=`date -d "$DATE" '+%Y-%m-%d'`

REPORT_FILE=$REPORT_PATH$REPORT_NAME"-"$REPORT_FDATE".md"

# --- The actual log parsing ---

LOG_FDATE=`date -d "$DATE" "+${LOG_DATE_FORMAT}"`
DAY_BEFORE_FDATE=`date -d "$DATE -1 day" "+${LOG_DATE_FORMAT}"`

# Unique IPs requesting RSS, except those reporting "subscribers":
IPSUBS=`fgrep "$LOG_FDATE" "$LOG_FILE" | fgrep " $RSS_URI" | egrep -v '[0-9]+ subscribers' | cut -d' ' -f 1 | sort | uniq | wc -l`

# Google Reader subscribers and other user-agents reporting "subscribers" and using the "feed-id" parameter for uniqueness:
GRSUBS=`egrep "($LOG_FDATE|$DAY_BEFORE_FDATE)" "$LOG_FILE" | fgrep " $RSS_URI" | egrep -o '[0-9]+ subscribers; feed-id=[0-9]+' | sort -t= -k2 -s | tac | uniq -f2 | awk '{s+=$1} END {print s}'`

# Other user-agents reporting "subscribers", for which we'll use the entire user-agent string for uniqueness:
OTHERSUBS=`fgrep "$LOG_FDATE" "$LOG_FILE" | fgrep " $RSS_URI" | fgrep -v 'subscribers; feed-id=' | egrep '[0-9]+ subscribers' | egrep -o '"[^"]+"$' | sort -t\( -k2 -sr | awk '!x[$1]++' | egrep -o '[0-9]+ subscribers' | awk '{s+=$1} END {print s}'`

REPORT=$(
    printf "\n## Feed Stats\n\n"
    printf "%'8d Google Reader subscribers\n" $GRSUBS
    printf "%'8d subscribers from other aggregators\n" $OTHERSUBS
    printf "%'8d direct subscribers\n" $IPSUBS
    echo   "--------"
    printf "%'8d total subscribers\n" `expr $GRSUBS + $OTHERSUBS + $IPSUBS`
)

echo "$REPORT" >> $REPORT_FILE