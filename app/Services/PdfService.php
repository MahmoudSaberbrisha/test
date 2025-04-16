<?php

namespace App\Services;

use Mpdf\Mpdf;

class PdfService
{
    public function generatePdf($view, $data, $title, $format = [150, 297])
    {
        $html = view($view, [
        	'data' => $data,
        	'title' => $title,
        	'username' => auth()->user()->name
        ])->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'default_font' => 'dejavusans',
            'format' => $format,
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);
        $mpdf->WriteHTML($html);

        return response($mpdf->Output($title . '.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }

    public function generateMultiPdf($view, $data, $title)
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'default_font' => 'dejavusans',
            'format' => [150, 297], //'A4'
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);

        foreach ($data as $key => $oneData) {
            $html = view($view, [
                'data' => $oneData,
                'title' => $title,
                'username' => auth()->user()->name
            ])->render();
            
            $mpdf->WriteHTML($html);

            if ($key != ($data->count()-1))
                $mpdf->AddPage();
        }
        
        return response($mpdf->Output($title . '.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
}