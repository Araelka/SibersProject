<!DOCTYPE html>
<html>
    <head>
        <title>Sibers</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/css/style.css">
    </head>

    <body>
        <div class="main-content">
            <div class="conteiner">
                <div class="header">
                    <h1><?= isset($user) ? 'Редактирование пользователя ' . $user['login']: 'Создание пользователя' ?></h1>
                    <a href="/logout" class="logout-btn">Выйти</a>
                </div>

                <hr>
                <?php if (isset($error)): ?>
                            <div class="error">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                <div style="display: flex; justify-content: center;">
                    
                    <?php if (isset($user)): ?>
                        <form action="/users/edit/<?= $user['id'] ?>" method="POST">
                    <?php else: ?>
                        <form action="/users/create" method="POST">
                    <?php endif ?>
                        <div class="button-menu">
                            <div class="form-group">
                                <button type="submit"><?= isset($user) ? 'Сохранить' : 'Создать' ?></button>
                            </div>

                            <div class="form-group">
                                <a href="/users">Назад</a>
                            </div>
                        </div>
                        <div class="user-content">
                            <div class="user-group">
                                <div class="form-group">
                                    <label for="login">Логин</label>
                                    <input type="text" name="login" id="login" value="<?= isset($user) ? $user['login'] : '' ?>" placeholder="Логин">
                                </div>

                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input type="password" name="password" id="password" placeholder="<?= isset($user) ? 'Оставьте пустым, если не меняете' : 'Пароль' ?>">
                                </div>

                                <div class="form-group">
                                    <label for="role">Роль</label>
                                    <select name="role" id="role" required>
                                        <?php foreach ($roles as $role): ?>
                                            <option value=<?= $role['id'] ?> <?= isset($user) ? $user['role_id'] == $role['id'] ? 'selected' : '' : '' ?>>
                                            <?= $role['description'] ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>

                            <div class="user-group">
                                <div class="form-group">
                                    <label for="firstName">Имя</label>
                                    <input type="text" name="firstName" id="firstName" value="<?= isset($user) ? $user['firstName'] : '' ?>" placeholder="Имя">
                                </div>

                                <div class="form-group">
                                    <label for="secondName">Фамилия</label>
                                    <input type="text" name="secondName" id="secondName" value="<?= isset($user) ? $user['secondName'] : '' ?>" placeholder="Фамилия">
                                </div>

                                <div class="form-group">
                                    <label for="gender">Пол</label>
                                    <select name="gender" id="gender" required>
                                        <option value="male" <?= isset($user) ? $user['gender'] === 'male' ? 'selected' : '' : '' ?>>Мужской</option>
                                        <option value="female" <?= isset($user) ? $user['gender'] === 'female' ? 'selected' : '' : '' ?>>Женский</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="birthdate">Дата рождения</label>
                                    <input type="date" name="birthdate" id="birthdate" value="<?= isset($user) ? $user['birthdate'] : '' ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>