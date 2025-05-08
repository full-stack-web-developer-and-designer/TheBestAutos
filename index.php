<?php include "./inc/head.php" ?>
<body>

<?php include "objects.php" ?>

<div class='outer-div'>
<h1><?php echo "The Best Autos" ?></h1>
<p class="slogan">Where everyone can afford to buy a vehicle!</p>

<table class="vehicle-table" id="vehicle-table">
    <colgroup>
        <col width="20%"><col width="80%">
    </colgroup>
    <tbody>
        <!-- rows of vehicles -->
        <?php foreach($vehicles as $vehicle) {

            $mileage = $vehicle->getFormattedMileage();
            $price = $vehicle->getFormattedPrice();
            $options = $vehicle->getOptions();
           
            $engineSpan = "";
            if (property_exists($vehicle, "engine")){
                $engineSpan = "<span class='data-label'>Engine type: </span><span class='vehicle-engine'>$vehicle->engine</span> ";
            }

            echo <<<FOREACHVEHICLE
            <tr>
                <td class="top-aligned">
                    <img class="thumbnail" src="images/$vehicle->image" alt="vehicle picture">
                </td>
                <td>
                    <p class="vehicle-make">$vehicle->make</p>
                    <p class="vehicle-model">$vehicle->model</p>
                    <hr class="vehicle-hr">
                    <p class="right-aligned">$engineSpan<span class="data-label">Year: </span><span class="vehicle-year">$vehicle->year</span>
                    &nbsp;&nbsp;<span class="data-label">Mileage: </span><span class="vehicle-mileage">$vehicle->mileage</span></p>
                    <p class="vehicle-price right-aligned">$$price</p>
                    <p class="right-aligned vehicle-options">Options: $options
                    </p>

                    <!-- form for payment calculation -->

                    <form action="payment-plan.php" method="post">
                        <input type="hidden" name="make" value="$vehicle->make">
                        <input type="hidden" name="model" value="$vehicle->model">
                        <input type="hidden" name="price" value="$vehicle->price">
                        <input type="hidden" name="image" value="$vehicle->image">
                        <p>Choose your repayment duration: 
                            <select id="repayment-duration" name="repayment-duration">
                                <option value="24">24</option>
                                <option value="36">36</option>
                                <option value="48">48</option>
                                <option value="60">60</option>
                            </select>
                            months
                        </p>
                        <p>Choose your credit health:
                            <select id="interest-rate" name="interest-rate">
                                <option value="2.99">Excellent credit 2.99% APR</option>
                                <option value="7.99">Average credit 7.99% APR</option>
                                <option value="13.99">In a financial crunch 13.99% APR</option>
                            </select>
                            <br /><br />
                        <p class="right-aligned"><button type="submit">See your personalised payment plan &gt;&gt;&gt;</button></p>
                    </form>

                    <hr />
                </td>
            </tr>
            FOREACHVEHICLE;
        }
        ?>
    </tbody>

</table>
</div>

</body>

<footer id="footer" class="centered">
    <?php include "./inc/footer.php" ?>
</footer>

</html>