#Pay Date Csv Generator Script

This is a bash script that I made for a practical test which generate a csv file with this business logic:
- Basic pay is paid on the last working day of the month (Mon-Fri). So if the last day of January is the 31st, and this is a Saturday, the payment date is Friday the 30th. The same logic applies to Sunday.
- On the 12th of every month bonuses are paid for the previous month, unless that day is a weekend. In that case, they are paid the first Tuesday after the 12th
Install: run composer install

The code is compatible with phpmd and phpcs with psr2 coding standard. 

Configurations are into payDatesGeneratorScript.php file.

Run <code>$ php payDatesGeneratorScript.php --help</code> for more information