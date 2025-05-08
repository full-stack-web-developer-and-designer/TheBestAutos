<?php include "./inc/head.php" ?>
<?php
set_error_handler(static function ($type, $message, $file, $line) use (&$deprecations) {
    if (!(error_reporting() & $type)) {
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler

        // capture E_DEPRECATED
        if ($type === E_DEPRECATED) {
            $deprecations[] =
                ['deprecations' => count($deprecations ?: [])]
                + get_defined_vars();
        }

        return false;
    }

    // throwing error handler, stand-in for own error reporter
    // which may also be `return false;`
    throw new ErrorException($message, $type, error_reporting(), $file, $line);
});
?>
<body>

    <h1>Your Personalised Payment Plan</h1>
    <p class="home-page"><a href="home">Home</a></p>

    <div class="content-area">
        <img class="hero" src="images/<?php echo $_POST['image'] ?>" alt="vehicle image" />
        <p class="vehicle-make"><?php echo $_POST['make'] ?></p>
        <p class="vehicle-model"><?php echo $_POST['model'] ?></p>
        <hr class="vehicle-hr">
        <p class="vehicle-price">$<?php echo number_format($_POST['price'], 2) ?></p>
        <p><span class="data-label">Repayment duration: </span><span class="data-item"><?php echo $_POST['repayment-duration'] ?> months</span></p>
        <p><span class="data-label">Interest rate: </span><span class="data-item"><?php echo $_POST['interest-rate'] ?>% APR</span></p>
        <p><span class="data-label">Total payment: </span><span class="data-item">$<?php echo number_format(calculateTotalPayment($_POST['price'], $_POST['repayment-duration'], $_POST['interest-rate']), 2) ?></span></p>
        <p><span class="data-label">Total interest: </span><span class="data-item">$<?php echo number_format(calculateTotalInterest($_POST['price'], $_POST['repayment-duration'], $_POST['interest-rate']), 2) ?></span></p>
        <hr class="short-line">
        <p><span class="data-label">Monthly payment: </span><span class="focal-point">$<?php echo number_format(calculateMonthlyPayment($_POST['price'], $_POST['repayment-duration'], $_POST['interest-rate']), 2) ?></span></p>
        <br /><br />
    </div>

</body>

<footer id="footer" class="centered">
    <?php include "./inc/footer.php" ?>
</footer>

</html>