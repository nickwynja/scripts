#!/usr/bin/python

import json
import urllib2
import re
from unicodedata import normalize
import os, time
import datetime
import re
import logging

logging.basicConfig(format='%(asctime)s %(message)s', datefmt='%Y-%m-%d %H:%M:%S:',filename='/tmp/pin_draft.log',level=logging.INFO)
os.environ['TZ'] = 'America/New_York'
time.tzset()
now =  str(datetime.datetime.now())


# Pinboard.in Credentials and Tag

pinToken = 'nickwynja:41B828BD4C8B854841EE'
pinTag = 'hm'

# Draft location and extension
draftPath = '/home/blog/Dropbox/hackmake/drafts/'
draftExt = '.md'

pinAPI = 'api.pinboard.in/v1/'
pinUpdate = 'posts/update'
pinGet = 'posts/get'

triggeredTime = 0

def getJSON(url):
    req = urllib2.Request(url, None)
    opener = urllib2.build_opener()
    f = opener.open(req)
    return json.load(f)

_slugify_strip_re = re.compile(r'[^\w\s-]')
_slugify_hyphenate_re = re.compile(r'[-\s]+')
def slugify(value):
    import unicodedata
    if not isinstance(value, unicode):
        value = unicode(value)
    value = unicodedata.normalize('NFKD', value).encode('utf-8', 'ignore')
    value = unicode(_slugify_strip_re.sub('', value).strip().lower())
    return _slugify_hyphenate_re.sub('-', value)

############################################

for i in range(18):


    updateURL = 'https://' + pinAPI + pinUpdate + '?auth_token=' + pinToken + '&format=json'
    j = getJSON(updateURL)
    updateTime = j['update_time']
        
    if updateTime != triggeredTime:
    
        getURL = 'https://' + pinAPI + pinGet + '?auth_token=' + pinToken + '&tag=' + pinTag + '&meta=yes' + '&format=json'
        j = getJSON(getURL)
            
        if j['posts']:
    
            last = len(j['posts'])-1
            post = j['posts'][last]
            
            postURL = post['href']
            postSlug = slugify(post['description'])
            postTitle = post['description']
            postText = post['extended']
            metatmp = '/tmp/pin_draft.meta'
            with open(metatmp, 'r+') as f:
              meta = f.read()
              f.close()
           
            if post['meta'] != meta:
    
                draft = postTitle + "\n====\nlink: " + postURL + "  \npublish-not\n\n" + postText
                meta = post['meta']
                with open(metatmp, 'w') as f:
                  f.write(meta)
                  f.close()

                file = draftPath + postSlug + draftExt
                            
                if not os.path.exists(file):
                  try:
                    with open(file, 'w') as f:
                      f.write(draft.encode('utf-8', 'ignore'))
                      logging.info(postSlug + draftExt + ' draft created.')
                      f.closed
                  except EnvironmentError:
                    logging.info('Draft write failed.')
                
                triggeredTime = updateTime
            
        else:    
            triggeredTime = updateTime

        time.sleep(3)

    else:
      time.sleep(3)
