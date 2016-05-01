<?php include '../../view/header.php'; ?>
<main>
    <section>
    <h1>Sizes List</h1>

         <!-- display a list of toppings -->
	 <!-- <h2>Toppings</h2> -->
 
        <ul>
        <?php foreach ($sizes as $size) : ?>
            <li>
            <?php echo $size['size_name']; ?>
            </a>
            </li>
        <?php endforeach; ?>
        </ul>
    <p>
        <a href=".?action=show_add_form">Add Size</a>
    </p>
    </section>
</main>
<?php include '../../view/footer.php'; ?>
