import sys

for arg in sys.argv:
  if arg == 'site1.com':
    gaugeID = 'YOURGAUGEID'
    site = 'site1'
    siteName = arg
    siteURL = 'http://site1.com'
  if arg == 'site2.com':
    gaugeID = 'YOURGAUGEID'
    site = 'site2'
    siteName = arg
    siteURL = 'http://site2.com'
  if arg == 'site3.com':
    gaugeID = 'YOURGAUGEID'
    site = 'site3.com'
    siteName = arg
    siteURL = 'http://site3.com'

authToken = '9e48a1a90a40302d8e7893ed73c0d0a9'
APIurl = 'https://secure.gaug.es/gauges/' + gaugeID

authHeader = 'X-Gauges-Token'

# Report Location
filePath = '/home/blog/Dropbox/Notes/'
fileName = site + '-daily-report-' #date will be appended
fileExt = '.md'

def getJSON(url, authHeader, authToken):
    import json
    import urllib2
    req = urllib2.Request(url)
    req.add_header( authHeader, authToken)
    opener = urllib2.build_opener()
    f = opener.open(req)
    return json.load(f)

# Get traffic

trafficURL = APIurl + '/traffic'
j = getJSON(trafficURL, authHeader, authToken)
date = j['date']

# Create report

f = open(filePath + fileName + date + fileExt, 'w+')
f.write('# Gauges Report for [' + siteName + '](' + siteURL + ') on '  + date + "\n\n")

# Traffic Report

f.write("## Traffic \n\n")

latest = len(j['traffic'])-1
today = j['traffic'][latest]
views = today['views']
people = today['people']

f.write(str(views) + ' views by ' + str(people) + "  people.  \n\n")

# Content View Report

contentURL = APIurl + '/content'

j = getJSON(contentURL, authHeader, authToken)
date = j['date']

f.write("## Views \n\n")

for content in j['content']:
  title = content['title']
  if title.endswith(' ' + siteTitle):
    title = title[:-len(siteTitle) - 3]
  uri = content['url']
  views = content['views']
  report = '[' + title + '](' + uri + ') : ' + str(views) + "  \n"
  
  f.write(report.encode('utf-8', 'ignore'))

# Referrers Report

referrersURL = APIurl + '/referrers'
j = getJSON(referrersURL, authHeader, authToken)

f.write("## Referrers \n\n")

for referrer in j['referrers']:
  host = referrer['host']
  uri = referrer['url']
  views = referrer['views']
  report = '[' + host + '](' + uri + ') : ' + str(views) + "  \n"
      
  f.write(report.encode('utf-8', 'ignore'))

f.closed