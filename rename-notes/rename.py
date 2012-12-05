#!/usr/local/bin/python
# This Python file uses the following encoding: utf-8
import os, re

def brain_log(string):
  import datetime, time
  now = (datetime.datetime.now()).strftime("%Y-%m-%d %H:%M:%S")
  file = "/Users/brain/Dropbox/Documents/brain.log"
  s = now + ": " + string + "\n"
  with open(file, 'a') as f:
    f.write(s)
    f.closed

d = '/Users/brain/Dropbox/Documents/Notes/'
file = d + u'Notes to Tag — inboxx.txt'

if os.path.exists(file):
  list = open(file).readlines()
  for line in list:
    f = re.split(':', line)
    o = f[0].strip()
    n = f[1].strip()
    os.system('mv \"' + d + o + '\" \"' + d + n + '\"')
    brain_log('Renamed \"' + o + '\" note to \"' + n + '\".')
  os.remove(file)
else:
  print "No notes to update."