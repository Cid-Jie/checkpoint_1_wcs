<?php
require_once ('../connec.php');
$pdo = new PDO(DSN, USER, PASS);

if(
    isset($_POST['name']) &&
    isset($_POST['payment']))
{
    $data = array_map('trim', $_POST);

    if(empty($data['name']))
        die('Your name is required');

    if($data['payment'] < 0)
        die('Your payment must be superior to 0 !');

    $query = "INSERT INTO bribe (name, payment) VALUES (:name, :payment);";
    $statement = $pdo->prepare($query);
    $name = ($data['name']);
    $payment = ($data['payment']);

    $statement->bindvalue(':name', $name, PDO::PARAM_STR);
    $statement->bindvalue(':payment', $payment, PDO::PARAM_INT);
    $statement->execute();

}

    $query = 'SELECT * FROM bribe ORDER BY name;';
    $statement = $pdo->query($query);
    $bribes = $statement->fetchAll();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/book.css">
    <title>Checkpoint PHP 1</title>
</head>
<body>

<?php include 'header.php'; ?>

<main class="container">

    <section class="desktop">
        <img src="image/whisky.png" alt="a whisky glass" class="whisky"/>
        <img src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>

        <div class="pages">
            <div class="page leftpage">
                Add a bribe
                <!-- TODO : Form -->
                <form method="post">
                    <p>
                        <label for="name">Name : </label> 
                        <input type="text" name="name" id="name" required>
                    </p>
                    <p>
                        <label for="payment">Payment : </label> 
                        <input type="number" name="payment" id="payment" required>
                    </p>
                    <p>
                        <input type="submit" value="Send">
                    </p>
                </form>
            </div>

            <div class="page rightpage">
                <!-- TODO : Display bribes and total paiement -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Payment</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                         $sum = 0;
                        foreach($bribes as $bribe){
                            $sum += $bribe['payment'];
                        ?>
                        <tr>
                            <td><?= $bribe['name']?></td>
                            <td><?= $bribe['payment']?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total payment : </td>
                            <td><?= $sum?></td>
                        </tr>
                    </tfoot>

                </table>
            
            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>
