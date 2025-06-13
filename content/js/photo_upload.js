document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.upload-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const square = this.closest('.square');
            const fileInput = square.querySelector('.photo-input');
            fileInput.click();
        });
    });

    document.querySelectorAll('.photo-input').forEach(input => {
        input.addEventListener('change', function() {
            const square = this.closest('.square');
            const taskId = square.dataset.taskId;
            const file = this.files[0];

            if (file) {
                uploadPhoto(taskId, file, square);
            }
        });
    });
});

function uploadPhoto(taskId, file, square) {
    const formData = new FormData();
    formData.append('photo', file);
    formData.append('task_id', taskId);

    fetch('submit_photo.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                square.classList.add('submitted');
                square.querySelector('.submission-area').innerHTML = '<div class="submitted-indicator">✅ Submitted</div><small>Status: Pending</small>';
            } else {
                alert('Upload mislukt: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Upload mislukt.');
        });
}