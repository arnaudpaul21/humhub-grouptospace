<?= \humhub\modules\grouptospace\widgets\InviteModal::widget([
    'model' => $model,
    'submitText' => Yii::t('SpaceModule.views_space_invite', 'Send'),
    'submitAction' => $space->createUrl('/grouptospace/membership/invite'),
    'searchUrl' => $space->createUrl('/grouptospace/membership/search-invite')
]); ?>