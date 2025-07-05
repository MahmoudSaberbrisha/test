<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Client;
use App\Models\Booking;
use App\Models\BookingGroup;
use App\Models\SailingBoat;
use App\Models\BookingExtraService;
use App\Models\ExtraService;
use Modules\AdminRoleAuthModule\Models\Currency;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $data = [];
        $data['active_clients'] = Client::where('active', 1)->count();
        $data['active_booking_groups'] = BookingGroup::where('active', 1)->count();
        $data['active_sailing_boats'] = SailingBoat::where('active', 1)->count();
        $data['active_extra_services'] = ExtraService::where('active', 1)->count();
        
        $bookings = Booking::with([
                'booking_groups' => function($query) {
                    $query->with([
                        "client",
                        "booking_group_members",
                        "booking_group_payments",
                        "booking_group_services",
                        "client_supplier",
                        "currency" => function ($query) {
                            $query->withTranslation(); 
                        }
                    ]);
                },
                'branch' => function ($query) {
                    $query->withTranslation(); 
                },
                'sailing_boat' => function ($query) {
                    $query->withTranslation(); 
                },
                'type' => function ($query) {
                    $query->withTranslation(); 
                }
            ])
            ->whereHas('booking_groups')
            ->get();

        $data['calendarEvents'] = $bookings->map(function ($booking) {
            $now = Carbon::now();
            $start = Carbon::parse($booking->booking_date->format('Y-m-d') . ' ' . $booking->start_time->format('H:i:s'));
            $end = Carbon::parse($booking->booking_date->format('Y-m-d') . ' ' . $booking->end_time->format('H:i:s'));

            $hasInactiveGroups = $booking->booking_groups->contains('active', 0);
            if ($hasInactiveGroups) {
                $color = 'red';
            } elseif ($now->between($start, $end)) {
                $color = 'green';
            } elseif ($now->greaterThan($end)) {
                $color = 'orange';
            } else {
                $color = '#007bff';
            }

            $totalMembers = $booking->booking_groups->sum(function($group) {
                return $group->booking_group_members->sum('members_count');
            });

            return [
                'id' => $booking->id,
                'title' => '<i class="fas fa-sailboat" title="'.__('Click for details').'" style="cursor: pointer;"></i> '.__(BOOKING_TYPES[$booking->booking_type]).' #' . $booking->sailing_boat->name,
                'start' => $start,
                'end' => $end,
                'color' => $color,
                'booking' => $booking,
                'totalMembers' => $totalMembers,
                'isGrouped' => $booking->booking_groups->count() > 1
            ];
        });

        $currentYear = Carbon::now()->year;
        $lastYear = Carbon::now()->subYear()->year;

        $data['this_year_booking_groups'] = BookingGroup::with('currency')
            ->select('currency_id', DB::raw('SUM(total) as total_amount'))
            ->whereHas('booking', function ($query) use ($currentYear) {
                $query->whereYear('booking_date', $currentYear);
            })
            ->groupBy('currency_id')
            ->get();

        $currencies = Currency::withTranslation()->get();

        $bookingGroups = Booking::join('booking_groups', 'bookings.id', '=', 'booking_groups.booking_id')
            ->select(
                DB::raw('MONTH(bookings.booking_date) as month'),
                'booking_groups.currency_id',
                DB::raw('SUM(booking_groups.total) as total_amount')
            )
            ->whereYear('bookings.booking_date', $currentYear)
            ->groupBy(DB::raw('MONTH(bookings.booking_date)'), 'booking_groups.currency_id')
            ->orderBy(DB::raw('MONTH(bookings.booking_date)'))
            ->get();

        $formattedData = [];
        $color = [];
        foreach ($currencies as  $currency) {
            $formattedData[$currency->id] = [
                'name' => $currency->name,
                'data' => array_fill(0, 12, 0) ,
                'color' => $currency->color
            ];
        }
        foreach ($bookingGroups as $bookingGroup) {
            $formattedData[$bookingGroup->currency_id]['data'][$bookingGroup->month - 1] = $bookingGroup->total_amount;
        }
        $data['thisYearBookingGroupsBar'] = json_encode(array_values($formattedData));
        $data['bookingGroupsBarColors'] = json_encode(array_column($formattedData, 'color'));

        $data['lastSixMonth'] = BookingGroup::join('bookings', 'booking_groups.booking_id', '=', 'bookings.id')
            ->select(
                DB::raw("SUM(booking_groups.total) as total"),
                DB::raw("SUM(booking_groups.discounted) as discounted"),
                DB::raw("SUM(booking_groups.price) as price")
            )
            ->where('bookings.booking_date', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->first();


// dd($data['last_year_bookings']);
// dd($data['lastSixMonth']);
        return view('admin.pages.dashboard', $data);
    }
}
