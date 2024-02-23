document.querySelector('.nikitq-form').addEventListener('submit', (e) => {
    e.preventDefault();

    const target = e.currentTarget;
    let action = target.action;
    let method = target.method;

    let formData = new FormData();
    let files = document.getElementById('fileInput').files;

    for (const [i, file] of Array.from(files).entries()) {
        formData.append(`file_${i}`, file);
    }

     fetch(action, {
         method: method,
         body: formData
     })
         .then(response => {
             if (!response.ok) {
                 throw new Error('Network response was not ok');
             }
             console.log('File uploaded successfully');
         })
         .catch(error => {
             console.error('There was a problem with the file upload:', error);
         });
});