<?php include '../../view/header.php'; ?>
<main>
    <section>
        <h1>Today is day <?php echo $current_day; ?></h1>
        <form  action="index.php" method="post" id="add_product_form">
            <input type="hidden" name="action" value="change_to_nextday">
            <input type="submit" value="Change To day <?php echo $current_day + 1; ?>" />
            <br>
        </form>

        <h2>Todays Orders</h2>
        <?php if (count($todays_orders) > 0): ?>

            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Room No</th>
                    <th>Status</th>

                </tr>

                <?php foreach ($todays_orders as $todays_order) : ?>
                    <tr>
                        <td><?php echo $todays_order['id']; ?> </td>
                        <td><?php echo $todays_order['room_number']; ?> </td>  
                        <td><?php
                            if ($todays_order['status'] == 2) {
                                echo 'Baked';
                            } elseif ($todays_order['status'] == 1) {
                                echo 'Preparing';
                            } elseif ($todays_order['status'] == 3) {
                                echo 'Finished';
                            }
                            ?> </td>

                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No Orders Today </p>
        <?php endif; ?>

    </section>


</main>
<?php include '../../view/footer.php'; ?>