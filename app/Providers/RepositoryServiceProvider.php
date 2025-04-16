<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Settings\DBClientSuppliersRepository;
use App\Repositories\Settings\DBGoodsRepository;
use App\Repositories\Settings\DBJobsRepository;
use App\Repositories\Settings\DBPaymentMethodsRepository;
use App\Repositories\Settings\DBClientTypesRepository;
use App\Repositories\Settings\DBSailingBoatsRepository;
use App\Repositories\Settings\DBSalesAreasRepository;
use App\Repositories\Settings\DBGoodSuppliersRepository;
use App\Repositories\Settings\DBExpensesTypesRepository;
use App\Repositories\Settings\DBExperienceTypeRepository;
use App\Repositories\ClientsManagement\DBClientsRepository;
use App\RepositoryInterface\FeedBackRepositoryInterface;
use App\Repositories\ClientsManagement\DBFeedBackRepository;
use App\RepositoryInterface\BookingRepositoryInterface;
use App\Repositories\DBBookingsRepository;
use App\RepositoryInterface\BookingGroupRepositoryInterface;
use App\Repositories\DBBookingGroupsRepository;
use App\RepositoryInterface\ExtraServicesInterface;
use App\Repositories\DBExtraServicesRepository;
use App\RepositoryInterface\BookingGroupServicesInterface;
use App\Repositories\DBBookingGroupServicesRepository;
use App\Repositories\FinancialManagement\DBAccountTypesRepository;
use App\Repositories\FinancialManagement\DBAccountsRepository;
use App\RepositoryInterface\ExpenseRepositoryInterface;
use App\Repositories\FinancialManagement\DBExpensesRepository;
use App\Repositories\EmployeeManagement\DBEmployeeTypesRepository;
use App\Repositories\EmployeeManagement\DBEmployeeNationalitiesRepository;
use App\Repositories\EmployeeManagement\DBEmployeeReligionsRepository;
use App\Repositories\EmployeeManagement\DBEmployeeMaritalStatusRepository;
use App\Repositories\EmployeeManagement\DBEmployeeIdentityTypesRepository;
use App\Repositories\EmployeeManagement\DBEmployeeCardIssuersRepository;
use App\RepositoryInterface\EmployeeRepositoryInterface;
use App\Repositories\EmployeeManagement\DBEmployeesRepository;
use App\Repositories\CarManagement\DBCarSuppliersRepository;
use App\Repositories\CarManagement\DBCarContractsRepository;
use App\Repositories\CarManagement\DBCarExpensesRepository;
use App\Repositories\CarManagement\DBCarTasksRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('ClientSupplierCrudRepository', function($app) {
            return new DBClientSuppliersRepository();
        });
        $this->app->bind('GoodCrudRepository', function($app) {
            return new DBGoodsRepository();
        });
        $this->app->bind('JobCrudRepository', function($app) {
            return new DBJobsRepository();
        });
        $this->app->bind('PaymentMethodCrudRepository', function($app) {
            return new DBPaymentMethodsRepository();
        });
        $this->app->bind('ClientTypeCrudRepository', function($app) {
            return new DBClientTypesRepository();
        });
        $this->app->bind('SailingBoatCrudRepository', function($app) {
            return new DBSailingBoatsRepository();
        });
        $this->app->bind('SalesAreaCrudRepository', function($app) {
            return new DBSalesAreasRepository();
        });
        $this->app->bind('GoodSupplierCrudRepository', function($app) {
            return new DBGoodSuppliersRepository();
        });
        $this->app->bind('ExpensesTypeCrudRepository', function($app) {
            return new DBExpensesTypesRepository();
        });
        $this->app->bind('ExperienceTypeCrudRepository', function($app) {
            return new DBExperienceTypeRepository();
        });
        $this->app->bind('ClientCrudRepository', function($app) {
            return new DBClientsRepository();
        });
        $this->app->bind('EmployeeTypeCrudRepository', function($app) {
            return new DBEmployeeTypesRepository();
        });
        $this->app->bind('EmployeeNationalityCrudRepository', function($app) {
            return new DBEmployeeNationalitiesRepository();
        });
        $this->app->bind('EmployeeReligionCrudRepository', function($app) {
            return new DBEmployeeReligionsRepository();
        });
        $this->app->bind('EmployeeMaritalStatusCrudRepository', function($app) {
            return new DBEmployeeMaritalStatusRepository();
        });
        $this->app->bind('EmployeeIdentityTypeCrudRepository', function($app) {
            return new DBEmployeeIdentityTypesRepository();
        });
        $this->app->bind('EmployeeCardIssuerCrudRepository', function($app) {
            return new DBEmployeeCardIssuersRepository();
        });
        $this->app->bind('CarSupplierCrudRepository', function($app) {
            return new DBCarSuppliersRepository();
        });
        $this->app->bind('CarContractCrudRepository', function($app) {
            return new DBCarContractsRepository();
        });
        $this->app->bind('CarExpensesCrudRepository', function($app) {
            return new DBCarExpensesRepository();
        });
        $this->app->bind('CarTaskCrudRepository', function($app) {
            return new DBCarTasksRepository();
        });
        $this->app->bind(FeedBackRepositoryInterface::class, DBFeedBackRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, DBBookingsRepository::class);
        $this->app->bind(BookingGroupRepositoryInterface::class, DBBookingGroupsRepository::class);
        $this->app->bind(ExtraServicesInterface::class, DBExtraServicesRepository::class);
        $this->app->bind(BookingGroupServicesInterface::class, DBBookingGroupServicesRepository::class);
        $this->app->bind('AccountTypeCrudRepository', function($app) {
            return new DBAccountTypesRepository();
        });
        $this->app->bind('AccountCrudRepository', function($app) {
            return new DBAccountsRepository();
        });
        $this->app->bind(ExpenseRepositoryInterface::class, DBExpensesRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, DBEmployeesRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
