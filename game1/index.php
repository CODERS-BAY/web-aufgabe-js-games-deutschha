<!DOCTYPE html>
<html>
<head>
    <title>Mathe Quiz</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
<main class="container mt-5">0
    <h1 class="text-center">Mathe Quiz</h1>
    <div id="usernameOutput" class="text-center">
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
    <article class="row text-center" id="gameplay">
        <?php for($i = 1; $i < 10; $i++) { ?>
            <section class="col-4 p-3">
                <button type="button" id="btn<?php echo $i; ?>" class="btn btn-outline-dark openModal disabled" data-id="<?php echo $i; ?>">
                    Frage: <?php echo $i; ?>
                </button>
            </section>
        <?php } ?>
    </article>
    <div class="text-center">
    <button type="button" onclick="newGame()" class="btn btn-danger">Neues Spiel starten</button>
    </div>
</main>

<div id="modalContainer"></div>
<!-- Hier kommt der Spielstand aus der Datenbank -->
<div id ="output"><?php include('output.php'); ?> </div>
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
        $('#btn1').removeClass('disabled');
        localStorage.setItem('round','1');
        $('#usernameOutput').text('Hallo ' + username);
    }
    function newGame() {
        localStorage.clear();
        location.reload();
    }

    if(localStorage.getItem('username')){
        $('#usernameOutput').text('Hallo ' + localStorage.getItem('username'));
        $('#btn'+ localStorage.getItem('round')).removeClass('disabled');
    }
    function checkQuestion() {
        let userInput = $('#userInput').val();
        let resultInput = $('#resultInput').val();
        if(userInput == resultInput) {
            // Ausgabe : yuhuu
            $('#information').text('Yeah du kannst rechnen. Super!');
            $('#saveToDB').removeClass('disabled');
            let roundNumber = Number($('#roundInput').val()) + 1;
            roundNumber = String(roundNumber);
            localStorage.setItem('round', roundNumber);
        }
        else {
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
                $('#roundInput').val(localStorage.getItem('round'));
                $('#usernameInput').val(localStorage.getItem('username'));
                $('#resultInput').val(questionModal['result']);
                $('#questionInput').val(questionModal['mathquestion']);
            },
            error: function (data) {
                console.log(data)
            }
        });
    });

    //$('#saveToDB').on('click', function () {
        // username, question, result, round
    function saveIT(){
        let roundId = $('#roundInput').val();
        let newRound = Number(roundId) + 1;
        localStorage.setItem('round', String(newRound));
        let username = localStorage.getItem('username');
        let resultInput = $('#resultInput').val();
        let question = $('#questionInput').val();
        console.log(roundId, username, resultInput, question);
        $.ajax({
            url: 'save.php',
            method: 'post',
            data: {
              roundId: roundId,
              username: username,
              resultInput: resultInput,
              question:question
            },
            success: function (data) {
                console.log(data);
                $('#output').html(data);
                $('#btn' + roundId).addClass('disabled');
                $('#btn' + newRound).removeClass('disabled');

            }
        });
        if (roundId == 0) {
            $('#gameplay').html('<img class="img-fluid src="https://images.unsplash.com/photo-1496449903678-68ddcb189a24?ixid=MXwxMjA3fDB8MHxzZWFyY2h8NHx8ZnVubnklMjBxdW90ZXxlbnwwfHwwfA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60">');
        }
    }
    /* die Werte bei Neustart
    /* Fragen */

    function question1() {
        let a = Math.floor(Math.random() * 49 +1);
        let b = Math.floor(Math.random() * 49 +1);

        let questionModal = new Array;
        questionModal['result'] = a + b;
        questionModal['mathquestion'] = "Was ist das Ergebnis aus " + a + " + " + b + "?";
        return questionModal;
    }

    function question2() {
        let a = Math.floor(Math.random() * 49 + 51);
        let b = Math.floor(Math.random() * 49 + 1);

        let questionModal = new Array;
        questionModal['result'] = a - b;
        questionModal['mathquestion'] = "Was ist das Ergebnis aus " + a + " - " + b + "?";
        return questionModal;
    }
    function question3() {
        let a = Math.floor(Math.random() * 19 + 1);
        let b = Math.floor(Math.random() * 19 + 1);

        let questionModal = new Array;
        questionModal['result'] = a * b;
        questionModal['mathquestion'] = "Was ist das Ergebnis aus " + a + " * " + b + "?";
        return questionModal;
    }
    function question4() {
        let a = Math.floor(Math.random() * 9 + 1); // der Divisor
        let b = Math.floor(Math.random() * 49 + 1); // Ergebnis des Divisor
        let questionModal = new Array;
        questionModal['result'] = a * b / a;
        questionModal['mathquestion'] = "Was ist das Ergebnis aus " + a * b + " / " + a + "?";
        return questionModal;
    }
    function question5() {
        let a = Math.floor(Math.random() * 49 + 1);
        let b = Math.floor(Math.random() * 49 + 1);
        let c = Math.floor(Math.random() * 9 + 1);

        let questionModal = new Array;
        questionModal['result'] = a + b * c;
        questionModal['mathquestion'] = "Was ist das Ergebnis aus " + + a + " + " + b + " * " + c + "?";
        return questionModal;
    }
    function question6() {
        let a = Math.floor(Math.random() * 49 + 1);
        let b = Math.floor(Math.random() * 49 + 1);
        let c = Math.floor(Math.random() * 9 + 1);

        let questionModal = new Array;
        questionModal['result'] = (a + b) * c;
        questionModal['mathquestion'] = "Was ist das Ergebnis aus (" + a + " + " + b + ") * " + c + "?";
        return questionModal;
    }
    function question7() {
        let a = Math.floor(Math.random() * 9 + 1);
        let b = Math.floor(Math.random() * 49 + 1);
        let c = Math.floor(Math.random() * 49 + 1);

        let questionModal = new Array;
        questionModal['result'] = b - c;
        questionModal['mathquestion'] = "Was ist das Ergebnis aus " + a * b + " / " + a + " - " + c + "?";
        return questionModal;
    }
    function question8() {
        let a = Math.floor(Math.random() * 19 + 1); //das Ergebnis

        let questionModal = new Array;
        questionModal['result'] = a;
        questionModal['mathquestion'] = "Was ist die Quadratwurzel von " + a * a + "?";
        return questionModal;
    }
    function question9() {
        let a = Math.floor(Math.random() * 9 + 2); //die Basis
        let b = Math.floor(Math.random() * 9 + 1); //das Ergebnis

        let questionModal = new Array;
        questionModal['result'] = b;
        questionModal['mathquestion'] = "Was ist der Logarithmus von " + Math. pow(a, b) + " zur Basis " + a + "?";
        return questionModal;
    }
</script>
</body>
</html>