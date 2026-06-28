# CSP Cisco Web Provisioning Server
A Web Provisioning Server that will let you make Cisco 7800/8800 on enterprise firmware on 3rd party SIP Servers

***
## Requirements/Prerequisites:
- Windows ISS with CGI and PHP Installed (recommended; Other web servers that support PHP and allow you to change the port to 6970 will also work)
- Asterisk Server with the Chan_SIP Protocol (PJSIP WILL NOT WORK)

***
## Getting Started
1. Open up the directory that you want the provisioning server files to be on and open it in Windows PowerShell and run ``git clone https://github.com/csptechnologies/ciscoprovsionerweb``
2. Exit out of PowerShell and open up the template.xml file in a code editor
3. Replace "SERVERIP" in all locations with your Asterisk server's IP. If your SIP Server port is not 5160, in the file, change 5160 to the SIP Port
4. Open up IIS Manager and make a new site that goes to the repository you just cloned
   - MAKE SURE THE PROTOCOL IS HTTP
   - Set the port to 6970
5. Hit Save and go to http://localhost:6970/provision.php, and the default user and password are admin

NOTE: When setting the time zone, it must be in the format of {timezone name} Standard/Daylight Time. Of course, do not include periods or braces.

You may also change the <displayOnTime>, <displayOnDuration>, and <displayIdleTimeout> settings. The first needs to be in 24h time, the second is how many hours it's on, and the same for the third. (Ex. on at 07:00 for 16:00 idle time of 00:01)
 
