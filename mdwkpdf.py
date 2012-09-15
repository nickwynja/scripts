import sys, os, subprocess

arg = sys.argv
i = arg[1] #input file
f = i.split('.')
fn = f[0]
path = "/Users/nickwynja/Sites/personal/scripts/"


os.system('markdown2 ' + i + ' > ' + fn + '.tmp.html')
os.system('wkpdf --source ' + path + fn + '.tmp.html --output ' + path + fn + '.pdf')
os.system('rm ' + path + fn + '.tmp.html')
