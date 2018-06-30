<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\grouptospace\controllers;

use humhub\modules\user\models\Group;
use humhub\modules\user\models\User;
use Yii;
use yii\web\HttpException;
use humhub\modules\user\models\UserPicker;
use humhub\modules\space\models\Space;
use humhub\modules\space\models\Membership;
use humhub\modules\space\models\forms\RequestMembershipForm;
use humhub\modules\user\widgets\UserListBox;

/**
 * SpaceController is the main controller for spaces.
 *
 * It show the space itself and handles all related tasks like following or
 * memberships.
 *
 * @author Luke
 * @package humhub.modules_core.space.controllers
 * @since 0.5
 */
class MembershipController extends \humhub\modules\space\controllers\MembershipController
{

    /**
     * Invite New Members to this workspace
     */
    public function actionInvite()
    {
        $space = $this->getSpace();

        // Check Permissions to Invite
        if (!$space->canInvite()) {
            throw new HttpException(403, Yii::t('SpaceModule.controllers_MembershipController', 'Access denied - You cannot invite members!'));
        }

        $model = new \humhub\modules\grouptospace\models\forms\InviteForm();
        $model->space = $space;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $statusInvite = false;

            if($model->getInviteGroups()) {
                $group_id = intval($model->getInviteGroups());

                $group = new Group(['id' => $group_id]);

                $groupUsers =  $group->getUsers()->all();


                foreach ($groupUsers as $groupUser) {
                    $space->inviteMember($groupUser->id, Yii::$app->user->id);
                    $statusInvite = $space->getMembership($groupUser->id)->status;

                }


            }

            // Invite existing members
            foreach ($model->getInvites() as $user) {
                $space->inviteMember($user->id, Yii::$app->user->id);
                $statusInvite = $space->getMembership($user->id)->status;
            }

            // Invite non existing members
            if (Yii::$app->getModule('user')->settings->get('auth.internalUsersCanInvite')) {
                foreach ($model->getInvitesExternal() as $email) {
                    $statusInvite = ($space->inviteMemberByEMail($email, Yii::$app->user->id)) ? Membership::STATUS_INVITED : false;
                }
            }

            switch ($statusInvite) {
                case Membership::STATUS_INVITED:
                    return \humhub\widgets\ModalClose::widget(['success' => Yii::t('SpaceModule.views_space_statusInvite', 'User has been invited.')]);
                case Membership::STATUS_MEMBER:
                    return \humhub\widgets\ModalClose::widget(['success' => Yii::t('SpaceModule.views_space_statusInvite', 'User has become a member.')]);
                default:
                    return \humhub\widgets\ModalClose::widget(['warn' => Yii::t('SpaceModule.views_space_statusInvite', 'User has not been invited.')]);
            }
        }


        return $this->renderAjax('invite', array('model' => $model, 'space' => $space));
    }


}

?>
