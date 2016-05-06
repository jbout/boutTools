<?php
use oat\tao\helpers\Template;
?>
<header class="section-header flex-container-full">
    <h2><?=get_data('label')?></h2>
</header>
<div class="main-container flex-container-main-form">
    <div class="form-content">
        <p><?= get_data('id')?></p>
        <p><?= urlencode(get_data('id'))?></p>
        <p><?= \tao_helpers_Uri::encode(get_data('id'))?></p>
    </div>
</div>

<?php Template::inc('footer.tpl', 'tao'); ?>
