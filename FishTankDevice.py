import sys

from socket import *

# hard-code port number (everyone do something different obviously)
serverPort = 1401

# device-specific variables can be instantiated here
status = "Off"
food = 10

deviceSocket = socket(AF_INET, SOCK_STREAM)
deviceSocket.settimeout(20)
deviceSocket.bind(('', serverPort))
deviceSocket.listen(1)

print "The server is ready to receive"

while 1:
	connectionSocket, addr = deviceSocket.accept()
	sentence = connectionSocket.recv(1024)
	print 'Received "', sentence, '" from Client...'
	
	if sentence == "ON/OFF":
		if status == "ON":
			status = "OFF"
		else:
			status = "ON"
		message = "Your fish tank light is currently " + status
		
	# make sure not to do anything if the tank light is off
	if sentence == "feed":
		if food > 0:
			message = "Currently feeding fish..."
		else:
			message = "You have no more fish food left. "
	# make sure not to feed your fish too much
	
	if sentence == "refill_secret":
		food = 10
	# secret command in case you need to "refill" the food for debug purposes
	
	connectionSocket.send(message)
	connectionSocket.close()
