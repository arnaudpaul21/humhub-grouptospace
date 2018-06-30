<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */
namespace humhub\modules\grouptospace;

use yii\helpers\Url;

class Module extends \humhub\components\Module
{

    public function disable()
    {
        return parent::disable();
        // what needs to be done if module is completely disabled?
    }

    public function enable()
    {
        return parent::enable();
        // what needs to be done if module is enabled?
    }

}