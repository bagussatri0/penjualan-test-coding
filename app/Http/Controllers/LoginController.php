<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\KasMasuk;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use DateTime;

class LoginController extends Controller
{
    public function index()
    { 
        return view('login');
    }
    public function dashboard()
    {
        
        return view('main.index',[
            "title" => "Dashboard",
        ]);
    }
    public function rekapitulasi_kasMasuk()
    {
        $rekapitulasiMasuk = DB::table('kas_masuks')
            ->selectRaw('MONTH(tanggalMasuk) AS bulan, GROUP_CONCAT(deskripsi SEPARATOR ", ") AS deskripsi, SUM(jumlahMasuk) AS total, "Kas Masuk" AS jenis')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // $rekapitulasiKeluar = DB::table('kas_keluars')
        //     ->selectRaw('MONTH(tanggalKeluar) AS bulan, GROUP_CONCAT(deskripsi SEPARATOR ", ") AS deskripsi, SUM(jumlahKeluar) AS total, "Kas Keluar" AS jenis')
        //     ->groupBy('bulan')
        //     ->orderBy('bulan')
        //     ->get();

        // $rekapitulasi = $rekapitulasiMasuk->concat($rekapitulasiKeluar);

        $rekapitulasiMasuk->transform(function ($item) {

            $item->bulan = DateTime::createFromFormat('!m', $item->bulan)->format('F');
            $item->total = number_format($item->total);
            return $item;
        });

        return view('main.rekapitulasi_kasMasuk', [
            "title" => "Rekapitulasi",
            "rekapitulasiKasMasuk" => $rekapitulasiMasuk,
        ]);

    }

    public function rekapitulasi_kasKeluar()
    {
        // $rekapitulasiMasuk = DB::table('kas_masuks')
        //     ->selectRaw('MONTH(tanggalMasuk) AS bulan, GROUP_CONCAT(deskripsi SEPARATOR ", ") AS deskripsi, SUM(jumlahMasuk) AS total, "Kas Masuk" AS jenis')
        //     ->groupBy('bulan')
        //     ->orderBy('bulan')
        //     ->get();

        $rekapitulasiKeluar = DB::table('kas_keluars')
            ->selectRaw('MONTH(tanggalKeluar) AS bulan, GROUP_CONCAT(deskripsi SEPARATOR ", ") AS deskripsi, SUM(jumlahKeluar) AS total, "Kas Keluar" AS jenis')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // $rekapitulasi = $rekapitulasiMasuk->concat($rekapitulasiKeluar);

        $rekapitulasiKeluar->transform(function ($item) {

            $item->bulan = DateTime::createFromFormat('!m', $item->bulan)->format('F');
            $item->total = number_format($item->total);
            return $item;
        });

        return view('main.rekapitulasi_kasKeluar', [
            "title" => "Rekapitulasi Kas Keluar",
            "rekapitulasiKasKeluar" => $rekapitulasiKeluar,
        ]);

    }

    public function login(Request $request)
        {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard'); // Ganti dengan halaman setelah login sukses
            }

            return back()->withErrors([
                'email' => 'Email/Password Anda Salah!',
            ]);
        }
    public function logout(Request $request): RedirectResponse
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
}
