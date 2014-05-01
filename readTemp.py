#!/usr/bin/python
#
# Nicholas Grant ECE331
# Temp Sensor Temperature Data Logger (Python I2C end)
#
# Making use of i2ctools and sqlite3 to grab
# temperature data from sensor and output it to
# sqlite3 database in project folder.
#
# Sources Cited:
# http://www.instructables.com/id/Raspberry-Pi-I2C-Python/
# http://www.acmesystems.it/i2c

import smbus
import time
import sqlite3

I2C_ADDRESS = 0x48

#The device address is found on bus 1, confirmed by i2cdetect
bus = smbus.SMBus(1)

#Set mode
bus.write_byte(I2C_ADDRESS, 0x0)

#Read all input lines
value = bus.read_byte(I2C_ADDRESS)
print value

####################################
# Store temperature in a database  #
####################################

connect = sqlite3.connect('/home/pi/ece331/project2/templog.db')
curs=connect.cursor()

curs.execute("INSERT INTO temps values(datetime('now'), (?))", (value,))

#commit changes
connect.commit()
connect.close()

