<?php
    $uid = $_GET['uid'];

    $email2 = $_POST['email'];
    $dob2 = $_POST['dob'];
    $bio2 = $_POST['bio'];
    $res2 = dbquery("UPDATE users
                     SET email = :email,
                         dob = :dob,
                         bio = :bio
                     WHERE uid = :uid",
            array('uid' => $uid,
                  'email' => $email2,
                  'dob' => $dob2,
                  'bio' => $bio2));
?>