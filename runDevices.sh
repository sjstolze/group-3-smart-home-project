#!/bin/bash
# This program enables all devices to be discoverable for demo purposes.
# Still a little bit finicky with hard coded port numbers, but it works most of the time!
# 	add devices as we go along...
#	use & character to run a job in the background

function pause(){
	read -p "$*"
}

# Begin running these devices
python ToasterDevice.py &
python FishTankDevice.py &

# Stop executing these devices when enter is pressed
pause "Hit enter when done using the devices..."

# Kill device processes that are still running
for i in $(pgrep python); do
	kill $i
done
