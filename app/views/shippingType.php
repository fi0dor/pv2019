<?php if (!empty($data["shipping_type"])): ?>
    <div class="text-info">
        <h6 class="my-0">Shipping</h6>
        <small><?= $data["shipping_type"]["description"] ?></small>
    </div>
    
    <span class="text-info"><?= $data["shipping_type"]["cost"] ?>&nbsp;<?= strpos($data["shipping_type"]["cost"], '%') > 0 ? '' : EURO ?></span>
<?php endif; ?>
