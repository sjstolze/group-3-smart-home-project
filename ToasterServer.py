import sys
import random
import ToasterClass
import os
# Import socket library
from socket import *

#user-port dictionary
userList = {}
name = "Toaster 3000"
random.seed()

# hard-code port number
serverPort = 1500

# Choose SOCK_STREAM, which is TCP
serverSocket = socket(AF_INET, SOCK_STREAM)

# safer way to kill server for iteration 1
serverSocket.settimeout(300)

# Start listening on specified port
serverSocket.bind(('', serverPort))

# Listener begins listening
serverSocket.listen(1)

print "The server is ready to receive"

while True:
    # Wait for connection and create a new socket
    # It blocks here waiting for connection
        connectionSocket, addr = serverSocket.accept()
    # Read bytes from socket
        sentence = connectionSocket.recv(1024)
        #sentence = "Toaster joe"

        
        devicename = sentence[sentence.find(" "):]
        username = sentence[:sentence.find(" ")]
        #deviceMessage = devicename.strip() + "." + name + "." + str(devicename.strip() == name)
        deviceMessage = "Wrong Device Name"
        if devicename.strip() == name:
                newUser = True
                #deviceMessage = "CORRECT DEVICE NAME"
                if username in userList:
                        newUser = False
                if newUser:
                        used = True
                        while used:
                                random.seed()
                                portNum = random.randint(1501, 1599)
                                print portNum
                                if len(userList) == 0:
                                        userList[username] = portNum
                                        used = False
                                for u in userList:
                                        print u
                                        if not userList[u] == portNum:
                                                used = False
                                if not used:
                                       userList[username] = portNum
                newpid = os.fork()
                if newpid == 0:
                        go = ToasterClass.Toaster(userList[username], username)
                        go.run()
                        os._exit(0)
        
                deviceMessage = str(userList[username]) + " ON/OFF up_cook_temp down_cook_temp toast"
        
        connectionSocket.send(deviceMessage)
        #print userList
        #deviceMessage = sentence
	# Send it into established connection
        #connectionSocket.send(deviceMessage)
	# Close connection to client but do not close server socket
        connectionSocket.close()
