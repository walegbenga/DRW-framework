<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 18/12/18
* Time : 21:53
*/

namespace Generic\Route;

interface Route{
    public function getRoutes(): array;
    public function getAuthentication(): \Generic\Authentication;
    public function checkPermission($permission): bool;
    #public function execute($cn = []): array;
}