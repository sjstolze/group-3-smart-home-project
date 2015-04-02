import sys

# Import socket library
from socket import *

# hard-code port number
serverPort = 1337

# Choose SOCK_STREAM, which is TCP
serverSocket = socket(AF_INET, SOCK_STREAM)

# safer way to kill server for iteration 1
serverSocket.settimeout(90)

# Start listening on specified port
serverSocket.bind(('', serverPort))

# Listener begins listening
serverSocket.listen(1)

print "The server is ready to receive"

while 1:
    # Wait for connection and create a new socket
    # It blocks here waiting for connection
	connectionSocket, addr = serverSocket.accept()

    # Read bytes from socket
	sentence = connectionSocket.recv(1024)
	print 'Received a ping the from Client...'
	
	deviceMessage = "There are 3 devices in your area"

	# Send it into established connection
	connectionSocket.send(deviceMessage)

	# Close connection to client but do not close server socket
	connectionSocket.close()
