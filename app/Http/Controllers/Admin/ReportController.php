<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use DataTables;
use App\Services\PdfService;

class ReportController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Detailed Clients Report', only: ['detailedClientsReport']),
            new Middleware('permission:View Clients Report', only: ['clientsReport']),
            new Middleware('permission:View Client Suppliers Report', only: ['clientSuppliersReport']),
            new Middleware('permission:View Booking Groups Report', only: ['bookingGroupsReport']),
            new Middleware('permission:View Extra Services Report', only: ['extraServicesReport']),
            new Middleware('permission:View Credit Sales Bookings Report', only: ['creditSalesBookingsReport']),
            new Middleware('permission:View Expenses Report', only: ['expensesReport']),
            new Middleware('permission:View Car Expenses Report', only: ['carExpensesReport']),
            new Middleware('permission:View Car Income Report', only: ['carIncomeReport']),
            new Middleware('permission:View Car Income Expenses Report', only: ['carIncomeExpensesReport']),
            new Middleware('permission:View Car Contracts Due Amount Report', only: ['carContractDueReport']),
            new Middleware('permission:View Trip Analysis Report', only: ['tripAnalysisReport']),
            new Middleware('permission:View Trip Analysis By Sales Area Report', only: ['tripAnalysisBySalesAreaReport']),
        ];
    }

    public function printReport()
    {
        $data = session()->get('reportData');
        $view = session()->get('view');
        $title = session()->get('title');
        $format = session()->get('format', 'A4');
        if (!$data) {
            return abort(404, __('Report data not found.'));
        }
        session()->forget('reportData');
        session()->forget('view');
        session()->forget('title');
        session()->forget('format');
        $pdfService = new PdfService();
        return $pdfService->generatePdf(
            $view, 
            $data, 
            $title,
            $format,
        );
    }

    public function detailedClientsReport(): View
    {
        return view('admin.pages.reports.detailed-clients-report');
    }

    public function clientsReport()
    {
        return view('admin.pages.reports.clients-report');
    }

    public function clientSuppliersReport(): View
    {
        return view('admin.pages.reports.client-suppliers-report');
    }

    public function bookingGroupsReport(): View
    {
        return view('admin.pages.reports.booking-groups-report');
    }

    public function extraServicesReport(): View
    {
        return view('admin.pages.reports.extra-services-report');
    }

    public function creditSalesBookingsReport(): View
    {
        return view('admin.pages.reports.credit-sales-bookings-report');
    }

    public function expensesReport(): View
    {
        return view('admin.pages.reports.expenses-report');
    }

    public function carExpensesReport(): View
    {
        return view('admin.pages.reports.car-expenses-report');
    }

    public function carIncomeReport(): View
    {
        return view('admin.pages.reports.car-income-report');
    }

    public function carIncomeExpensesReport(): View
    {
        return view('admin.pages.reports.car-income-expenses-report');
    }

    public function carContractDueReport(): View
    {
        return view('admin.pages.reports.car-contract-due-report');
    }

    public function tripAnalysisReport(): View
    {
        return view('admin.pages.reports.trip-analysis-report');
    }

    public function tripAnalysisBySalesAreaReport(): View
    {
        return view('admin.pages.reports.trip-analysis-by-sales-area-report');
    }

}
