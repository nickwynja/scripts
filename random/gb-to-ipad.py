from tempfile import mkstemp
from shutil import move
from os import remove, close
import sys, os

def replace(file, pattern, subst):
    #Create temp file
    fh, abs_path = mkstemp()
    new_file = open(abs_path,'w')
    old_file = open(file)
    for line in old_file:
        new_file.write(line.replace(pattern, subst))
    #close temp file
    new_file.close()
    close(fh)
    old_file.close()
    #Remove original file
    remove(file)
    #Move new file
    move(abs_path, file)

path = sys.argv[1]
pd = path + "projectData"
md = path + "Output/metadata.plist"

replace(pd, 'macos', 'ios')
replace(pd, 'x86_64', 'iPad1,1')

replace(md, 'macos', 'ios')
replace(md, 'x86_64', 'iPad1,1')

filename_list = path.split('/')
filename = filename_list[-2]
basename = filename.partition('.')
newname = basename[0] + ".ipad.band"
dirpath = path.replace(filename, '')

os.rename(dirpath + filename, dirpath + newname)