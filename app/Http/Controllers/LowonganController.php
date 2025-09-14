<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function detail($type)
    {
        // Cek apakah type yang diminta ada di language resource
        $availableTypes = array_keys(__('app.job_types'));
        
        if (!in_array($type, $availableTypes)) {
            abort(404, 'Jenis lowongan tidak ditemukan');
        }

        // Ambil data dari language resource
        $jobData = __('app.job_types.' . $type);
        
        // Tambahkan image path
        $jobData['image'] = 'asset/job/' . $type . '.webp';
        
        // Untuk category 'lainnya', tambahkan sub_categories
        if ($type === 'lainnya') {
            $jobData['is_multiple'] = true;
            $jobData['sub_categories'] = [
                'perikanan' => array_merge(
                    __('app.job_types.perikanan'),
                    ['image' => 'asset/job/perikanan.webp']
                ),
                'caregiver' => array_merge(
                    __('app.job_types.caregiver'),
                    ['image' => 'asset/job/caregiver.webp']
                )
            ];
            
            // Rename 'general_requirements' to 'requirements' untuk konsistensi
            if (isset($jobData['general_requirements'])) {
                $jobData['requirements'] = $jobData['general_requirements'];
                unset($jobData['general_requirements']);
            }
        }
        
        return view('lowongan_detail', compact('jobData', 'type'));
    }
}