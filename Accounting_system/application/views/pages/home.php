<?= $title ?>
    <a href="Pages/login">Login</a>

    <a href="Pages/logout">logout</a>


    <form method="POST" action="<?php echo site_url('Pages/register'); ?>">

        <label>Username</label>
        <input type="text" class="form-control" name="username" placeholder="Enter username">
        <label>Password</label>
        <input type="text" class="form-control" name="password" placeholder="Enter password">

       <input type="submit" name="save" value="Save data" id="">

    </form>
