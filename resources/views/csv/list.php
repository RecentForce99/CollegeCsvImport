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
</head>
<body>

<?php if (!empty($data)): ?>
    <div class="table-wrapper">
        <table class="nikitq-table">
            <tr>
                <th>ID</th>
                <th>Название файла</th>
                <th>Размер файла</th>
                <th>Путь к файлу</th>
                <th>Создан</th>
                <th>Подробнее</th>
            </tr>
            <?php foreach ($data as $file): ?>
                <tr>
                    <td><?=$file->getId()?></td>
                    <td><?=$file->getOriginalName()?></td>
                    <td><?=$file->getSize()?></td>
                    <td><?=$file->getPath()?></td>
                    <td><?=$file->getCreatedAt()?></td>
                    <td onclick="window.location.href='<?=$file->link?>'" class="td-link">Перейти</td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
<?php endif; ?>

</body>
</html>