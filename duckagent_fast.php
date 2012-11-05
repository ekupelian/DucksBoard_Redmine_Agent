<?php

require_once 'config.php';

// ## Daily Resolved Issues ##
$results = DB::queryFirstRow("SELECT count(*) as value FROM redmine_default.journals AS j,redmine_default.journal_details AS jd, redmine_default.users AS u, redmine_default.issue_statuses AS st WHERE j.id=jd.journal_id AND j.user_id=u.id AND prop_key='status_id' AND jd.value=st.id AND DATE(j.created_on) = DATE(NOW()) AND jd.value=3 AND (u.id=6 OR u.id=16 OR u.id=34)");
Log::e("Daily Resolved Issues: ".$results["value"], Log::DEBUG_FLAG);

if(!$fCache->check("dri.cache", $results["value"])) {
	$daily_resolved_issues = new ducksboardPush("dri", $results);
	if ($daily_resolved_issues->errno) Log::e("Connection ERROR #".$daily_resolved_issues->errno."->".$daily_resolved_issues->errordesc);
}

// ## Total Open Issues ##
$results = DB::queryFirstRow("SELECT count(*) as value FROM redmine_default.issues WHERE (status_id=1 OR status_id=2 OR status_id=4 OR status_id=8 OR status_id=9) AND (assigned_to_id=6 OR assigned_to_id=16 OR assigned_to_id=34);");
Log::e("Total Open Issues: ".$results["value"], Log::DEBUG_FLAG);

if(!$fCache->check("toi.cache", $results["value"])) {
	$total_open_issues = new ducksboardPush("toi", $results);
	if ($total_open_issues->errno) Log::e("Connection ERROR #".$total_open_issues->errno."->".$total_open_issues->errordesc);
}

// ## Daily Leaderboard ##
$results = DB::query("SELECT CONCAT(u.firstname, ' ', u.lastname) as name, count(distinct journalized_id) as resolved, CASE WHEN count(distinct journalized_id) >= 2 AND count(distinct journalized_id) <=3 THEN 'low' WHEN count(distinct journalized_id) >= 4 THEN 'green' ELSE 'red' END as status FROM redmine_default.journals AS j,redmine_default.journal_details AS jd, redmine_default.users AS u, redmine_default.issue_statuses AS st WHERE j.id=jd.journal_id AND j.user_id=u.id AND prop_key='status_id' AND jd.value=st.id AND DATE(j.created_on) = DATE(NOW()) AND jd.value=3 AND (u.id=6 OR u.id=16 OR u.id=34) GROUP BY u.id ORDER BY resolved DESC;");
//$results = DB::query("SELECT CONCAT(u.firstname, ' ', u.lastname) as name, count(distinct journalized_id) as resolved, CASE WHEN count(distinct journalized_id) >= 2 AND count(distinct journalized_id) <=3 THEN 'low' WHEN count(distinct journalized_id) >= 4 THEN 'green' ELSE 'red' END as status FROM redmine_default.journals AS j,redmine_default.journal_details AS jd, redmine_default.users AS u, redmine_default.issue_statuses AS st WHERE j.id=jd.journal_id AND j.user_id=u.id AND prop_key='status_id' AND jd.value=st.id AND jd.value=3 AND (u.id=6 OR u.id=16 OR u.id=34) GROUP BY u.id ORDER BY resolved DESC;");
Log::e("Daily Leaderboard: ".$results, Log::DEBUG_FLAG);

// # Merge arrays to have records for ppl not listed in the query
$results = $results + $base_arr;

// # Transform "resolved" key into "values" (MySQL reserved word -.-)
$i=0;
foreach($results as $arr) {
	$results[$i]['values'] = $arrayName = array($results[$i]['resolved']);
	unset($results[$i]['resolved']);
	$i++;
}
$board = array('board' => $results);
$value = array('value' => $board);

if(!$fCache->check("dailyl.cache", $value)) {
	$dailyl_issues = new ducksboardPush("dailyl", $value);
	if ($dailyl_issues->errno) Log::e("Connection ERROR #".$dailyl_issues->errno."->".$dailyl_issues->errordesc);
}

