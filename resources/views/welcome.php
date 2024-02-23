<!doctype html>
<html lang="en, ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Импорт CSV</title>
    <link rel="stylesheet" href="assets/font/stylesheet.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <link rel="stylesheet" href="assets/styles/welcome.css">
    <link rel="stylesheet" href="assets/styles/form.css">
</head>
<body>

<div class="welcome">
    <h1>Добро пожаловать</h1>
    <p>Ниже форма, которая позволяет импортировать данные из CSV-файла в БД и отобразить их на <a href="">отдельной
            странице</a></p>
</div>

<form class="nikitq-form" action="/api/upload/csv/" method="POST" enctype="application/x-www-form-urlencoded">
    <div class="file-wrapper">
        <label class="file-label" for="file">
            Выберите файл(ы):
        </label>
        <div class="drag-drop" id="dragDrop">
            <div class="drag-drop-wrapper">
                <input type="file" name="files[]" accept=".csv" id="fileInput" multiple>
                <p class="text" style="display: none">Let me fall</p>
                <img class="icon" src="assets/img/drag-n-drop.png" alt="upload">
            </div>
        </div>

        <table class="nikitq-table" style="display: none;">
            <tr>
                <th>Название файла</th>
                <th>Размер файла</th>
                <th>Статус</th>
                <th>Сообщение</th>
            </tr>
        </table>
    </div>

    <button type="submit" class="btn" style="display: none">
        Загрузить
    </button>
</form>

<script src="assets/scripts/form.js"></script>
<script src="assets/scripts/ajax.js"></script>

</body>
</html>