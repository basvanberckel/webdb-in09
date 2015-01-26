<div class="content" id="users">

<?php
$res = dbquery("SELECT * FROM users WHERE 1 ORDER BY username");
while ($user = $res->fetchObject()) {
  echo "<a href='/?page=profile?uid={$user->uid}'>
          <div class='user'>
            <p>{$user->username}</p>
            <form>
              <input type='checkbox' name='verified' />
              <input type='text' name='role' cols='2' />
            </form>
          </div>
        </a>";
}
?>
