const dragDrop = document.getElementById('dragDrop');
const dragDropText = document.querySelector('.drag-drop-wrapper .text');
const dragDropIcon = document.querySelector('.drag-drop-wrapper .icon');

const table = document.querySelector('.nikitq-table');

const button = document.querySelector('.btn');

const maxFileSizeInBytes = 5242880;
const acceptableFileType = 'text/csv';

dragDrop.addEventListener('click', function () {
    document.getElementById('fileInput').click();
});

// Обработчики событий для drag&drop файлов
dragDrop.addEventListener('dragover', function (e) {
    e.preventDefault();
    dragDropText.style.display = 'block';
    dragDropIcon.style.display = 'none';
});

dragDrop.addEventListener('drop', function (e) {
    e.preventDefault();
    dragDropText.style.display = 'block';
    dragDropText.innerText = 'Можно прикрепить ещё';

    const files = e.dataTransfer.files;
    deleteOldFiles();
    processFiles(files);
});

// Обработчик события для выбора файла через input
document.getElementById('fileInput').addEventListener('change', function (e) {
    const files = e.target.files;
    deleteOldFiles();
    processFiles(files);
});

function deleteOldFiles() {
    let additionalRows = table.querySelectorAll('.additional-rows');
    if (additionalRows) {
        additionalRows.forEach(row => {
            row.remove();
        });
    }
}

function processFiles(files)
{
    let index = 0;
    for (let file of files) {
        file.statusText = getFileStatusText(file);
        if (file.statusText) {
            showErrorFile(file);
        } else {
            showSuccessFile(file);
        }
    }
}

function getFileStatusText(file) {
    if (file.type !== acceptableFileType) {
        return 'Неверное расширение файла. Должен быть csv';
    } else if (file.size === 0) {
        return 'Файл - пустой';
    } else if (file.size > maxFileSizeInBytes) {
        return 'Размер файла превышает ' + convertBytes(file.maxFileSizeInBytes);
    }

    return null;
}

function showErrorFile(file) {
    let fileRow = getFileRow(file);

    fileRow.classList.add('error-row');
    table.append(fileRow);

    table.style.display = 'block';
    button.style.display = 'block';
}

function showSuccessFile(file) {
    let fileRow = getFileRow(file);

    table.append(fileRow);

    table.style.display = 'block';
    button.style.display = 'block';
}

function getFileRow(file) {
    const fileRow = document.createElement('tr');
    const fileName = document.createElement('td');
    const fileSize = document.createElement('td');
    const fileStatus = document.createElement('td');

    fileName.classList.add('nikitq-file-name');
    fileName.textContent = file.name;

    fileSize.classList.add('nikitq-file-size');
    fileSize.textContent = convertBytes(file.size);

    fileStatus.classList.add('nikitq-file-status');
    fileStatus.textContent = 'Ожидает отправки';

    if (file.statusText) {
        fileStatus.textContent = file.statusText;
    }

    fileRow.classList.add('additional-rows');

    fileRow.appendChild(fileName);
    fileRow.appendChild(fileSize);
    fileRow.appendChild(fileStatus);

    return fileRow
}

function convertBytes(bytes) {
    let kb = bytes / 1024;
    let mb = kb / 1024;
    let gb = mb / 1024;

    if (bytes < 1024) {
        return bytes + ' B'; // Байты
    } else if (kb < 1024) {
        return kb.toFixed(2) + ' KB'; // Килобайты
    } else if (mb < 1024) {
        return mb.toFixed(2) + ' MB'; // Мегабайты
    } else {
        return gb.toFixed(2) + ' GB'; // Гигабайты
    }
}