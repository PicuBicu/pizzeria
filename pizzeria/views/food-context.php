<div class="container">
    <div class="row">
        <div class="my-5">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-xl-5 text-center">
                        <img class="img-fluid" src="/img/<?= $foodDetails["name"] ?>.jpg" style="min-width:200px; min-height:200px" />
                    </div>
                    <div class="col-xl-7">
                        <div class="card-body">
                            <h4 class="card-title"><?= $foodDetails["name"] ?></h4>
                            <p class="card-text"><?= $foodDetails["ingredients"] ?></p>
                            <form action="controllers/basket_add.php?foodId=<?= $foodId ?>" method="post">
                                <div class="hstack gap-2 mb-2">
                                    <label class="form-label" for="size" style="width: 100px">Rozmiar: </label>
                                    <select class="form-select form-select" name="size" style="width: 145px">
                                        <option value="mała">Mała <?= $foodDetails["mała"] ?> zł</option>
                                        <option selected value="średnia">Średnia <?= $foodDetails["średnia"] ?> zł</option>
                                        <option value="duża">Duża <?= $foodDetails["duża"] ?> zł</option>
                                    </select>
                                </div>
                                <div class="hstack gap-2 mb-2">
                                    <label class="form-label" for="quantity" style="width: 100px">Ilość: </label>
                                    <input type="number" id="quantity" name="quantity" class="form-control mb-2" style="width: 145px" min="1" max="5" value="1">
                                </div>
                                <button type="submit" class="btn btn-primary">Dodaj do koszyka</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>