<!doctype html>
<html lang="en, ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Импорт CSV</title>
    <link rel="stylesheet" href="/assets/font/stylesheet.css">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/table.css">
    <link rel="stylesheet" href="/assets/styles/list.css">
    <link rel="stylesheet" href="/assets/styles/detail.css">
</head>
<body>

<a href="/" class="back-to-main">Вернуться на главную</a>

<?php if (!empty($data)): ?>
    <div class="table-wrapper">
        <table class="nikitq-table">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Имя</th>
                <th>Квота</th>
                <th>Дата</th>
            </tr>
            <?php foreach ($data as $file): ?>
                <tr>
                    <td><?=$file->getId()?></td>
                    <td><?=$file->getEmail()?></td>
                    <td><?=$file->getName()?></td>
                    <td><?=$file->getQuota()?></td>
                    <td><?=$file->getDate()?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
<?php endif; ?>

</body>
</html>