<?php
use oat\tao\helpers\Template;
?>
<div class="main-container flex-container-main-form">
    <div class="form-content">
        <form id= 'payload-form' method="POST" action="<?= _url("callback", "Connect", "taoOpenId")?>" style="height: 600px">
            <textarea id='payload' name='id_token' style="width: 50%; height: 100%">eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6ImEzck1VZ01Gdjl0UGNsTGE2eUYzekFrZnF1RSIsImtpZCI6ImEzck1VZ01Gdjl0UGNsTGE2eUYzekFrZnF1RSJ9.eyJpc3MiOiJodHRwczovL2lzM2Rldi5uY2Nlci5vcmcvaWRlbnRpdHkiLCJhdWQiOiJ0YW9pbXBsaWNpdHRlc3QiLCJleHAiOjE0ODkxNDI4MTIsIm5iZiI6MTQ4OTE0MjUxMiwibm9uY2UiOiJmZDg3Y2M1N2QwZjQ0Mzc3YWY1ZDYyYmQyOWE1ZjBkZCIsImlhdCI6MTQ4OTE0MjUxMiwic2lkIjoiMzc1YWYwMjkxMWQzMmQ2ZTIwOTc4Nzc3YjYyZWVlNzUiLCJzdWIiOiI5OTQxODU3IiwiYXV0aF90aW1lIjoxNDg5MTQyNDQyLCJpZHAiOiJpZHNydiIsImdpdmVuX25hbWUiOiJGcmFuY2lzIiwiZmFtaWx5X25hbWUiOiJUYW1vbmRvbmciLCJlbWFpbCI6Indhd2FAd2F3YS5jb20iLCJyb2xlIjoiRXh0ZXJuYWxVc2VyIiwiTkNDRVJPcmciOlsie1wiT3JnSURcIjoxNjkzLFwiTkNDRVJSb2xlc1wiOlwiMjEsMzksMTAsMTcsNlwifSIsIntcIk9yZ0lEXCI6MTY5NCxcIk5DQ0VSUm9sZXNcIjpcIjIwXCJ9Il0sImFtciI6WyJwYXNzd29yZCJdfQ.</textarea>
            <br/>
            <button class="js-submit"><?= __('Send') ?></button>
        </form>
    </div>
</div>