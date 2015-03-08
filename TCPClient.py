import sys

# Import socket library
from socket import *

# hard-code hostname and port
serverName = "turing.uark.edu"
serverPort = 1337

# sending whatever to server, basically pinging it
sentence = "blah"

# Choose SOCK_STREAM, which is TCP
clientSocket = socket(AF_INET, SOCK_STREAM)

# Connect to server using hostname/IP and port
clientSocket.connect((serverName, serverPort))

# Send it into socket to server
clientSocket.send(sentence)

# Receive response from server via socket
modifiedSentence = clientSocket.recv(1024)

# prints response so "runClient.php" grabs it
print modifiedSentence
clientSocket.close()
