import sys

from socket import *

class FishTank:

		# device-specific variables can be instantiated here
		name = "Super Fishtank"
        
		def __init__(self, port, username):
				self.serverPort = port
				self.food = 10
				self.temperature = 75
				self.status = "Off"
				self.electricity = 0
				self.user = username
                
		def set_port(self, port_num):
				self.serverPort = port_num

		def run(self):
				deviceSocket = socket(AF_INET, SOCK_STREAM)
				deviceSocket.settimeout(200)
				deviceSocket.bind(('', self.serverPort))
				deviceSocket.listen(1)

				print "The server is ready to receive"

				while 1:
					connectionSocket, addr = deviceSocket.accept()
					sentence = connectionSocket.recv(1024)
					print 'Received "', sentence, '" from Client...'

					if sentence == name:
						message = "ON/OFF feed refill_secret up_temp down_temp light_status food_status temp_status electricity"
        
	
					if sentence == "ON/OFF":
						if status == "ON":
							status = "OFF"
						else:
							status = "ON"
							electricity += 5
						message = "Your fish tank light is currently " + status
						# make sure not to do anything if the tank light is off

					if sentence == "feed":
						if food > 0:
							message = "Currently feeding fish..."
							electricity += 5
							food -= 1;
						else:
							message = "You have no more fish food left. "
					# make sure not to feed your fish too much

					if sentence == "refill_secret":
						food = 10
					# secret command in case you need to "refill" the food for debug purposes

					if sentence == "up_temp":
						temperature += 5
						electricity += 5
						message = "Your fish tank is currently " + str(temperature) + " degrees Fahrenheit."
					elif sentence == "down_temp":
						temperature -= 5
						electricity += 5
						message = "Your fish tank is currently " + str(temperature) + " degrees Fahrenheit."
					#two commands to increase/decrease temperature

					if sentence == "light_status":
						message = "You fish tank light is currently " + status
					#status update of light

					if sentence == "food_status":
						message = "You currently have " + str(food) + " fish foods available."
					#fish food status update

					if sentence == "temp_status":
						message = "Your fish tank is currently " + str(temperature) + " degrees Fahrenheit."
					#allows status update of temperature

					if sentence == "electricity":
						message = "You have used up " + str(electricity) + " electricities."

					connectionSocket.send(message)
					connectionSocket.close()
