<?php

namespace App\Repositories\Admin\Anak;

use App\Repositories\Admin\Core\Anak\AnakRepositoryInterface;
use App\Models\Anak;
use App\Models\User;
use App\Models\DataAnak;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AnakRepository implements AnakRepositoryInterface
{
    protected $anak;

    public function __contruct(
        anak $anak
    ) {
        $this->anak = $anak;
    }

    public function storeAnak($request)
    {
        $lahir = strtotime($request->tgl_lahir);
        $now = strtotime(date('Y-m-d H:i:s'));
        $y1 = date('Y', $lahir);
        $y2 = date('Y', $now);
        $m1 = date('m', $lahir);
        $m2 = date('m', $now);
        $umur = (($y2 - $y1) * 12) + ($m2 - $m1);

        $anak_baru = Anak::create([
            'no_kk' => $request->no_kk,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'nik_ortu' => $request->nik_ortu,
            'nama_ibu' => $request->nama_ibu,
            'nama_ayah' => $request->nama_ayah,
            'jk' => $request->jk,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'golda' => $request->golda,
            'anak' => $request->anak,
            'id_kec' => $request->id_kec,
            'id_kel' => $request->id_kel,
            'id_rt' => $request->id_rt,
            'id_posyandu' => $request->id_posyandu,
            'id_puskesmas' => $request->id_puskesmas,
            'catatan' => $request->catatan,
        ]);

        DataAnak::create([
            'id_anak' => $anak_baru->id,
            'bln' => $umur,
            'posisi' => 'L',
            'tb' => $request->tb,
            'bb' => $request->bb,
            'id_user' => Auth::user()->id,
        ]);
    }

    public function updateAnak($request, $id)
    {
        $anak = Anak::find($id);
        $anak->update([
            'no_kk' => $request->no_kk,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'nik_ortu' => $request->nik_ortu,
            'nama_ibu' => $request->nama_ibu,
            'nama_ayah' => $request->nama_ayah,
            'jk' => $request->jk,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'golda' => $request->golda,
            'anak' => $request->anak,
            'id_kec' => $request->id_kec,
            'id_kel' => $request->id_kel,
            'id_rt' => $request->id_rt,
            'id_posyandu' => $request->id_posyandu,
            'id_puskesmas' => $request->id_puskesmas,
            'catatan' => $request->catatan,
        ]);
    }

    public function destroyAnak($id)
    {
        try {
            $anak = Anak::find($id);
            $anak->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeDataAnak($request)
    {
        $anak = DataAnak::create([
            'id_anak' => $request->id_anak,
            'bln' => $request->bln,
            'posisi' => $request->posisi,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'asi' => $request->asi,
            'vit_a' => $request->vit_a,
            'id_user' => Auth::user()->id,
        ]);
    }

    public function updateDataAnak($request, $id)
    {
        $dataAnak = DataAnak::find($id);
        $dataAnak->update([
            'posisi' => $request->posisi,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'asi' => $request->asi,
            'vit_a' => $request->vit_a,
            'id_user' => Auth::user()->id,
        ]);
    }
}
