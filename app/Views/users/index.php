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
                        <a href="/users/create">Создать</a>
                    </div>
                </div>

                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <a href="?sort=id&order=<?= $sortField == 'id' && $sortOrder == 'ASC' ? 'DESC' : 'ASC' ?>">
                                        ID <?= $sortField == 'id' ? ($sortOrder == 'ASC' ? '↑' : '↓') : '' ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?sort=login&order=<?= $sortField == 'login' && $sortOrder == 'ASC' ? 'DESC' : 'ASC' ?>">
                                        Логин <?= $sortField == 'login' ? ($sortOrder == 'ASC' ? '↑' : '↓') : '' ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?sort=role_id&order=<?= $sortField == 'role_id' && $sortOrder == 'ASC' ? 'DESC' : 'ASC' ?>">
                                        Роль <?= $sortField == 'role_id' ? ($sortOrder == 'ASC' ? '↑' : '↓') : '' ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?sort=created_at&order=<?= $sortField == 'created_at' && $sortOrder == 'ASC' ? 'DESC' : 'ASC' ?>">
                                        Дата создания <?= $sortField == 'created_at' ? ($sortOrder == 'ASC' ? '↑' : '↓') : '' ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?sort=updated_at&order=<?= $sortField == 'updated_at' && $sortOrder == 'ASC' ? 'DESC' : 'ASC' ?>">
                                        Дата обновлаения <?= $sortField == 'updated_at' ? ($sortOrder == 'ASC' ? '↑' : '↓') : '' ?>
                                    </a>
                                </th>
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
                                            <button class="action-btn delete-btn" type="submit" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?')">Удалить</button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                     <?php if ($totalPages > 1): ?>
                        <div style="margin-top: 20px; text-align: center;">
                            <div style="display: inline-block; padding: 10px; background: white; border-radius: 5px;">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?= $page - 1 ?>&sort=<?= $sortField ?>&order=<?= $sortOrder ?>" 
                                       style="padding: 5px 10px; text-decoration: none; color: #2c3e50;">← Назад</a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <?php if ($i == $page): ?>
                                        <span style="padding: 5px 10px; background: #2c3e50; color: white; border-radius: 3px;"><?= $i ?></span>
                                    <?php else: ?>
                                        <a href="?page=<?= $i ?>&sort=<?= $sortField ?>&order=<?= $sortOrder ?>" 
                                           style="padding: 5px 10px; text-decoration: none; color: #2c3e50;"><?= $i ?></a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <a href="?page=<?= $page + 1 ?>&sort=<?= $sortField ?>&order=<?= $sortOrder ?>" 
                                       style="padding: 5px 10px; text-decoration: none; color: #2c3e50;">Вперед →</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>