<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\modules\orders\helpers\ServicesHelper;
use app\modules\orders\models\Orders;
$currentStatus = Yii::$app->request->getQueryParams()['status'] ?? null;

//echo '<pre>';var_dump($orders);die;
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
                    <li class="active"><a href="#">Orders</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <ul class="nav nav-tabs p-b">
            <li class="active"><a href="#">All orders</a></li>
            <?php foreach (Orders::STATUS_DICT as $key => $value) : ?>
                <li><a href="<?= Url::current(['status' => $key, 'service' => null, 'mode' => null])?>"><?= Yii::t('app', $value) ?></a></li>
            <?php endforeach; ?>
            <li class="pull-right custom-search">
                <form class="form-inline" action="index" method="get">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                        <?php if ($currentStatus) : ?>
                            <input type="hidden" name="status" value="<?= $currentStatus ?>">
                        <?php endif; ?>
                        <span class="input-group-btn search-select-wrap">
                            <select class="form-control search-select" name="search-type">
                               <option value="1" selected="">Order ID</option>
                               <option value="2">Link</option>
                               <option value="3">Username</option>
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
                <th>ID</th>
                <th>User</th>
                <th>Link</th>
                <th>Quantity</th>
                <th class="dropdown-th">
                    <div class="dropdown">
                        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Service
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li class="active"><a href="">All (<?= count($orders) ?>)</a></li>
                            <?php foreach (ServicesHelper::getServices() as $service) : ?>
                            <li>
                                <a href="<?= Url::current(['service' => $service['service_id']])?>">
                                    <span class="label-id"><?= $service['cnt'] ?></span> <?= $service['name'] ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </th>
                <th>Status</th>
                <th class="dropdown-th">
                    <div class="dropdown">
                        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Mode
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li class="active"><a href="<?= Url::current(['mode' => null])?>">All</a></li>
                            <?php foreach (Orders::MODE_DICT as $key => $value) : ?>
                                <li><a href="<?= Url::current(['mode' => $key])?>"><?= Yii::t('app', $value) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </th>
                <th>Created</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order->users->first_name . ' ' . $order->users->last_name ?></td>
                    <td class="link"><?= $order['link'] ?></td>
                    <td><?= $order['quantity'] ?></td>
                    <td class="service">
                        <span class="label-id"><?= $order['service_id'] ?></span><?= Yii::t('app', $order->services->name) ?>
                    </td>
                    <td><?= $order['status'] ?></td>
                    <td><?= $order['mode'] ?></td>
                    <td>
                        <span class="nowrap"><?= Yii::$app->formatter->asDate($order['created_at'], 'yyyy-mm-dd') ?></span>
                        <span class="nowrap"><?= Yii::$app->formatter->asTime($order['created_at']) ?></span>
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
                <?= $pages->getOffset() ?> to
                <?= ($pages->page + 1) * $pages->pageSize > $pages->totalCount
                    ? $pages->totalCount
                    : ($pages->page + 1) * $pages->pageSize ?> of
                <?= $pages->totalCount ?>
            </div>

        </div>
    </div>
</body>
