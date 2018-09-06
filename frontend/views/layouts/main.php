<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\components\Helpers;

use frontend\models\Images;

AppAsset::register($this);
$baseUrl = Yii::$app->homeUrl;
$host = Yii::$app->params['domain'];
$root = Yii::$app->params['root'];
$resurl = Yii::$app->params['resurl'];

$helpers = new helpers;
$avatar = $helpers->getAvatar();
$message = $helpers->getMessageCount();
//var_dump(memory_get_usage());
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <script type="text/javascript">var weburl = '<?= $host.$root ?>';</script>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark navbar-fixed-top scrolling-navbar',
        ],
    ]);
    $menuItems = [
        //['label' => 'Index', 'url' => ['/site/index']],
        //['label' => 'About', 'url' => ['/site/about']],
        //['label' => 'Contact', 'url' => ['/site/contact']],
    ];

    $menuItems[] = '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Discover<span class="caret"></span></a>'
            . '<ul class="dropdown-menu">'
            . '<li><a class="dropdown-item" href="'.$baseUrl.'site/new">New Release</a></li>'
            . '<li><a class="dropdown-item" href="'.$baseUrl.'site/trending">Trending</a></li>'
            . '<li><a class="dropdown-item" href="'.$baseUrl.'site/following">Following</a></li>'
            . '<li><a class="dropdown-item" href="'.$baseUrl.'genre">Genre</a></li>'
            . '<li><a class="dropdown-item" href="'.$baseUrl.'starter">Listen</a></li>'
            . '<li><a class="dropdown-item" href="'.$baseUrl.'playlist">Playlist</a></li>'
            . '</ul></li>';

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/user/registration/register']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/security/login']];
    } else {
        $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        $rolename = 'starter';

        if (isset($role)) {
            foreach ($role as $key => $value) {
                $rolename = $key;
            }
        }

        $menuItems[] = ['label' => 'My Homepage', 'url' => ['/'. $rolename .'/index']];

        $menuItems[] = '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img id="user_photo" width="20" height="20" src="'.$avatar.'"> '.Yii::$app->user->identity->username.'<span class="caret"></span></a>'
            . '<ul class="dropdown-menu">'
            . '<li><a class="dropdown-item" href="'.$baseUrl.'site/photo">Update Photo</a></li>'
            . '<li><a class="dropdown-item" href="'.$baseUrl.'user/settings/profile">Update Profile</a></li>'
            . '<li><a class="dropdown-item" href="'.$baseUrl.'user/settings/account">Update Account</a></li>'
            . '<li><a class="dropdown-item" href="'.$baseUrl.'user/settings/social">Social Links</a></li>'
            . '</ul></li>';

        if ($message != 0) {
            $menuItems[] = '<li><a href="'.$baseUrl.'site/message"><i class="far fa-envelope fa-lg"></i> <span class="badge badge-pill red small"  id="msgli" count='.$message.'>'.$message.'</span></a><a class="loadnumber hidden">load messages</a></li>';
        } else {
            $menuItems[] = '<li><a href="'.$baseUrl.'site/message"><i class="far fa-envelope fa-lg"></i> <span class="badge badge-pill small"  id="msgli" count='.$message.'>'.$message.'</span></a><a class="loadnumber hidden">load messages</a></li>';
        }
        
        $menuItems[] = '<li>'
            . Html::beginForm(['/user/security/logout'], 'post')
            . Html::submitButton(
                'Logout',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
            
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
