<?php
require_once 'meekrodb.2.1.class.php';
DB::$user = 'root';
DB::$password = 'thames2215';
DB::$dbName = 'redmine_default';

// ## Daily Resolved Issues
$results = DB::queryFirstField("SELECT count(*) FROM redmine_default.journals AS j,redmine_default.journal_details AS jd, redmine_default.users AS u, redmine_default.issue_statuses AS st WHERE j.id=jd.journal_id AND j.user_id=u.id AND prop_key='status_id' AND jd.value=st.id AND DATE(j.created_on) = DATE(NOW()) AND jd.value=3 AND (u.id=6 OR u.id=16 OR u.id=34)");

echo "Daily Resolved Issues: $results\n";

$return_message_array="";
$return_number="";

$str = '{"value": '.$results.'}';
$curly = "/usr/bin/curl -v -u IXqrll3ck2LEWvTbjnQamqW2wMW1DTRvJhaaOmLUpfa8sRvue8:x -d '".$str."' https://push.ducksboard.com/v/87980";
//echo $curly."\n";
exec( $curly, $return_message_array, $return_number );  

echo "Return msg [$return_message_array] Return #[$return_number]\n";


// ## Total Open Issues
$results = DB::queryFirstField("SELECT count(*) FROM redmine_default.issues WHERE (status_id=1 OR status_id=2 OR status_id=4 OR status_id=8 OR status_id=9) AND (assigned_to_id=6 OR assigned_to_id=16 OR assigned_to_id=34);");

echo "Total Open Issues: $results\n";
$str = '{"value": '.$results.'}';
$curly = "/usr/bin/curl -v -u IXqrll3ck2LEWvTbjnQamqW2wMW1DTRvJhaaOmLUpfa8sRvue8:x -d '".$str."' https://push.ducksboard.com/v/87965";
//echo $curly."\n";
exec( $curly, $return_message_array, $return_number );

echo "Return msg [$return_message_array] Return #[$return_number]\n";

