<?php
    dbconnect();
    $uid = $_GET['uid'];

    /* Updates the database*/
    if (isset($_POST['submit'])) {
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
    }

    /* Loads from database*/
    $res = dbquery("SELECT * FROM users WHERE uid = :uid",
                  array('uid'=>$uid));

    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
        $email = $row['email'];
        $dob = $row['dob'];
        $passwd = $row['passwd'];
        $sex = $row['sex'];
        $bio = $row['bio'];

    
        if (array_key_exists('user', $_SESSION) && $_SESSION['user']->uid == $_GET['uid']) {
            if (isset($_POST['edit'])) {
            
?>
                <!-- This shows if the user is logged in and pressed Edit -->
                <div class='profile'>
                <form method="post">
                    <fieldset>
                        <legend>Account Details</legend>

                        <div>
                            <label for='username'><b>Username:</b></label>
                            <?php echo $username; ?>
                        </div>

                        <div>
                            <label for='email'><b>E-mail address:</b></label>
                            <input name='email' type='text' id='email' class='txt' value=<?php echo $email; ?> />
                        </div>

                        <div>
                            <label for='password'><b>Password:</b></label>
                            <?php echo '<a href="?page=changepassword&uid=' . $_SESSION['user']->uid .'">' . 'Change password' . '</a>' ;?>
                        </div>
                        
                        <div>
                            <label for='dob'><b>Date of birth:</b></label>
                            <input type='date' name='dob' id='dob' max='2015-01-31' min='1900-01-01' class='txt' value=<?php echo $dob; ?> />

                        </div>

                        <div>
                            <label for='sex'><b>Sex:</b></label>
                            <?php
                            if ($sex == 'm') {echo 'Male';}
                            else {echo 'Female';}
                            ?>
                        </div> 

                        <div>
                            <label for='bio'><b>Bio:</b></label>
                            <textarea type='text' name='bio' id='bio' class='txt'><?php echo $bio; ?></textarea>
                        </div>
                        <div class="buttons">
                        <button name="submit" type='submit'>Apply all changes</button>
                    </div>  
                    </fieldset>
                </form>
                </div>
        <?php
            }
            else {
                ?>

                <!-- This shows if the user is logged in-->
                <div class='profile'>
                <form method="post">
                    <fieldset>
                        <legend>Account Details</legend>

                        <div>
                            <label for='username'><b>Username:</b></label>
                            <?php echo $username; ?>
                        </div>

                        <div>
                            <label for='email'><b>E-mail address:</b></label>
                            <?php echo $email; ?>
                        </div>

                        <div>
                            <label for='password'><b>Password:</b></label>
                            <?php echo '<a href="?page=changepassword&uid=' . $_SESSION['user']->uid .'">' . 'Change password' . '</a>' ;?>
                        </div>
                        
                        <div>
                            <label for='dob'><b>Date of birth:</b></label>
                            <?php echo $dob; ?>

                        </div>

                        <div>
                            <label for='sex'><b>Sex:</b></label>
                            <?php
                            if ($sex == 'm') {echo 'Male';}
                            else {echo 'Female';}
                            ?>
                        </div> 

                        <div>
                            <label for='bio'><b>Bio:</b></label>
                            <div class="bio"><?php echo $bio; ?> </div>
                        </div>  
                     <div class="buttons">
                        <button name="edit" type='submit'>Edit</button>
                    </div>
                    </fieldset>

                </form>
                </div>
            <?php
            } 
        }
        else {
            ?>
                <!-- This shows if the user is viewing another profile-->
                <div class='profile'>
                <form method='POST'>
                    <fieldset>
                        <legend><?php echo $username; ?></legend>

                        <div>
                            <label for='username'><b>Username:</b></label>
                            <?php echo $username ?>
                        </div>

                        <div>
                            <label for='bio'><b>Bio:</b></label>
                            <div class="bio"><?php echo $bio; ?> </div>
                        </div>
                    
                    </fieldset>
                </form>
                </div>
        <?php
        }
    }
?>