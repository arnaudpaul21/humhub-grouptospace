<button class="btn btn-primary" data-action-click="ui.modal.load" data-action-url="<?= class_exists('humhub\modules\grouptospace\controllers\MembershipController') ?  $space->createUrl('/grouptospace/membership/invite') : $space->createUrl('/space/membership/invite') ?>">
    <i class="fa fa-plus"></i> <?= Yii::t('SpaceModule.widgets_views_inviteButton', 'Invite') ?>
</button>