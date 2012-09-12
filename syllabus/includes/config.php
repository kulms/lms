<?php 

// DATABASE ACCESS INFORMATION [DEFAULT example]
// Modify these values to suit your local settings

$dPconfig['dbtype'] = "mysql";      // ONLY MySQL is supported at present
$dPconfig['dbhost'] = "localhost";
$dPconfig['dbname'] = "dms";
$dPconfig['dbuser'] = "root";
$dPconfig['dbpass'] = "";

// set this value to true to use persistent database connections
$dPconfig['dbpersist'] = false;

// check for legacy password
// ONLY REQUIRED FOR UPGRADES prior to and including version 1.0 alpha 2
$dPconfig['check_legacy_password'] = false;

/*
 Localisation of the host for this dotproject,
 that is, what language will the login screen be in.
*/
$dPconfig['host_locale'] = "en";

// default user interface style
$dPconfig['host_style'] = "default";

// local settings [DEFAULT example WINDOWS]
$dPconfig['root_dir'] = "E:/workshop/dms";  // No trailing slash
$dPconfig['company_name'] = "Maxlearn DMS Module";
$dPconfig['page_title'] = "Document management system for dissertation and research publication";
$dPconfig['base_url'] = "http://localhost/dms";
//$dPconfig['site_domain'] = "dotproject.net";

// enable if you want to be able to see other users's tasks
$dPconfig['show_all_tasks'] = false;

// enable if you want to log changes using the history module
$dPconfig['log_changes'] = false;

// enable if you want to check task's start and end dates
// disable if you want to be able to leave start or end dates empty
$dPconfig['check_tasks_dates'] = true;

// warn when a translation is not found (for developers and tranlators)
$dPconfig['locale_warn'] = false;

// the string appended to untranslated string or unfound keys
$dPconfig['locale_alert'] = '^';

// set debug = true to help analyse errors
$dPconfig['debug'] = false;

//File parsers to return indexing information about uploaded files
$ft["default"] = "/usr/bin/strings";
$ft["application/msword"] = "/usr/bin/strings";
$ft["text/html"] = "/usr/bin/strings";
$ft["application/pdf"] = "/usr/bin/pdftotext";
?>