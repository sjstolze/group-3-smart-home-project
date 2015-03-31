import sys

from socket import *

# hard-code port number (everyone do something different obviously)
serverPort = 1400

# device-specific variables can be instantiated here
status = "Off"

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
		message = "Your coffee maker is currently " + status
		
	# make sure not to do anything if the coffee maker is off
	if sentence == "brew":
		if status == "ON":
			message = "Currently brewing coffee..."
		else:
			message = "Your coffee maker is currently off. Please turn it on before trying to brew."

	connectionSocket.send(message)
	connectionSocket.close()
