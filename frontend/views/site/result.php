<?php

/* @var $this yii\web\View */
/* @var $status string */
/* @var $messages array */

$this->title = 'Результат обновления каталога';
?>
<div class="col-md-offset-2 col-md-8 content">
    <h1>Результат загрузки: <?= $status?></h1>
    <div>
        <?php
            foreach ($messages as $messagesBlock)
            foreach ($messagesBlock as $field => $messageList) {
                echo "$field:<br>";
                foreach ($messageList as $message) {
                    echo " * $message<br>";
                }
            }
        ?>
    </div>
</div>
