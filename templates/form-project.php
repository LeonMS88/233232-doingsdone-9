<h2 class="content__main-heading">Добавление проекта</h2>

<form class="form"  action="add-project.php" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="form__row">
        <label class="form__label" for="project_name">Название <sup>*</sup></label>

        <?php $class_name = isset($errors['name']) ? 'form__input--error' : '';
              $name = isset($progect['name']) ? $progect['name'] : '';?>

        <input class="form__input <?= $class_name ?>" type="text" name="name" id="project_name" value="<?= $name; ?>" placeholder="Введите название проекта">
        
        <?php if (isset($errors['name'])) : ?>
            <p class='form__message'><?= $errors['name'] ?></p>
        <?php endif ?>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>

<?php if (isset($errors['error'])) : ?>
    <p class='form__message'><?= $errors['error'] ?></p>
<?php endif ?>
