<!DOCTYPE html>
<html>
<head>
    <title>Mathe Quiz</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
<main class="container">
    <h1>Mathe Quiz</h1>
    <div id="usernameOutput">
        <!-- Button for Username -->
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#getUsername">
            Gib deinen Usernamen ein
        </button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="getUsername" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user" class="form-label">Username</label>
                        <input type="text" class="form-control" id="user" placeholder="Gib deinen Spielername ein">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="saveUser()" data-bs-dismiss="modal" class="btn btn-dark">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <article class="row text-center">
        <?php for($i = 1; $i < 10; $i++) { ?>
            <section class="col-4 p-3">
                <button type="button" class="btn btn-outline-dark openModal" data-id="<?php echo $i; ?>">
                    Frage: <?php echo $i; ?>
                </button>
            </section>
        <?php } ?>
    </article>
    <button type="button" onclick="newGame()" class="btn btn-danger">Neues Spiel starten</button>
</main>

<div id="modalContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    // TODO nächste Woche: je nach Runde die Buttons aktivieren oder deaktivieren
    // ToDo nächste Woche: Antworten in die DB speichern
    // TODO nächste Woche: Logiken Feintuning
    // TODO TN bis nächste Woche: 8 Fragen überlegen
    "use strict";
    console.log(localStorage);
    function saveUser() {
        let username = $('#user').val();
        localStorage.setItem('username', username);
    }
    function newGame() {
        localStorage.clear();
        location.reload();
    }

    /*if(localStorage.getItem('username')){

    }*/
    function checkQuestion() {
        let userInput = $('#userInput').val();
        let resultInput = $('#resultInput').val();
        if(userInput == resultInput) {
            // Ausgabe : yuhuu
            $('#information').text('Yeah du kannst rechnen. Super!');
            $('#saveToDB').removeClass('disabled');
            let roundNumber = Number($('#roundInput').val()) + 1;
            localStorage.setItem('round', roundNumber);
        } else {
            // Ausgabe: Denk nochmal drüber nach
            $('#information').text('Denk lieber nochmal nach');
        }
    }

    $('.openModal').on('click', function () {

        let roundID = $(this).data('id');
        let functionName = 'question' + roundID;
        let resultFunction = window[functionName];
        let questionModal = resultFunction();

        $.ajax({
            url: 'questionModal.html',
            method: 'post',
            data: { roundID: roundID},
            success: function (data) {
                // Open Modal
                $('#modalContainer').html(data);
                $('#questionModal').modal('show');
                $('#roundInput').val(1);
                $('#usernameInput').val(localStorage.getItem('username'));
                $('#resultInput').val(questionModal['result']);
                $('#questionInput').val(questionModal['mathquestion']);
            },
            error: function (data) {
                console.log(data)
            }
        });
    });

    /* Fragen */
    function question1() {

        let a = Math.floor(Math.random() * 49 +1);
        let b = Math.floor(Math.random() * 49 +1);

        let questionModal = new Array;
        questionModal['result'] = a + b;
        questionModal['mathquestion'] = "Was ist das Ergebnis aus " + a + " + " + b + "?";
        return questionModal;
    }
</script>
</body>
</html>