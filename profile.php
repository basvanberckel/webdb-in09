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
                            <button id='emailb' type='button' onclick='editEmail()'  value='edit'>Edit</button>
                        </div>

                        <div>
                            <label for='password'><b>Password:</b></label>
                            <a href='thing'>Change password</a>
                        </div>
                        
                        <div>
                            <label for='dob'><b>Date of birth:</b></label>
                            <input type='date' name='dob' id='dob' max='2015-01-31' min='1900-01-01' readonly='readonly' class='txt' value=$dob />
                            <button id='dobb' type='button' onclick='editDob()' value='edit'>Edit</button>

                        </div>

                        <div>
                            <label for='sex'><b>Sex:</b></label>
                            if ($sex == m) {echo 'Male'}
                            else {echo 'Female'}

                        </div> 

                        <div>
                            <label for='bio'><b>Bio:</b></label>
                            <textarea type='text' name='bio' id='bio' readonly='readonly' class='txt'>$bio</textarea>
                            <button id='biob' type='button' onclick='editBio()' value='edit'>Edit</button>

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
        var elem = document.getElementById("emailb");
        if (elem.value=="Edit") { 
            elem.removeAttribute('readonly'); 
            elem.value = "Save";
        }
        else {
            elem.setAttribute("readonly", "readonly")
            elem.value = "Edit";
        }
    }

    function editDob() {
        var elem = document.getElementById("dobb");
        if (elem.value=="Edit") { 
            elem.removeAttribute('readonly'); 
            elem.value = "Save";
        }
        else {
            elem.setAttribute("readonly", "readonly")
            elem.value = "Edit";
        }
    }

    function editBio() {
        var elem = document.getElementById("biob");
        if (elem.value=="Edit") { 
            elem.removeAttribute('readonly'); 
            elem.value = "Save";
        }
        else {
            elem.setAttribute("readonly", "readonly")
            elem.value = "Edit";
        }
    }
</script>