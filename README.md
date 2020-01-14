## Contao Forum Bridge Bundle
Allows the Contao member system to work with phpBB.

## Requirements
1. phpBB has to share a database with the Contao site.
2. The two sites need to be located on the same server.
3. The two sites need to be located under the same top-level domain (but can be on different subdomains).

## Setup
1. Install the Contao Forum Bridge Bundle into Contao.
2. Install the Contao Bridge phpBB extension into phpBB.
3. Contao CMS and phpBB will now be able to communicate.

## Configuration
Once the module is installed, go to Contao's 'Settings' and set the following options:

| Option                | Description                                                                                     |
|-----------------------|-------------------------------------------------------------------------------------------------|
| **Enabled**           | Whether or not the forum bridge is active.                                                      |
| **CMS/Forum Domain**  | Enter a key here to secure requests to the forum. The same key needs to be entered into phpbb.  |
| **CMS/Forum Domain**  | Whether or not the forum bridge is active.                                                      |
| **Forum URL**         | The URL under which the forum is located. E.g. https://forum.mysite.com                         |
| **Register page**     | The Contao page where the registration module is placed.                                        |
| **Login page**        | The Contao page where the login module is placed.                                               |
| **Log out page**      | The Contao page where the logout module is placed.                                              |
| **Account page**      | The Contao page where the account module is placed.                                             |

## Overview
All account management (including registration, login and logout) is handled by Contao. Once logged into Contao, 
members will automatically be logged into phpBB upon visiting the forum.

### Members
When members are added to Contao they are automatically mirrored in phpBB so each member account
in Contao has a corresponding user account in phpBB. You can manually assign Contao members to
specific phpBB users using the 'phpBB Account' field on the 'Add/edit Member' form in Contao.

### Groups
Contao groups can be associated with phpBB groups. To do so, edit a Contao 'Member Group' and select
the name of the corresponding phpBB user group from the 'phpBB Group' field.