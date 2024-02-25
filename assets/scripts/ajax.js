document.querySelector('.nikitq-form').addEventListener('submit', (e) => {
    e.preventDefault();

    const target = e.currentTarget;
    let action = target.action;
    let method = target.method;

    let formData = new FormData();
    let files = document.getElementById('fileInput').files;

    for (const file of files) {
        formData.append('files[]', file);
    }

    fetch(action, {
        method: method,
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error();
            }
            response.json().then(files => {
                setStatuses(files)
            })
        })
        .catch(error => {
            const fileRows = document.querySelectorAll('.additional-rows');
            fileRows.forEach(function (tr) {
                tr.classList.add('error-row');
                tr.querySelector('.nikitq-file-status').innerText = 'Произошло неожиданное исключение';
            });
        });
});

function setStatuses(files) {
    const fileRows = document.querySelectorAll('.additional-rows');
    for (let file of files) {
        fileRows.forEach(function (tr) {
            if (tr.firstChild.innerText.trim() === file.name) {
                if (file.statusCode === 200) {
                    setStatus(tr, 'success-row', file.statusText);
                } else {
                    setStatus(tr, 'error-row', file.statusText);
                }
            }
        });
    }
}

function setStatus(tr, selector, statusText) {
    tr.classList.add(selector);
    let fileStatusText = tr.querySelector('.nikitq-file-status');
    fileStatusText.innerText = statusText;
}
