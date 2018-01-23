Author's Note:
--------------
BEFORE USING ANY CODE IN THESE SCRIPTS, READ THROUGH ALL FILES THOROUGHLY, UNDERSTAND WHAT THE SCRIPTS ARE DOING AND TEST THEIR BEHAVIOR IN AN ISOLATED ENVIRONMENT.  RESEARCH ANY POTENTIAL BUGS IN THE VERSION OF THE SOFTWARE YOU ARE USING THESE SCRIPTS WITH AND UNDERSTAND THAT FEATURE SETS OFTEN CHANGE FROM VERSION TO VERSION OF ANY PLATFORM WHICH MAY DEPRECATE CERTAIN PARTS OF THIS CODE.  ANY INDIVIDUAL CHARGED WITH RESPONSIBILITY IN THE MANAGEMENT OF A SYSTEM RUNS THE RISK OF CAUSING SERVICE DISRUPTIONS AND/OR DATA LOSS WHEN THEY MAKE ANY CHANGES AND SHOULD TAKE THIS DUTY SERIOUSLY AND ALWAYS USE CAUTION.  THIS CODE IS PROVIDED WITHOUT ANY WARRANTY WHATSOEVER AND IS INTENDED FOR EDUCATIONAL PURPOSES.  

Cisco Unified Communications getFileList Script
=========================================================
This script was written to address certain challenges in managing Cisco phones in a Cisco Unified Communications (CUCM) environment.  

Many environments that use CUCM purchase third party solutions for Call Detail Record storage.  A programmer, however, can write an application to pull cdr files from a CUCM server, insert the data into a local database, and manipulate that information as needed.  There are two AXL functions that accomodate this process; get_file_list and get_file.  To make things even more interesting, Cisco is deprecating the soap RPC style in favor of the docs/literal format as of CUCM 11.  So, if you're building a program to leverage AXL, you should go straight to the docs/literal style.  If you're using RPC, review the following Cisco WSDL information page for more information; http://solutionpartnerdashboard.cisco.com/web/sxml-developer/get-wsdl .

In any case, the getFileList.php script includes both styles to give an example of the differences and how to pull this information from CUCM.  You would just need to comment out the components needed from one style while uncommenting the ones that you need ($soapClient, $data, and the respective array iteration structures - see annotations in the script for details).  The functions themselves differ between styles, so adjust as necessary.

The script includes parameters to search for files generated on August 26th, 2016 at 0700 to 0759 hours UTC (201608260700 to 201608260759).  This has been included to illustrate the format CUCM expects the beginning and ending timestamps to be in.

The script include some bells and whistles that can be useful.  Because CDR files are timestamped with the Universal Time Coordinated (UTC) format, the script will adjust UTC to Arizona time and display both zones (obviously, change this to whatever suits you as you test).  

Tested on:
----------
* Debian 7
* PHP 5
* CUCM 10.5
* Cisco AXL Toolkit (specifically, the AXLAPI.wsdl file)
* An application user account on CUCM with the following privileges
  * Standard CCM Admin Users
  * Standard CCMADMIN Read Only
  * Standard Serviceability Read Only
