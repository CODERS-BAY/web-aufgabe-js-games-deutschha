<?php



try{
$roundID = intval($_POST['roundId']);
$resultInput = intval($_POST['resultInput']);

$pdo = new PDO('mysql:host=localhost;dbname=games','root','');
$stmt = $pdo->prepare("INSERT INTO mathequiz (username, question, result, round) VALUES (:username,:question,:result,:round)");

$stmt->bindParam(':username',$_POST['username']);
$stmt->bindParam(':question',$_POST['question']);
$stmt->bindParam(':result',$resultInput);
$stmt->bindParam(':round',$roundID);
$stmt->execute();

return include('output.php');
} catch (PDOException $e){
    echo $e->getMessage();
}
?>