<div class="row justify-content-center">
    <div class="col-4 align-items-center" >
        <H1>Update user page</H1>

        <?php if (isset($message)) : ?>
            <p><?= $message ?></p>
        <?php endif; ?>


        <?php foreach ($user as $row):?>

        <form action="/user/edit" method="post">
            <p>Email:</p>
            <p>
                <input type="text" name="email" value="<?php echo $row['email'];?>" id="email" required>
                <span id="valid"></span>
            </p>
            <p>Your first and last name:</p>
            <p>
                <input type="text" name="name" value="<?php echo $row['name'];?>" id="name" required>
                <span id="nameValid"></span>
            </p>
            <p><select name="gender">
                    <option value="male" <?php if($row['gender'] == "male") echo 'selected="selected"' ?>>Male</option>
                    <option value="female" <?php if($row['gender'] == "female") echo 'selected="selected"' ?>>Female</option>
                </select></p>
            <p><select name="status" >
                    <option value="active" <?php if($row['status'] == "active") echo 'selected="selected"' ?>>Active</option>
                    <option value="inactive" <?php if($row['status'] == "inactive") echo 'selected="selected"' ?>>Inactive</option>
                </select></p>
            <input class="displayNone" type="text" name="emailOld" value="<?php echo $row['email'];?>">
            <p><button type="submit" id="validate">Update</button></p>
        </form>
        <?php endforeach; ?>
        <a href="/"><button type="button" class="btn btn-danger">Back page</button></a>
    </div>
</div>