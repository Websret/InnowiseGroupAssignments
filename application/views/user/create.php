<div class="row justify-content-center">
    <div class="col-4 align-items-center" >
        <H1>Add user page</H1>

        <?php if (isset($_SESSION["message"])) : ?>
            <p class="errorMessage"><?php echo $_SESSION["message"]; ?></p>
            <?php unset($_SESSION["message"]); ?>
        <?php endif; ?>

        <form action="/user/add" method="post">
            <p>Email</p>
            <p>
                <input type="text" name="email" id="email" required>
                <span id="valid"></span>
            </p>
            <p>Your first and last name</p>
            <p>
                <input type="text" name="name" id="name" required>
                <span id="nameValid"></span>
            </p>
            <p><select name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select></p>
            <p><select name="status" >
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select></p>
            <p><button type="submit" id="validate" disabled>Send</button></p>
        </form>
        <a href="/"><button type="button" class="btn btn-danger">Back page</button></a>
    </div>
</div>