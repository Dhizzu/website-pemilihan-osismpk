<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nis = $row['nis'];
        $namaSiswa = $row['nama_siswa'];

        if (empty($nis) || empty($namaSiswa)) {
            return null;
        }

        $existingUser = User::where('nis', $nis)->first();

        if ($existingUser) {
            return null;
        }

        return new User([
            'nis' => $nis,
            'name' => $namaSiswa,
            'password' => Hash::make($nis),
            'has_voted_osis' => false,
            'has_voted_mpk' => false
        ]);
    }

    public function rules(): array
    {
        return [
            'nis' => 'required|string|digits:4|unique:users,nis',
            'nama_siswa' => 'required|string|max:255'
        ];
    }

    public function sheets(): array
    {
        return [
            '*' => $this
        ];
    }
}
