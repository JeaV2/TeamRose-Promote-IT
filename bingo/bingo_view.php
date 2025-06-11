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
        <div class="row">
            <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="col-3">
                    <div class="text-center p-4 square" onclick="toggleSquare(this)">
                        <div>
                            <div class="task-number">Task <?= $i + 1 ?></div>
                            <div class="task">
                                <?php
                                $taskId = $vragenIds[$i];
                                echo htmlspecialchars($resultaten[$taskId]['task']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <div class="row mt-2">
            <?php for ($i = 4; $i < 8; $i++): ?>
                <div class="col-3">
                    <div class="text-center p-4 square" onclick="toggleSquare(this)">
                        <div>
                            <div class="task-number">Task <?= $i + 1 ?></div>
                            <div class="task">
                                <?php
                                $taskId = $vragenIds[$i];
                                echo htmlspecialchars($resultaten[$taskId]['task']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <div class="row mt-2">
            <?php for ($i = 8; $i < 12; $i++): ?>
                <div class="col-3">
                    <div class="text-center p-4 square" onclick="toggleSquare(this)">
                        <div>
                            <div class="task-number">Task <?= $i + 1 ?></div>
                            <div class="task">
                                <?php
                                $taskId = $vragenIds[$i];
                                echo htmlspecialchars($resultaten[$taskId]['task']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <div class="row mt-2">
            <?php for ($i = 12; $i < 16; $i++): ?>
                <div class="col-3">
                    <div class="text-center p-4 square" onclick="toggleSquare(this)">
                        <div>
                            <div class="task-number">Task <?= $i + 1 ?></div>
                            <div class="task">
                                <?php
                                $taskId = $vragenIds[$i];
                                echo htmlspecialchars($resultaten[$taskId]['task']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    </body>
</html>