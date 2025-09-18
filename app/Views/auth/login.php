<!DOCTYPE html>
<html>
    <head>
        <title>Авторизация</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/css/style.css">
    </head>

    <body>
        <div class="main-content">
            <div class="login-form">
                <h2>Авторизация</h2>


                <form action="/login" method="POST">
                    <div class="form-content">

                        <?php if (isset($error)): ?>
                            <div class="error">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <input type="text" id="login" name="login" placeholder="Логин" required>
                        </div>

                        <div class="form-group">
                            <input type="password" id="password" name="password" placeholder="Пароль" required>
                        </div>

                        <button type="submit">Войти</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>