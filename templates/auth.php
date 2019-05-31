<main class="content__main">
    <h2 class="content__main-heading">Вход на сайт</h2>

    <form class="form" action="auth.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <?php $class_email = isset($errors['email']) ? 'form__input--error' : '';
                  $email = isset($form['email']) ? $form['email'] : '';?>

            <input class="form__input <?= $class_email ?>" type="text" name="email" id="email" value="<?= $email; ?>" placeholder="Введите e-mail">

            <?php if (isset($errors['email'])) : ?>
                <p class="form__message"><?= $errors['email'] ?></p>
            <?php endif ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>

            <?php $class_password = isset($errors['password']) ? 'form__input--error' : '';
                  $password = isset($form['password']) ? $form['password'] : '';?>

            <input class="form__input <?= $class_password ?>" type="password" name="password" id="password" value="<?= $password; ?>" placeholder="Введите пароль">

            <?php if (isset($errors['password'])) : ?>
                <p class="form__message"><?= $errors['password'] ?></p>
            <?php endif ?>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Войти">
        </div>
    </form>

    <?php if (isset($errors['error'])) : ?>
        <p class="error-message"><?= $errors['error'] ?></p>
    <?php endif ?>

</main>
