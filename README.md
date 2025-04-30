# CSP Cisco Web Provisioning Server
A Web Provisioning Server that will let you make Cisco 7800/8800 on enterprise firmware on 3rd party SIP Servers

***
## Requirements/Prerequisites:
- Windows ISS with CGI and PHP Installed (if you need help, look at the wiki)
- Asterisk Server with the Chan_SIP Protocol (PJSIP WILL NOT WORK)

***
## Getting Started
1. Open up the directory that you want the provisioning server files to be on and open it in windows powershell and run ``git clone https://github.com/csptechnologies/ciscoprovsionerweb``
2. Exit out of powershell and open up IIS Manager
3. Open up IIS Manager and make a new site that goes to the repository you just cloned
   - MAKE SURE THE PROTOCOL IS HTTP
   - Set the port to 6970
4. Hit Save and go to http://localhost:6970/provision.php and the default user and password is admin
