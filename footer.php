
<div id="footer">

<span class="link"><a href="index.php">Home</a></span>

<?php if(array_key_exists('user', $_SESSION) && $_SESSION['user']->role == 10){ ?>
<span class="link"><a href="admin.php">Admin Panel</a></span>
<?php } ?>

<span class="link"><a href="index.php?page=about">About</a></span>
<span class="link"><a href="index.php?page=contact">Contact Us</a></span>
</div>
