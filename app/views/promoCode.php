<?php if (!empty($data["promo_code"])): ?>
    <div class="text-success">
        <h6 class="my-0">Promo code</h6>
        <small><?= $data["promo_code"]["description"] ?></small>
    </div>
    
    <span class="text-success"><?= $data["promo_code"]["cost"] ?> <?= strpos($data["promo_code"]["cost"], '%') > 0 ? '' : EURO ?></span>
<?php endif; ?>
