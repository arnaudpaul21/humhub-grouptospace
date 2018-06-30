<?php

use humhub\modules\search\engine\Search;
use humhub\modules\user\models\User;
use humhub\modules\space\Events;
use humhub\components\console\Application;
use humhub\modules\space\models\forms\InviteForm;
use humhub\modules\space\widgets\InviteModal;

return [
    'id' => 'grouptospace',
    'class' => 'humhub\modules\grouptospace\Module',
    'namespace' => 'humhub\modules\grouptospace',

];
?>