<h2 class="content__main-heading">Регистрация аккаунта</h2>
<?php if (isset($errors['error'])) : ?>
<p class="error-message"><?= $errors['error'] ?></p>
<?php endif ?>

<form class="form" action="register.php" method="post" autocomplete="off">
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

    <?php $class_password = isset($errors['password']) ? 'form__input--error' : '';?>

    <input class="form__input <?= $class_password ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">

    <?php if (isset($errors['password'])) : ?>
        <p class="form__message"><?= $errors['password'] ?></p>
    <?php endif ?>

  </div>

  <div class="form__row">
    <label class="form__label" for="name">Имя <sup>*</sup></label>

    <?php $class_name = isset($errors['name']) ? 'form__input--error' : '';?>

    <input class="form__input <?= $class_name ?>" type="text" name="name" id="name" value="" placeholder="Введите имя">

    <?php if (isset($errors['name'])) : ?>
        <p class="form__message"><?= $errors['name'] ?></p>
    <?php endif ?>

  </div>

  <div class="form__row form__row--controls">
    <input class="button" type="submit" name="" value="Зарегистрироваться">
  </div>
</form>