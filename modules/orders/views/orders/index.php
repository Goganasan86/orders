<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\modules\orders\widgets\PaginationInfo;
use app\modules\orders\models\Orders;
use app\modules\orders\models\search\OrdersSearch;
use app\modules\orders\helpers\ServicesHelper;

$currentParams = Yii::$app->request->getQueryParams();
$currentStatus = $currentParams['status'] ?? null;
?>

<body>
    <nav class="navbar navbar-fixed-top navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bs-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#"><?= Yii::t('app', 'Orders') ?></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <ul class="nav nav-tabs p-b">
            <li class="<?= isset($currentStatus) ? '' : 'active'?>">
                <a href="<?= Url::to('orders')?>"><?= Yii::t('app', 'orders.status.all_orders') ?></a>
            </li>
            <?php foreach (Orders::STATUS_DICT as $key => $value) : ?>
                <li class="<?= $currentStatus === strval($key) ? 'active' : ''?>">
                    <a href="<?= Url::current(['status' => $key, 'service' => null, 'mode' => null])?>"><?= Yii::t('app', $value) ?></a>
                </li>
            <?php endforeach; ?>
            <li class="pull-right custom-search">
                <form class="form-inline" action="orders" method="get">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" value="" placeholder="<?= Yii::t('app', 'orders.save.search_orders') ?>">
                        <?php if ($currentStatus) : ?>
                            <input type="hidden" name="status" value="<?= $currentStatus ?>">
                        <?php endif; ?>
                        <span class="input-group-btn search-select-wrap">
                            <select class="form-control search-select" name="search-type">
                               <option value="<?= OrdersSearch::ID_SEARCH ?>" selected=""><?= Yii::t('app', 'orders.search.order_id') ?></option>
                               <option value="<?= OrdersSearch::LINK_SEARCH ?>"><?= Yii::t('app', 'orders.search.link') ?></option>
                               <option value="<?= OrdersSearch::USERNAME_SEARCH ?>"><?= Yii::t('app', 'orders.search.username') ?></option>
                            </select>
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </button>
                        </span>
                    </div>
                </form>
            </li>
        </ul>
        <table class="table order-table">
            <thead>
            <tr>
                <th><?= Yii::t('app', 'orders.orders.id') ?></th>
                <th><?= Yii::t('app', 'orders.orders.user') ?></th>
                <th><?= Yii::t('app', 'orders.orders.link') ?></th>
                <th><?= Yii::t('app', 'orders.orders.quantity') ?></th>
                <th class="dropdown-th">
                    <div class="dropdown">
                        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?= Yii::t('app', 'orders.orders.service') ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li class="active"><a href="">All (<?= $pages->totalCount ?>)</a></li>
                            <?php foreach ($services as $service) : ?>
                            <li>
                                <a href="<?= Url::current(['service' => $service['id']])?>">
                                    <span class="label-id"><?= $service['cnt'] ?></span> <?= $service['name'] ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </th>
                <th><?= Yii::t('app', 'orders.orders.status') ?></th>
                <th class="dropdown-th">
                    <div class="dropdown">
                        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?= Yii::t('app', 'orders.orders.mode') ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li class="active"><a href="<?= Url::current(['mode' => null])?>"><?= Yii::t('app', 'orders.mode.all') ?></a></li>
                            <?php foreach (Orders::MODE_DICT as $key => $value) : ?>
                                <li><a href="<?= Url::current(['mode' => $key])?>"><?= Yii::t('app', $value) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </th>
                <th><?= Yii::t('app', 'orders.orders.created') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order) :?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['user']?></td>
                    <td class="link"><?= $order['link'] ?></td>
                    <td><?= $order['quantity'] ?></td>
                    <td class="service">
                        <span class="label-id"><?= ServicesHelper::getServicesCount($services, $order['service_id'])?>
                        </span><?= Yii::t('app', $order['service_name']) ?>
                    </td>
                    <td><?= $order['status'] ?></td>
                    <td><?= $order['mode'] ?></td>
                    <td>
                        <span class="nowrap"><?= $order['created_date'] ?></span>
                        <span class="nowrap"><?= $order['created_time'] ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-8">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                ]); ?>
            </div>
            <div class="col-sm-4 pagination-counters">
                <?= PaginationInfo::widget([
                    'pages' => $pages,
                ]); ?>
            </div>
        </div>

        <div class="pull-right">
            <a class="btn btn-th btn-default" href="<?= Url::to(['orders/export-csv', 'params' => $currentParams])?>">
                <?= Yii::t('app', 'orders.save.btn') ?>
            </a>
        </div>
    </div>
</body>
