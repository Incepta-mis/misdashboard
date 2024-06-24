<?php
/**
 * Created by PhpStorm.
 * Time: 3:00 PM
 */
?>
<html>
<body>
Dear Sir/Madam,<br><br>

There is a new proposal of a scientific seminar in the MIS system awaiting for your kind observation and suggestions if any.  <br>
<br>
Proposal No : {{ $data_mail[0]->prog_no }}<br>
Region : {{ $data_mail[0]->rm_terr_id }}<br>
Institution/Association/Doctor: {{ $data_mail[0]->program_details }}<br>
Team : {{ $data_mail[0]->prog_team }}<br>
Product(s) : {{ $data_mail[0]->brand_name }}<br>
Program Date : {{ $data_mail[0]->prog_date_time }}<br>

<br>
This link is for office network
http://web.inceptapharma.com:5031/misdashboard/scientific/seminar_proposal<br>
<br>
This link is for outside office network
http://web.inceptapharma.com:5031/misdashboard/scientific/seminar_proposal<br>
<br>
<br>
Thank you.
</body>
</html>




