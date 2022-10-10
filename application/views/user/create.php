<div class="row justify-content-center">
    <div class="col-4 align-items-center">
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
            <p>
                <select name="gender">
                    <?php foreach (\application\models\User::GENDERS as $genderValue => $genderName): ?>
                        <option value="<?= $genderValue ?>"><?= $genderName ?></option>
                    <?php endforeach; ?>
                </select>

            </p>
            <p>
                <select name="status">
                    <?php foreach (\application\models\User::STATUS as $statusValue => $statusName): ?>
                        <option value="<?php echo $statusValue; ?>"><?php echo $statusName; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <button type="submit" id="validate" disabled>Send</button>
            </p>
        </form>
        <a href="/">
            <button type="button" class="btn btn-danger">Back page</button>
        </a>
    </div>
</div>