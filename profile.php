<h1>Account Details</h1>
<?php
    dbconnect();
    $uid = $_GET['uid'];

    $res = dbquery("SELECT * FROM users WHERE uid = :uid",
                  array('uid'=>$uid));
    

    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
        $email = $row['email'];
        $dob = $row['dob'];
        $passwd = $row['passwd'];
        $sex = $row['sex'];
        $bio = $row['bio'];
    
    
        if ($_SESSION['user']->uid == $_GET['uid']) {
        
            echo "
                <div class='profile'>
                <form method='POST'>
                    <fieldset>
                        <legend>Credentials</legend>

                        <div>
                            <label for='username'><b>Username:</b></label>
                            <input type='text' name='username' id='username' class='txt' value=$username />
                        </div>

                        <div>
                            <label for='email'><b>E-mail address:</b></label>
                            <input type='text' name='email' id='email' class='txt' value=$email />
                        </div>

                        <div>
                            <label for='password'><b>Password:</b></label>
                            <input type='password' name='password' id='password' class='txt' value=$passwd />
                        </div>

                    </fieldset>
                    </div>

                <div class='profile'>
                    <fieldset>
                        <legend>Settings</legend>
                    
                        <div>
                            <label for='dob'><b>Date of birth:</b></label>
                            <input type='date' name='dob' id='dob' max='2015-01-31' min='1900-01-01' class='txt' value=$dob />
                        </div>

                        <div>
                            <label for='sex'><b>Sex:</b></label>
                            <input type='radio' name='sex' value='man' checked>Male
                            <input type='radio' name='sex' value='vrouw' >Female
                        </div> 

                        <div>
                            <label for='bio'><b>Bio:</b></label>
                            <textarea type='text' name='bio' id='bio' class='txt' value=$bio></textarea>
                        </div>
                    
                    </fieldset>

                <div class='center'>
                    <div class='buttons'>
                        <button type='submit' class='small' value='Edit'>Edit</button>
                        <button type='reset' class='small' value='Save'>Save</button>
                    </div>
                </div>
                </form>
            </div>
        ";
    }
    }
    
?>