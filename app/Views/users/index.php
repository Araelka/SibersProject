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
                    <h1>Управление пользователями</h1>
                    <a href="/logout" class="logout-btn">Выйти</a>
                </div>

                <hr>

                <div class="button-menu" style="justify-content: flex-start;">
                    <div class="form-group">
                        <a href="/users">Создать</a>
                    </div>
                </div>

                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Логин</th>
                                <th>Роль</th>
                                <th>Дата создания</th>
                                <th>Дата обновления</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['login']) ?></td>
                                    <td><?= htmlspecialchars($user['role_name']) ?></td>
                                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                                    <td><?= htmlspecialchars($user['updated_at']) ?></td>
                                    <td>
                                        <div style="display: flex; flex-direction: row; gap: 10px;">
                                        <a href="/users/edit/<?= $user['id'] ?>" class="action-btn edit-btn">Редактировать</a>
                                        <form action="/destroy" method="POST">
                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                            <button class="action-btn delete-btn" type="submit">Удалить</button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>