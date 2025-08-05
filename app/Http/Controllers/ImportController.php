<?php

namespace App\Http\Controllers;

use Exception;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class ImportController extends Controller
{
    public function showImportForm()
    {
        return view('import.users-form');
    }

    public function importUsers(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'file.required' => 'Pilih file excel yang akan diunggah',
            'file.mimes' => 'Format file harus Excel (xlsx, xls) atau csv',
            'file.max' => 'Ukuran file tidak boleh melebihi 2MB'
        ]);

        try {
            Excel::import(new UsersImport, $request->file('file'));

            return redirect()->back()->with('success', 'Data siswa berhasil diimport');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris " . $failure->row() . ": " . implode(", ", $failure->errors());
            }
            return redirect()->back()->withErrors($errors)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimport data: ' . $e->getMessage());
        }
    }
}
