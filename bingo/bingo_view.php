<?php
global $userTasksData;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="../content/css/main.css">
    <link rel="stylesheet" href="../content/css/bingo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="../content/js/toggle.js"></script>
    <script src="../content/js/photo_upload.js"></script>
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
        <div class="row">
            <div class="col-md-3 order-2 order-md-1">
                <H1 class="text-center">Hoe speel je mee met de bingo?</H1>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header accordion-color">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Stap #1
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Druk op één van de taken, deze zal vergroot worden, lees wat je moet doen. <br>
                                Als je op een andere taak klikt, wordt deze groter. <br>
                                Als je nog een keer op de taak klikt, wordt deze weer verkleint.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Stap #2
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Open de camera-app op je telefoon, en maak een foto van wat de taak beschrijft.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Stap #3
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Klik op de "Upload Foto!" knop. <br>
                                Kies nu de foto die je hebt gemaakt uit je gallerij en upload deze.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Stap #4
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Wacht tot je foto wordt goedgekeurd, als je foto wordt afgekeurd, probeer het opnieuw met een nieuwe foto!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 order-1 order-md-2">
            <?php
            $taskIndex = 0;
            // Make the 4x4 grid for the tasks
            for ($row = 0; $row < 4; $row++): ?>
                <div class="row mt-2">
                    <?php for ($col = 0; $col < 4; $col++):
                        $task = $userTasksData[$taskIndex];
                        $isSubmitted = !empty($task['photo_path']);
                        $statusClass = $isSubmitted ? 'submitted' : '';
                        ?>
                        <div class="col-3">
                            <div class="text-center p-4 square <?= $statusClass ?>" onclick="toggleSquare(this)" data-task-id="<?= $task['id'] ?>">
                                <div>
                                    <div class="task-number" <?= $taskIndex == 9 ? 'style="font-size: 1em;"' : '' ?>>Taak <?= $taskIndex + 1 ?></div>
                                    <div class="task">
                                        <?= htmlspecialchars($task['task']) ?>
                                    </div>
                                    <div class="submission-area">
                                        <?php if ($isSubmitted): ?>
                                            <div class="submitted-indicator">✅ Submitted</div>
                                            <small>Status: <?= ucfirst($task['status']) ?></small>
                                        <?php else: ?>
                                            <input type="file" class="form-control mt-2 photo-input" accept="image/*" style="display: none;">
                                            <button class="btn btn-primary btn-sm mt-2 upload-btn">Upload Foto!</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    $taskIndex++;
                    endfor; ?>
                </div>            
                <?php endfor; ?>
            </div>
        </div>
    </div>
</body>
</html>