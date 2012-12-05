import clipboard
import re
import webbrowser

_slugify_strip_re = re.compile(r'[^\w\s-]')
_slugify_hyphenate_re = re.compile(r'[-\s]+')
def slugify(value):
    import unicodedata
    if not isinstance(value, unicode):
        value = unicode(value)
    value = unicodedata.normalize('NFKD', value).encode('utf-8', 'ignore')
    value = unicode(_slugify_strip_re.sub('', value).strip().lower())
    return _slugify_hyphenate_re.sub('-', value)

t = clipboard.get()

if t == '':
  print 'No text in clipboard'
else:
  s = slugify(t)
  clipboard.set(s)
  webbrowser.open('byword://')