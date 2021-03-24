<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <style>
        .label-default{
            border: 1px solid #ddd;
            background: none;
            color: #333;
            min-width: 30px;
            display: inline-block;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
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
        <li><a href="<?= Url::to(['orders/index', 'status' => '0'])?>">Pending</a></li>
        <li><a href="<?= Url::to(['orders/index', 'status' => '1'])?>">In progress</a></li>
        <li><a href="<?= Url::to(['orders/index', 'status' => '2'])?>">Completed</a></li>
        <li><a href="<?= Url::to(['orders/index', 'status' => '3'])?>">Canceled</a></li>
        <li><a href="<?= Url::to(['orders/index', 'status' => '4'])?>">Error</a></li>
        <li class="pull-right custom-search">
            <form class="form-inline" action="index" method="get">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                    <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
              <option value="1" selected="">Order ID</option>
              <option value="2">Link</option>
              <option value="3">Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
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
                        <?php foreach ($services as $service) : ?>
                        <li>
                            <a href="<?= Url::to(['orders/index', 'service' => $service['id']])?>">
                                <span class="label-id">214</span> <?= $service['name'] ?>
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
                        <li class="active"><a href="<?= Url::to(['orders/index', 'mode' => '0'])?>">All</a></li>
                        <li><a href="<?= Url::to(['orders/index', 'mode' => '1'])?>">Manual</a></li>
                        <li><a href="<?= Url::to(['orders/index', 'mode' => '2'])?>">Auto</a></li>
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
                <td><?= $order['user_id'] ?></td>
                <td class="link"><?= $order['link'] ?></td>
                <td><?= $order['quantity'] ?></td>
                <td class="service">
                    <span class="label-id"><?= $order['service_id'] ?></span>Likes
                </td>
                <td><?= $order['status'] ?></td>
                <td><?= $order['mode'] ?></td>
                <td><span class="nowrap"><?= Yii::$app->formatter->asDate($order['created_at'], 'yyyy-mm-dd') ?></span>
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
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
<html>