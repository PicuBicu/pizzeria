<div class="row g-4">
    <?php foreach ($result as $row) : ?>
        <div class="col" id="<?= $row["id"] ?>">
            <a href="food-details.php?foodId=<?= $row["id"] ?>">
                <div class="card text-center" style="min-height: 285px;">
                    <img src="../img/<?= $row["name"]; ?>.jpg" class="card-img-top mx-auto mt-4" style="height: 125px; width: 200px" alt="<?= $row["name"] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row["name"]; ?></h5>
                        <p class="card-text"><?= $row["ingredients"]; ?></p>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>