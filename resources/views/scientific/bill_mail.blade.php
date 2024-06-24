<?php
/**
 * Created by PhpStorm.
 * Time: 3:00 PM
 */
?>
<html>
<body>
Dear Sir/Madam,<br>

There is a new scientific seminar proposal/bill in the MIS system await for your approval.<br>
<br>
Bill No - {{ $data_mail[0]->bill_no }}<br>
RM - {{ $data_mail[0]->rm_name }}<br>
Region - {{ $data_mail[0]->rm_terr_id }}<br>
Location - {{ $data_mail[0]->program_venue }}<br>
Team - {{ $data_mail[0]->prog_team }}<br>
<br>
This link is for office network
http://web.inceptapharma.com:5031/misdashboard/scientific/seminar_bill<br>
<br>
This link is for outside office network
http://web.inceptapharma.com:5031/misdashboard/scientific/seminar_bill<br>
<br>
<br>
Thank you.
</body>
</html>