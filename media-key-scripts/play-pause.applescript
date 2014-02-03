tell application "System Events" to set pNames to name of application processes

if "Rdio" is in pNames then
	tell application "Rdio"
		if player state is paused or player state is stopped then
			play
		else if player state is playing then
			pause
		end if
	end tell
else if "iTunes" is in pNames then
	tell application "iTunes"
		if player state is paused or player state is stopped then
			play
		else if player state is playing then
			pause
		end if
	end tell
end if
