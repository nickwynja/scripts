tell application "System Events" to set pNames to name of application processes

if "Rdio" is in pNames then
	tell application "Rdio"
		previous track
	end tell
else if "iTunes" is in pNames then
	tell application "iTunes"
		previous track
	end tell
end if
