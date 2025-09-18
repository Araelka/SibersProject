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
                                        <a href="/users/edit/<?= $user['id'] ?>" class="action-btn edit-btn">Редактировать</a>
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