
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form"  action="add.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <?php $class_name = isset($errors['name']) ? 'form__input--error' : '';
                  $name = isset($_POST['name']) ? $_POST['name'] : '';?>

            <input class="form__input <?= $errors['name'] ? 'form__input--error' : '' ?>" type="text" name="name" id="name" value="<?= $name; ?>" placeholder="Введите название">
            <?php if (isset($errors['name'])) : ?>
                <p class='form__message'><?= $errors['name'] ?></p>
            <?php endif ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <?php $class_project = isset($errors['project']) ? 'form__input--error' : '';
                  $project = isset($_POST['project']) ? $_POST['project'] : '';?>
            
            <select class="form__input <?=$class_project; ?>" name="project" id="project">

                <?php foreach ($progect as $key => $value): ?>
                    <option value="<?=$progect[$key]["progect_id"];?>"><?=htmlspecialchars($progect[$key]["progect_name"]);?></option>
                <?php endforeach; ?>

            </select>

            <?php if (isset($errors['project'])) : ?>
                <p class='form__message'><?= $errors['project'] ?></p>
            <?php endif ?>

        </div>

        <div class="form__row">

            <label class="form__label" for="date">Дата выполнения</label>

            <?php $class_date = isset($errors['date']) ? 'form__input--error' : '';
                  $date = isset($_POST['date']) ? $_POST['date'] : ''; ?>

            <input class="form__input form__input--date <?=$class_date; ?>" type="text" name="date" id="date" value="<?= $task['date']; ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            
            <?php if (isset($errors['date'])) : ?>
                <p class='form__message'><?= $errors['date'] ?></p>
            <?php endif ?>

        </div>

        <div class="form__row">
            <label class="form__label" for="file">Файл</label>

        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="file" id="file" value="">

            <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
            </label>
            
        </div>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>


