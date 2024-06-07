<?php
$emailQ = $db->query('SELECT * FROM email');
$emailR = $emailQ->first();

$userId = $userdetails->id;

$validation = new Validate();

$displayname = $input['username'];
if ($userdetails->username != $displayname && ($settings->change_un == 1 || (($settings->change_un == 2) && ($user->data()->un_changed == 0)))) {
  $fields = [
    'username' => $displayname,
    'un_changed' => 1,
  ];
  $validation->check($input, [
    'username' => [
      'display' => lang('GEN_UNAME'),
      'required' => true,
      'unique_update' => 'users,'.$userId,
      'min' => $settings->min_un,
      'max' => $settings->max_un,
    ],
  ]);

  if ($validation->passed()) {
    if (($settings->change_un == 2) && ($user->data()->un_changed == 1)) {
      $msg = lang('REDIR_UN_ONCE');
      $validation->addError($msg);
    }else{
      $db->update('users', $userId, $fields);
      $successes[] = lang('GEN_UNAME').' '.lang('GEN_UPDATED');
      logger($auth['user_id'], 'User', "Changed username from $userdetails->username to $displayname.");
    }

  } else {
    //validation did not pass
    foreach ($validation->errors() as $error) {
      $errors[] = $error;
    }
  }
}elseif($settings->change_un == 0 && $input['username'] != $userdetails->username){
  $msg = lang("SET_NOCHANGE");
  $validation->addError($msg);
}

//Update first name
$fname = $input['fname'];
if ($userdetails->fname != $fname) {
  $fields = ['fname' => $fname];
  $validation->check($input, [
    'fname' => [
      'display' => lang('GEN_FNAME'),
      'required' => true,
      'min' => 1,
      'max' => 60,
    ],
  ]);
  if ($validation->passed()) {
    $db->update('users', $userId, $fields);
    $successes[] = lang('GEN_FNAME').' '.lang('GEN_UPDATED');
    logger($auth['user_id'], 'User', "Changed fname from $userdetails->fname to $fname.");
  } else {
    //validation did not pass
    foreach ($validation->errors() as $error) {
      $errors[] = $error;
    }
  }
}
//Update last name
$lname = $input['lname'];
if ($userdetails->lname != $lname) {
  $fields = ['lname' => $lname];
  $validation->check($input, [
    'lname' => [
      'display' => lang('GEN_LNAME'),
      'required' => true,
      'min' => 1,
      'max' => 60,
    ],
  ]);
  if ($validation->passed()) {
    $db->update('users', $userId, $fields);
    $successes[] = lang('GEN_LNAME').' '.lang('GEN_UPDATED');
    logger($auth['user_id'], 'User', "Changed lname from $userdetails->lname to $lname.");
  } else {
    //validation did not pass
    foreach ($validation->errors() as $error) {
      $errors[] = $error;
    }
  }
}

$email = $input['email'];
if ($userdetails->email != $email) {
  $fields = ['email' => $email];
  $validation->check($input, [
    'email' => [
      'display' => lang('GEN_EMAIL'),
      'required' => true,
      'valid_email' => true,
      'unique_update' => 'users,'.$userId,
      'min' => 5,
      'max' => 100,
    ],
  ]);

  if ($validation->passed()) {
    if ($emailR->email_act == 0) {
      $db->update('users', $userId, $fields);
      $successes[] = lang('GEN_EMAIL').' '.lang('GEN_UPDATED');
      logger($auth['user_id'], 'User', "Changed email from $userdetails->email to $email.");
    }
    if ($emailR->email_act == 1) {
      $vericode = randomstring(15);
      $vericode_expiry = date('Y-m-d H:i:s', strtotime("+$settings->join_vericode_expiry hours", strtotime(date('Y-m-d H:i:s'))));
      $db->update('users', $userId, ['email_new' => $email, 'vericode' => $vericode, 'vericode_expiry' => $vericode_expiry]);
      //Send the email
      $options = [
        'fname' => $userdetails->fname,
        'email' => rawurlencode($userdetails->email),
        'vericode' => $vericode,
        'join_vericode_expiry' => $settings->join_vericode_expiry,
      ];
      $encoded_email = rawurlencode($email);
      $subject = lang('EML_VER');
      $body = email_body('_email_template_verify_new.php', $options);
      $email_sent = email($email, $subject, $body);
      if (!$email_sent) {
        $errors[] = lang('ERR_EMAIL');
      } else {
        $successes[] = lang('EML_CHK').' '.$settings->join_vericode_expiry.' '.lang('T_HOURS');
      }
      if ($emailR->email_act == 1) {
        logger($auth['user_id'], 'User', "Requested change email from $userdetails->email to $email. Verification email sent.");
      }
    }

  } else {
    //validation did not pass
    foreach ($validation->errors() as $error) {
      $errors[] = $error;
    }
  }
}

if(isset($input['pwd'])){
  $password = $input['pwd'];
  $validation->check($input, [
    'pwd' => [
      'display' => lang('PW_NEW'),
      'required' => true,
      'min' => $settings->min_pw,
      'max' => $settings->max_pw,
    ],

  ]);
  foreach ($validation->errors() as $error) {
    $errors[] = $error;
  }
  if (empty($errors)) {
    //process
    $new_password_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    $db->update('users', $auth['user_id'],['password' => $new_password_hash, 'force_pr' => 0, 'vericode' => randomstring(15)]);
    $successes[] = lang('PW_UPD');
    logger($auth['user_id'], 'User', 'Updated password.');
    if ($settings->session_manager == 1) {
      $passwordResetKillSessions = passwordResetKillSessions();
      if (is_numeric($passwordResetKillSessions)) {
        if ($passwordResetKillSessions == 1) {
          $successes[] = lang('SESS_SUC').' 1 '.lang('GEN_SESSION');
        }
        if ($passwordResetKillSessions > 1) {
          $successes[] = lang('SESS_SUC').$passwordResetKillSessions.lang('GEN_SESSIONS');
        }
      } else {
        $errors[] = lang('ERR_FAIL_ACT').$passwordResetKillSessions;
      }
    }
  }
}
