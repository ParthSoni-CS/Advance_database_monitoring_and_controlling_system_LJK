#!/usr/bin/env python
import time
import requests
import paho.mqtt.client as mqtt

# This is callback function. It is called when
# an MQTT message that you are subscribing to is received
def on_message(client, userdata, message):
   print ('got a message !')
   message.payload = message.payload.decode("utf-8")
   msg = message.payload # for on_message = "ON-192.168.1-Ard/0001-1301-25-35"  for off_message = "OFF-192.168.1-Ard/0001-1-18-30"
   print (msg)
   s_msg = msg.split(' ') # message is splited and stored in a list
   msg_Status = s_msg[0]
   print(msg_Status)
   msg_Raspid = s_msg[1]
   msg_Ardid = s_msg[2]
   msg_X = s_msg[3]
   print("Card No:",msg_X)
   msg_Hum = s_msg[4]
   msg_Temp = s_msg[5]
   msg_Y = s_msg[6]
   print("consum:",msg_Y)
   if msg_Status == "ON" :
       Hum = msg_Hum
       Rid = msg_Raspid
       Aid = msg_Ardid
       Cid = msg_X
       Temp = msg_Temp
       St = msg_Status
       payload = {'hum': Hum , 'rid': Rid ,'aid': Aid ,'cid': Cid ,'temp': Temp ,'st': St }
       #r = requests.get('http://192.169.0.107:8080/dashboard/edit_add.php', json=payload)
       r = requests.get('https://ljietproject.000webhostapp.com/ADMS/edit_add.php', json=payload)
       #https://ljietproject.000webhostapp.com/global/edit_add.php
       print("----------------------------------")
       print(r.text)
       print('----------------------------------')
       if r.text == '{"status":"true"}':
           print(Aid)
           print(Rid)
           last_char = Aid[-1]
           if last_char != "A":
               print("publish")
               print(msg_Ardid)
               client.publish(msg_Ardid,1)
           else:
               print("publish")
               print(msg_Ardid)
               client.publish(msg_Ardid,6)
       elif r.text == '{"status":"Invalud card"}':
           print("publish")
           print(msg_Ardid)
           client.publish(msg_Ardid,2)
       elif r.text == '{"status":"Access Denied"}':
           print("publish")
           print(msg_Ardid)
           client.publish(msg_Ardid,3)
       elif r.text == '{"status":"Dont have sufficient balance"}':
            print("publish")
            print(msg_Ardid)
            client.publish(msg_Ardid,4)
       else:
            print("publish")
            print(msg_Ardid)
            client.publish(msg_Ardid,7)

   if msg_Status == "OFF" :
       Hum = msg_Hum
       print(Hum)
       Rid = msg_Raspid
       Aid = msg_Ardid
       Con = msg_Y
       Cid = msg_X
       Temp = msg_Temp
       St = msg_Status
       print(St)
       payload = {'hum': Hum , 'rid': Rid ,'aid': Aid ,'con': Con, 'c_id': Cid ,'temp': Temp,'st': St }
       #r = requests.get('http://192.168.103.220/dashboard/edit_update.php', json=payload)
       r = requests.get('https://ljietproject.000webhostapp.com/ADMS/edit_update.php', json=payload)
       #https://ljietproject.000webhostapp.com/ADMS/edit_update.php
       print("----------------------------------")
       print(r.text)
       print('----------------------------------')
       if r.text == '{"status":"true"}' :
           print(Aid)
           print(Rid)
           last_char = Aid[-1]
           if last_char != "A":
               print("publish")
               print(msg_Ardid)
               client.publish(msg_Ardid,0)
           else:
               print("publish")
               print(msg_Ardid)
               client.publish(msg_Ardid,5)
            #publish
       elif r.text == '{"status":"false"}' :
           print("publish")
           print(msg_Ardid)
           client.publish(msg_Ardid,5)
           #publish
       elif r.text == '{"status":"Invalud card"}':
           print("publish")
           print(msg_Ardid)
           client.publish(msg_Ardid,2)
       else:
            print("publish")
            print(msg_Ardid)
            client.publish(msg_Ardid,7)

#ec2-15-206-127-151.ap-south-1.compute.amazonaws.com
# Change broker_address to match the address of your Pi
# Mine happens to be 192.168.0.200
broker_address = '192.169.0.105'
user = "username"
password = "raspberry"

# Create the MQTT client object
client = mqtt.Client("PYTHONSUB1")

# Set the message callback function
client.on_message = on_message

client.username_pw_set(user, password=password)
# Connect to the MQTT Broker
client.connect(broker_address)



# This is the MQTT Client loop.
# It is used to check for new messages.
# once this loop starts, the main program needs
# to sleep, or do something else
client.loop_start()
# SUbscribe to a topic
client.subscribe('test')

# The main part of the program. This is where
# it can do something else, or just kill time while the
# MQTT client is waiting for messages in the background
# we could publish MQTT messages here if we wnated to
try:
   while True:
      time.sleep(5)

# if the user presses control-c to quit, stop the MQTT loop
except KeyboardInterrupt:
   client.loop_stop()
   pass





#https://ljietproject.000webhostapp.com/Main_file/json_add_data.php
# mosquitto_pub -h 192.168.43.229 -u username -P raspberry -t "ARD001" -m "1"
# mosquitto_pub -h 192.168.0.107 -u username -P raspberry -t "test" -m "OFF 192.168.1.3 ARD001 1 50.00 24.60"
