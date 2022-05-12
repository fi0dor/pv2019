<?php if (!empty($data["promo_code"]) && !empty($data["promo_value"])): ?>
    <div class="text-success">
        <h6 class="my-0">Promo code</h6>
        <small><?= $data["promo_code"] ?></small>
    </div>
    
    <span class="text-success"><?= $data["promo_value"] ?>&nbsp;<?= strpos($data["promo_value"], '%') > 0 ? '' : EURO ?></span>
<?php endif; ?>
