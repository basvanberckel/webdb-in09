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
                        <legend>Settings</legend>

                        <div>
                            <label for='username'><b>Username:</b></label>
                            <input type='text' name='username' id='username' class='txt' readonly='readonly' value=$username />
                        </div>

                        <div>
                            <label for='email'><b>E-mail address:</b></label>
                            <input type='text' name='email' id='email' class='txt' readonly='readonly' value=$email />
                            <button type='button' onclick='editEmail()'  value='edit'>Edit</button>
                        </div>

                        <div>
                            <label for='password'><b>Password:</b></label>
                        </div>
                        
                        <div>
                            <label for='dob'><b>Date of birth:</b></label>
                            <input type='date' name='dob' id='dob' max='2015-01-31' min='1900-01-01' readonly='readonly' class='txt' value=$dob />
                            <button type='button' onclick='editDob()' value='edit'>Edit</button>

                        </div>

                        <div>
                            <label for='sex'><b>Sex:</b></label>
                            <input type='radio' name='sex' value='man' checked>Male
                            <input type='radio' name='sex' value='vrouw' >Female
                            <button type='button' onclick='editSex()' value='edit'>Edit</button>

                        </div> 

                        <div>
                            <label for='bio'><b>Bio:</b></label>
                            <textarea type='text' name='bio' id='bio' readonly='readonly' class='txt'>$bio</textarea>
                            <button type='button' onclick='editBio()' value='edit'>Edit</button>

                        </div>
                    
                    </fieldset>
      
                </form>
                </div>
        ";
    }
        else {
            echo "
                <div class='profile'>
                <form method='POST'>
                    <fieldset>
                        <legend>Settings</legend>

                        <div>
                            <label for='username'><b>Username:</b></label>
                            <input type='text' name='username' id='username' class='txt' readonly='readonly' value=$username />
                        </div>

                        <div>
                            <label for='bio'><b>Bio:</b></label>
                            <textarea type='text' name='bio' id='bio' readonly='readonly' class='txt'>$bio</textarea>
                        </div>
                    
                    </fieldset>
      
                </form>
                </div>
        ";
        }
    }
    
?>

<script>

    function editEmail() {

    }

    function editDob() {

    }

    function editSex() {

    }

    function editBio() {

    }
    
</script>