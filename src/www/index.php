<?php
// CDM index

// session
session_start();
require_once('m/db.php');

// variables
$_SESSION['page_title'] = 'Overview';

// view
require_once('v/header.php');

$sth = $db->query('select name from cdm.language;');
foreach ($sth->fetchAll() as $pos) {
	echo $pos['name']."\n";
}

require_once('v/footer.php');
