<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    Yajra\DataTables\DataTablesServiceProvider::class,
    Maatwebsite\Excel\ExcelServiceProvider::class,
    OwenIt\Auditing\AuditingServiceProvider::class,
];
