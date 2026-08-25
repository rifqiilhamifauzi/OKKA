<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Inertia\Inertia;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::withCount(['registrations as approved_registrations_count' => function ($q) {
            $q->where('status', 'approved');
        }])->orderBy('created_at', 'desc');

        if ($request->has('event_id') && $request->event_id !== 'all') {
            $query->where('id', $request->event_id);
        }

        $events = $query->get();

        // Calculate subtotals per event and grand total
        $grandTotal = 0;
        $totalApprovedParticipants = 0;

        $eventFinances = $events->map(function ($event) use (&$grandTotal, &$totalApprovedParticipants) {
            $subtotal = $event->approved_registrations_count * $event->registration_fee;
            
            $grandTotal += $subtotal;
            $totalApprovedParticipants += $event->approved_registrations_count;

            return [
                'id' => $event->id,
                'name' => $event->name,
                'slug' => $event->slug,
                'registration_fee' => $event->registration_fee,
                'status' => $event->status,
                'approved_count' => $event->approved_registrations_count,
                'subtotal' => $subtotal,
            ];
        });

        $allEvents = Event::orderBy('created_at', 'desc')->get();

        return Inertia::render('Admin/Finance/Index', [
            'eventFinances' => $eventFinances,
            'allEvents' => $allEvents,
            'summary' => [
                'grand_total' => $grandTotal,
                'total_approved_participants' => $totalApprovedParticipants,
            ],
            'filters' => ['event_id' => $request->event_id ?? 'all'],
        ]);
    }

    public function export(Request $request)
    {
        $query = \App\Models\Registration::with(['user', 'event', 'detail'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc');

        if ($request->has('event_id') && $request->event_id !== 'all') {
            $query->where('event_id', $request->event_id);
        }

        $registrations = $query->get();

        $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($registrations) {
            $handle = fopen('php://output', 'w');
            
            // Write BOM for proper UTF-8 Excel support
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Headers
            fputcsv($handle, [
                'No',
                'Nomor Pendaftaran',
                'Nama Lengkap',
                'Email',
                'Event',
                'Status Pendaftaran',
                'Harga Tiket',
                'Jenis Kelamin',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Nomor Identitas',
                'Nomor Telepon',
                'Status Pramuka',
                'Waktu Pendaftaran'
            ], ';');
            
            $grandTotal = 0;
            $no = 1;

            foreach ($registrations as $reg) {
                $grandTotal += $reg->event->registration_fee;

                fputcsv($handle, [
                    $no++,
                    $reg->registration_number,
                    $reg->user->name ?? '-',
                    $reg->user->email ?? '-',
                    $reg->event->name ?? '-',
                    ucfirst($reg->status),
                    $reg->event->registration_fee,
                    $reg->detail ? ucfirst($reg->detail->gender) : '-',
                    $reg->detail->birth_place ?? '-',
                    $reg->detail && $reg->detail->birth_date ? $reg->detail->birth_date->format('d/m/Y') : '-',
                    $reg->detail->identity_number ?? '-',
                    $reg->detail->phone ?? '-',
                    $reg->detail && $reg->detail->scout_status ? 'Ya' : 'Tidak',
                    $reg->created_at->format('d/m/Y H:i:s')
                ], ';');
            }
            
            fputcsv($handle, ['', '', '', '', '', 'Total Pendapatan', $grandTotal, '', '', '', '', '', '', ''], ';');

            fclose($handle);
        });

        $filename = 'Laporan_Keuangan_dan_Pendaftar_OKKA_' . date('Ymd_His') . '.csv';
        
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
