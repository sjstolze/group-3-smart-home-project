import sys

from socket import *

# hard-code port number (everyone do something different obviously)
serverPort = 1500

# device-specific variables can be instantiated here
status = "Off"
name = "Toaster 3000"
cook_temp = "low"
cook_time = 1



deviceSocket = socket(AF_INET, SOCK_STREAM)
deviceSocket.settimeout(20)
deviceSocket.bind(('', serverPort))
deviceSocket.listen(1)

print "The server is ready to receive"

while 1:
	connectionSocket, addr = deviceSocket.accept()
	sentence = connectionSocket.recv(1024)
	print 'Received "', sentence, '" from Client...'


        # first access case	
        if sentence == "ToasterDevice.py":
                message = "ON/OFF up_cook_temp down_cook_temp"  


	if sentence == "ON/OFF":
		if status == "ON":
			status = "OFF"
		else:
			status = "ON"
		message = "Your toaster is currently " + status

		
	# make sure not to do anything if the coffee maker is off
	if sentence == "toast":
		if status == "ON":
			message = "Currently toasting toast of all toasts..."
		else:
			message = "Your toaster is currently off. Please turn it on before trying to toast."

        if sentence == "up_cook_temp":
                if cook_temp == "low":
                      cook_temp = "medium"
                      message = "Cooking temperature is now " + cook_temp
                elif cook_temp == "medium":
                      cook_temp == "high"
                      message = "Cooking temperature is now " + cook_temp
                else:
                      cook_temp == "high"
                      message = "Toaster is already at max temperature."

        if sentence == "down_cook_temp":
                if cook_temp == "high":
                      cook_temp = "medium"
                      message = "Cooking temperature is now " + cook_temp
                elif cook_temp == "medium":   
                      cook_temp == "low"
                      message = "Cooking temperature is now " + cook_temp
                else:
                      cook_temp == "low"
                      message = "Toaster is already at lowest temperature." 





	connectionSocket.send(message)
	connectionSocket.close()
