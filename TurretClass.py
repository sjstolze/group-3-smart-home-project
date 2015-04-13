import sys

from socket import *

class Turret:

		# device-specific variables can be instantiated here
		name = "Wall-Mounted M249"
        
		def __init__(self, port, username):
				self.serverPort = port
				self.ammo = 500
				self.temperature = 60
				self.status = "Inactive"
				self.electricity = 0
				self.user = username
                #self.security = parent
				#possibly implement security, say if parent, then the gun can fire, else it won't
				
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
						message = "ON/OFF shoot refill_secret cooldown ammo_status temp_status electricity"
        
					if sentence == "ON/OFF":
						if status == "Active":
							status = "Inactive"
						else:
							status = "Active"
							electricity += 5
						message = "Your Wall Mounted M249 is currently " + status
						# make sure not to do anything if the turret is inactive

					if sentence == "shoot" and status == Active: #and security == parent:
						if ammo > 0 and temperature < 101:
							message = "Currently shooting target with 5-shot burst"
							electricity += 10
							ammo -= 5;
							temperature += 5
						elif ammo < 0 and temperature < 101:
							message = "You have no more ammo. "
						elif temperature > 101 and ammo > 0:
							message = "The gun is too hot to fire."
						else:
							message = "The gun refuses to cooperate."
					elif sentence == "shoot" and status == Inactive: #and security == parent:
						message = "The gun cannot fire because it is Inactive"
					#elif sentence == "shoot" and security != parent:
						#message = "Sorry, but you do not have access to this command."
					# make sure not to shoot your fish too much

					if sentence == "refill_secret":
						ammo = 500
						temperature = 60
					# secret command in case you need to "refill" the ammo/temp for debug purposes

					if sentence == "cooldown" and temperature > 60:
						temperature -= 10
						message = "Your gun is chilling out."
					#allow gun to chill out

					if sentence == "ammo_status":
						message = "You currently have " + str(ammo) + " shots available."
					#fish food status update

					if sentence == "temp_status":
						message = "Your gun is currently " + str(temperature) + " degrees Fahrenheit."
					#allows status update of temperature

					if sentence == "electricity":
						message = "You have used up " + str(electricity) + " electricities."

					connectionSocket.send(message)
					connectionSocket.close()
