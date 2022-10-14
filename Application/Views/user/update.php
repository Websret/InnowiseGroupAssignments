<div class="row justify-content-center">
    <div class="col-4 align-items-center">
        <H1>Update user page</H1>

        <?php if (isset($_SESSION["message"])) : ?>
            <p class="errorMessage"><?php echo $_SESSION["message"]; ?></p>
            <?php unset($_SESSION["message"]); ?>
        <?php endif; ?>

        <form action="/user/edit/<?= $user[0]->id ?>" method="post">
            <p>Email:</p>
            <p>
                <input type="text" name="email" value="<?php echo $user[0]->email; ?>" id="email" required>
                <span id="valid"></span>
            </p>
            <p>Your first and last name:</p>
            <p>
                <input type="text" name="name" value="<?php echo $user[0]->name; ?>" id="name" required>
                <span id="nameValid"></span>
            </p>
            <p>
                <select name="gender">
                    <?php foreach (\application\models\User::GENDERS as $genderValue => $genderName): ?>
                        <option value="<?= $genderValue ?>"><?= $genderName ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <select name="status">
                    <?php foreach (\application\models\User::STATUSES as $statusValue => $statusName): ?>
                        <option value="<?php echo $statusValue; ?>"><?php echo $statusName; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <input class="displayNone" type="text" name="id" value="<?php echo $user[0]->id; ?>">
            <p>
                <button type="submit" id="validate">Update</button>
            </p>
        </form>

        <a href="/">
            <button type="button" class="btn btn-danger">Back page</button>
        </a>
    </div>
</div>