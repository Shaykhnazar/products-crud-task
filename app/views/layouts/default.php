<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <link href="../../../public/styles/style.css" rel="stylesheet">
    <link href="../../../public/styles/products.css" rel="stylesheet">
    <script src="../../../public/scripts/jquery.js" defer></script>
    <script src="../../../public/scripts/form.js" defer></script>
    <script src="../../../public/scripts/products.js" defer></script>
 </head>
<body>
    <?php require_once "header.php";?>
    <main>
        <?php echo $content; ?>
    </main>
    <?php require_once "footer.php";?>
</body>
</html>