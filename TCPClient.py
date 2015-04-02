import sys


# Import socket library
from socket import *

# hard-code hostname and port
serverName = "uaf59250.ddns.uark.edu"
serverPort = int(sys.argv[1])

sentence = ''
for x in range(len(sys.argv)):
    if x > 1:
        sentence = sentence + sys.argv[x] + ' '
sentence = sentence.strip()
# sending whatever to server, basically pinging it

# Choose SOCK_STREAM, which is TCP
clientSocket = socket(AF_INET, SOCK_STREAM)

# Connect to server using hostname/IP and port
clientSocket.connect((serverName, serverPort))

# Send it into socket to server
clientSocket.send(sentence)

# Receive response from server via socket
modifiedSentence = clientSocket.recv(1024)

mod = modifiedSentence.split(" ")
for word in mod:
    print word

# prints response so "runClient.php" grabs it
#print modifiedSentence
clientSocket.close()
