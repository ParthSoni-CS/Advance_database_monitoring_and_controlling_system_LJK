# Advance_database_monitoring_and_controlling_system_LJK

### Credentials: Parth Vijaykumar Soni(parthsoni08072000@gmail.com) , Nitya Pragneshbhai Parikh(nityaparikh2@gmail.com)

#### This project is based upon controlling and monitoring the system which allows user to control the system from any corner of the world through webportal. 


## Features

  ### User Features
  1) Users can operate device using RFID cards allocated to them on the bases of their role in LJK organization.
  2) Each user is provided by an unique card having prepaid balance of hours. After completion of the balance user need to contact admin for recharge it again. 
  3) User can operate device from webportal hosted over internet (http://adms.ljinstitutes.org/) by logging in using proper credentials provided to them by superuser(i.e Administrator), in case if they forgot their cards.
  4) In webportal(http://adms.ljinstitutes.org/) user can only monitor and control specific building of organization on the bases of their role.
  5) Locking and unlocking of a individual system or of a building in which systems are installed can also done via user from webportal.
  6) User can moniter system's various entities, like if a system is an Air Conditioner, user can monitor it's temperature, humidity and power consumption.
  7) Users need not to search for A.C's remote, as the device is supplied with IR sensor.
  
  ### Administrator Features
  1) The administrator have the crendential to control all the buildings.
  2) Admin also possess control to recharge the user's hours using webportal.
  3) Admin has right to block the user or change the user role in the handling of devices.
  4) He/She can also lock/unlock whole building or an individual room.
  5) An Administrator also possess the credentials for c-panel for changing the code or database
  6) Administartor role can be played by only one faculty of L.J institutes of engineering and technology. However, c-panel's credentials are only provided to the webportal engineers who can handels technical functions of it. 
  7) Admin can also generate report for an individual room's consumption, temperature and humidity in the form of pdf, excel or can print directly.

## Working Flow 

### We used this device to control two A.C., both of them share common device 


1) When the device is turned on, at the very first moment it will try to connect with broker server.
2) If it connects to the sever a long buzz sound will be played to indicate the user about the connection, else it will retry every five seconds.

3) User with his/her unique card provided by admin, in order to operate the device tap on the surface of it.


4) After Scanning the card, the credentials of the user along with necessary information of device(i.e. status of device, device id, it's IP address, and broker IP address) is send by the device to a broker server via ethernet.

5) This communication between device and broker server is interfaced by mqtt publish-subscribe functionality.

6) The device publish a message on a topic which is subscribed by the various clients on the side of the broker and vice versa.

7) Broker decodes the message received from device and send it to the main server hosted over the internet.

8) Main server receives the request and check for user authentication and other details of device such as status of device(on/off , lock/unlock), available hours for user.

9) Server then revert back with following response:
            1) True = If user is validated and everything match with conditions on server side.
            2) False = If device is not found 
            3) Access denied = 
            4) Communication error = If the card is not validated 
            5) Invalid card = If card id of user is not match with 

10) If the received response from server is "True" then broker sends the payload to the device to turn on the first A.C. via mqtt protocols.

11) Device works as per the payload. 

12) Payload consists of single integer value each of them represents the following: 
            1) 0: 
            2) 1:
            3) 2:
            4) 3:
            5) 4:
            6) 7:

13) After first A.C. turned on, to switch on the second ac user need to press a toggle button, provided on the side of rectangular device.

14) Second A.C. will only turn on if and only if first A.C. is on, if first A.C. is not on then pressing the side button will not make any impact.

15) To turn "on" the A.C. 2 card number of user is required, but, as the user already scanned the card at the first time while turning "on" first A.C., the card number is now saved in the device and hence for this reason the device will send card number for the second A.C. implicitly.

16) So, now when the button is pressed the same message which was send for first A.C. is now send for second A.C. to broker via mqtt interfacing.

17) Like wise the broker will send the message to the server and sever will response with the same message as mentioned in point number 9.

18) 




   
