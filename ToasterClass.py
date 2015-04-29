import sys

from socket import *

class Toaster:

        # device-specific variables can be instantiated here
        
        
        
        def __init__(self, port, username):
                self.name = "Toaster 3000"
                self.serverPort = port
                self.cook_temp = "low"
                self.cook_time = 1
                self.status = "Off"
                self.user = username
                
        def set_port(self, port_num):
                self.serverPort = port_num

        def run(self):
                deviceSocket = socket(AF_INET, SOCK_STREAM)
                deviceSocket.settimeout(300)
                deviceSocket.bind(('', self.serverPort))
                deviceSocket.listen(1)

                print "The Toaster is ready to receive"

                while 1:
                        connectionSocket, addr = deviceSocket.accept()
                        reponce = connectionSocket.recv(1024)
                        sentence = reponce.strip()
                        print 'Received "', sentence, '" from Client...'
                        username = sentence[:sentence.find(" ")]
                        print username
                        sentence = sentence[sentence.find(" "):].strip()
                        print sentence
                        message = ''
                        if username == self.user:
                          # first access case	
                          if sentence == self.name:
                                  message = "ON/OFF up_cook_temp down_cook_temp toast"  


                          if sentence == "ON/OFF":
                                  if self.status == "ON":
                                    self.status = "OFF"
                                  else:
                                    self.status = "ON"
                                  message = "Your toaster is currently " + self.status

		
                          # make sure not to do anything if the coffee maker is off
                          if sentence == "toast":
                                  if self.status == "ON":
                                          message = "Currently toasting toast of all toasts..."
                                  else:
                                          message = "Your toaster is currently off. Please turn it on before trying to toast."

                          if sentence == "up_cook_temp":
                                  if self.cook_temp == "low":
                                        self.cook_temp = "medium"
                                        message = "Cooking temperature is now " + self.cook_temp
                                  elif self.cook_temp == "medium":
                                        self.cook_temp = "high"
                                        message = "Cooking temperature is now " + self.cook_temp
                                  else:
                                        self.cook_temp = "high"
                                        message = "Toaster is already at max temperature."
  
                          if sentence == "down_cook_temp":
                                  if self.cook_temp == "high":
                                        self.cook_temp = "medium"
                                        message = "Cooking temperature is now " + self.cook_temp
                                  elif self.cook_temp == "medium":   
                                        self.cook_temp = "low"
                                        message = "Cooking temperature is now " + self.cook_temp
                                  else:
                                        self.cook_temp = "low"
                                        message = "Toaster is already at lowest temperature." 


                        else:
                          message = "Invalid Username"


                        connectionSocket.send(message)
                        connectionSocket.close()
