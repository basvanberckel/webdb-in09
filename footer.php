
<div id="footer">

<span class="link"><a href="index.php">Home</a></span>

<?php if(array_key_exists('user', $_SESSION) && $_SESSION['user']->role == 10){ ?>
<span class="link"><a href="/admin">Admin panel</a></span>
<?php } ?>

<span class="link"><a href="index.php?page=about">About</a></span>
<span class="link"><a href="index.php?page=contact">Contact</a></span>
</div>
