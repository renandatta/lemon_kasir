<?php

namespace App\Http\Controllers\Pengaturan;

use App\Models\Pengaturan\FiturProgram;
use App\Models\Pengaturan\HakAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiturProgramRepository
{
    protected $fiturProgram, $hakAkses, $skip = array();
    public function __construct(FiturProgram $fiturProgram, HakAkses $hakAkses)
    {
        $this->skip = array();
        $this->fiturProgram = $fiturProgram;
        $this->hakAkses = $hakAkses;
    }

    public function search_all()
    {
        return $this->fiturProgram->orderBy('kode', 'asc')->get();
    }

    public function nested_data($parent_kode = '#', $user_level_id = null)
    {
        $result = array();
        $fitur_id_akses = $user_level_id == null ? array() :
            $this->hakAkses->select('fitur_program_id')
                ->where('user_level_id', '=', $user_level_id)
                ->where('flag_akses', '=', 1)
                ->get()
                ->pluck('fitur_program_id')->toArray();

        $data = $this->fiturProgram
            ->select('id', 'nama as text', 'kode', 'parent_kode', 'url', 'icon as menu_icon')
            ->where('parent_kode', 'like', ($parent_kode == '#' ? '' : $parent_kode). '%')
            ->orderBy('kode')
            ->get();
        if (count($data) > 0) {
            $result = $this->get_children_from_array($data, $parent_kode, $fitur_id_akses);
        }
        return $result;
    }

    public function get_children_from_array($data, $parent_kode, $fitur_id_akses)
    {
        $result = array();
        foreach ($data as $item) {
            if (!in_array($item->id, $this->skip) && $item->parent_kode == $parent_kode) {
                array_push($this->skip, $item->id);
                $item = $this->set_flag_akses($item, $fitur_id_akses);
                $item->children = $this->get_children_from_array($data, $item->kode, $fitur_id_akses);
                array_push($result, $item);
            }
        }
        return $result;
    }

    public function set_flag_akses($data, $fitur_id_akses)
    {
        $data->flag_akses = in_array($data->id, $fitur_id_akses) ? true : false;
        $data->state = [
            'checked' => $data->flag_akses
        ];
        return $data;
    }

    public function find($value, $column = 'id')
    {
        return $this->fiturProgram->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        if (!$request->has('id'))
            $result = $this->fiturProgram->create($request->all());
        else {
            $result = $this->fiturProgram->find($request->input('id'));
            $result->update($request->all());
        }
        return $result;
    }

    public function delete($id)
    {
        $result = $this->fiturProgram->find($id);
        $result->delete();
        return $result;
    }

    public function kode_otomatis($parent_kode)
    {
        $last_row = $this->fiturProgram->where('parent_kode', '=', $parent_kode)->orderBy('kode', 'desc')->first();
        $kode = '01';
        if (!empty($last_row)) {
            $temp = explode(".", $last_row->kode);
            $kode = intval($temp[count($temp)-1])+1;
            if (strlen($kode) == 1) $kode = '0' . $kode;
        }
        return $parent_kode == '#' ? $kode : $parent_kode . '.' . $kode;
    }

    public function reposisi(Request $request)
    {
        $fitur = $this->fiturProgram->find($request->input('id'));
        $kode_asal = $fitur->kode;
        $kode_array = explode(".", $fitur->kode);
        $kode = $kode_array[count($kode_array)-1];
        $kode_tujuan = $request->input('arah') == 'up' ? intval($kode) - 1 : intval($kode) + 1;
        if (strlen($kode_tujuan) == 1) $kode_tujuan = '0' . $kode_tujuan;
        if ($fitur->parent_kode != '#') $kode_tujuan = $fitur->parent_kode. '.' .$kode_tujuan;
        $fitur_tujuan = $this->fiturProgram->where('kode', '=', $kode_tujuan)->first();

        if (!empty($fitur_tujuan)) {
            $temp_kode = mt_rand(111,999);

            //=====tujuan pindah ke temp
            $this->fiturProgram->where('kode', $kode_tujuan)->update(['kode' => $temp_kode]);
            $sub = $this->fiturProgram->where('parent_kode', $kode_tujuan)->count();
            if ($sub > 0)
                $this->fiturProgram->where('parent_kode', $kode_tujuan)
                    ->update([
                        'kode' => DB::raw("replace(kode, parent_kode, '". $temp_kode ."')"),
                        'parent_kode' => $temp_kode
                    ]);

            //=====asal pindah ke tujuan
            $this->fiturProgram->where('kode', $kode_asal)->update(['kode' => $kode_tujuan]);
            $sub = $this->fiturProgram->where('parent_kode', $kode_asal)->count();
            if ($sub > 0)
                $this->fiturProgram->where('parent_kode', $kode_asal)
                    ->update([
                        'kode' => DB::raw("replace(kode, parent_kode, '". $kode_tujuan ."')"),
                        'parent_kode' => $kode_tujuan
                    ]);

            //=====temp pindah ke asal
            $this->fiturProgram->where('kode', (string) $temp_kode)->update(['kode' => (string) $kode_asal]);
            $sub = $this->fiturProgram->where('parent_kode', $temp_kode)->count();
            if ($sub > 0)
                $this->fiturProgram->where('parent_kode', $temp_kode)
                    ->update([
                        'kode' => DB::raw("replace(kode, parent_kode, '". $kode_asal ."')"),
                        'parent_kode' => $kode_asal
                    ]);
        }
        return $fitur;
    }
}
