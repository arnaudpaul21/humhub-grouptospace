<?php
namespace humhub\modules\grouptospace\widgets;

use humhub\modules\user\models\Group;
use Yii;

/**
 * Description of InviteModal
 *
 * @author buddha
 */
class InviteModal extends \yii\base\Widget
{
    public $submitText;
    public $submitAction;
    public $model;
    public $attribute;
    public $searchUrl;

    public function run()
    {
        if(!$this->attribute) {
            $this->attribute = 'invite';
        }

        $groups = Group::find()->all();


        $groupsFormated = ['' => Yii::t('GrouptospaceModule.base', 'Select a group to invite')];
        foreach ($groups as $group) {
            $groupsFormated[$group->id] = $group->name;
        }




        return $this->render('inviteModal', [
            'canInviteExternal' => Yii::$app->getModule('user')->settings->get('auth.internalUsersCanInvite'),
            'canInviteGroups' => Yii::$app->user->isAdmin(),
            'submitText' => $this->submitText,
            'submitAction' => $this->submitAction,
            'model' => $this->model,
            'attribute' => $this->attribute,
            'searchUrl' => $this->searchUrl,
            'groups' => $groupsFormated
        ]);
    }
}
