<?php
if (isset($_SESSION["alertMessage"]) && isset($_SESSION["alertType"])) : ?>
    <div class="alert alert-<?php echo $_SESSION["alertType"] ?>" role="alert">
        <?php echo $_SESSION["alertMessage"]; ?>
    </div>
<?php endif;
unset($_SESSION["alertMessage"]);
unset($_SESSION["alertType"]);
?>