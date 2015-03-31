import sys

from socket import *

# obviously use the same port for both client and device
# also, I know the serverName is uaf59250.ddns.uark.edu for the VM
serverName = "turing.uark.edu"
serverPort = 1400

sentence = sys.argv[1]
clientSocket = socket(AF_INET, SOCK_STREAM)

clientSocket.connect((serverName, serverPort))

clientSocket.send(sentence)

modifiedSentence = clientSocket.recv(1024)

print modifiedSentence
clientSocket.close()
