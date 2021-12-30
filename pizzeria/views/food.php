<div class="row g-4">

    <?php foreach ($result as $row) : ?>
        <div class="col" id="<?php echo $row["id"] ?>">
            <a href="food.php?foodId=<?php echo $row["id"] ?>">
                <div class="card text-center" style="min-height: 285px;">
                    <img src="../img/<?php echo $row["name"]; ?>.jpg" class="card-img-top mx-auto mt-4" style="height: 125px; width: 200px" alt="<?php echo $row["name"] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                        <p class="card-text"><?php echo $row["ingredients"]; ?></p>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>