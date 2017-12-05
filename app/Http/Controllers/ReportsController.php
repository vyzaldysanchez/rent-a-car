<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PdfReport;
use Carbon\Carbon;
use App\Models\Rent;

class ReportsController extends Controller
{
    public function find(Request $request)
    {
        $today = Carbon::now()->toDateString();
        $since = ($request->has('since') && $request->query('since') !== 'null') ? $request->query('since') : $today;
        $to = ($request->has('to') && $request->query('to') !== 'null') ? $request->query('to') : Carbon::parse($since)->addDays(1)->toDateString();
        $field = $request->query('field');
        $title = 'Rents report';
        $meta = [
            'Since' => $since,
            ' To' => $to
        ];

        $query = \App\Models\Rent::whereBetween($field, [$since, $to])
            ->with(['vehicle', 'client']);

        $columns = [
            'Vehicle' => function (Rent $rent) {
                return $rent->vehicle->description;
            },
            'Client' => function (Rent $rent) {
                return $rent->client->name;
            },
            'Rented Since' => function (Rent $rent) {
                return Carbon::parse($rent->rent_date)->toFormattedDateString();
            },
            'To be returned' => function (Rent $rent) {
                return Carbon::parse($rent->return_date)->toFormattedDateString();
            },
            'Rent duration' => function (Rent $rent) {
                return $rent->duration_in_days . ' days';
            }
        ];

        return PdfReport::of($title, $meta, $query, $columns)->make()->getDomPDF()
            ->output_html();
    }
}
