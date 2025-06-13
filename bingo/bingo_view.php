<?php
global$resultaten;
global$aantalRijen;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="../content/css/main.css">
    <link rel="stylesheet" href="../content/css/bingo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="../content/js/toggle.js"></script>
    <title>OHM Festival Bingo!</title>
</head>
    <body class="pangolin-regular">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../content/img/ohm-logo.svg" alt="OHM festival logo" width="185">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./">Bingo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../kaart">Festival kaart</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <?php
        $taskIndex = 0;
        for ($row = 0; $row < 4; $row++): ?>
        <div class="row mt-2">
            <?php for ($col = 0; $col < 4; $col++):
            $task = $userTaskData[$taskIndex];
            $isSubmitted = !empty($task['photo_path']);
            $statusClass = $isSubmitted ? 'submitted' : '';
            ?>
            <div class="col-3">
                <div class="text-center p-4 square <?= $statusClass ?>" onclick="toggleSquare(this)" data-task-id="<?= $task['id'] ?>">
                    <div>
                        <div class="task-number">Task <?= $taskIndex + 1 ?></div>
                        <div class="task">
                            <?= htmlspecialchars($task['task']) ?>
                        </div>
                        <div class="submission-area">
                            <?php if ($isSubmitted): ?>
                            <div class="submitted-indicator">✅ Submitted!</div>
                            <small>Status: <?= ucfirst($task['status']) ?></small>
                            <?php else: ?>
                            <input type="file" class="form-control mt-2 photo-input" accept="image/*" style="display: none;">
                            <button class="btn btn-primary btn-sm mt-2 upload-btn">Upload foto!</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $taskIndex++; endfor; ?>
        </div>
        <?php endfor;
        ?>
    </div>

    <script>
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
                        square.querySelector('.submission-area').innerHTML = '<div class="submitted-indicator">✓ Submitted</div><small>Status: Pending</small>';
                    } else {
                        alert('Upload failed: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Upload failed');
                });
        }
    </script>
    </body>
</html>