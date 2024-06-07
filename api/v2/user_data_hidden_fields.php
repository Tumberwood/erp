<?php
if(count(get_included_files()) ==1) die(); //Direct Access Not Permitted
$hiddenFields = [
  'id',
  'password',
  'permissions',
  'pin',
  'email_verified',
  'vericode',
  'vericode_expiry',
  'oauth_provider',
  'oauth_uid',
  'gpluslink',
  'account_owner',
  'account_id',
  'account_mgr',
  'fb_uid',
  'created',
  'protected',
  'dev_user',
  'cloak_allowed',
  'logins',
  'last_login',
  'join_date',
  'modified',
  'active',
//the ones below are for plugins that are already in the wild
  'ldap',
  'plg_mem_level',
  'plg_mem_cost',
  'plg_mem_cred',
  'plg_mem_exp',
  'plg_mem_expired',
  'plg_points',
  'plg_steam_id',
  'plg_steam_un',
  'plg_steam_avatar',
  'last_watchdog',
  'last_page', //watchdog
];


$usplugins = parse_ini_file($abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php', true);
foreach ($usplugins as $k => $v) {
  if ($v == 1) {
    if (file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$k.'/api_fields.php')) {
      include $abs_us_root.$us_url_root.'usersc/plugins/'.$k.'/api_fields.php';
    }
  }
}
