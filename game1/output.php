
<article class="my-3 py-3">
<table class="table table-dark table-striped">
    <thead>
            <tr class="table-secondary">
            <th scope="col">Spieler</th>
            <th scope="col">Frage</th>
            <th scope="col">Ergebnis</th>
            <th scope="col">Runde</th>
            <th scope="col">Datum</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $pdo = new PDO('mysql:host=localhost;dbname=games','root','');
        $stmt = ("SELECT * FROM mathequiz");
        foreach($pdo->query($stmt) as $row){
      ?>
        <tr>
            <td><?php echo $row['username'];     ?></td>
            <td><?php echo $row['question'];     ?></td>
            <td><?php echo $row['result'];       ?></td>
            <td><?php echo $row['round'];        ?></td>
            <td><?php echo $row['game_date'];   ?></td>
        </tr>
        <?php } ?>

    </tbody>

</table>
</article>
