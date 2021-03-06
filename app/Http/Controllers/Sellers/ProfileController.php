<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Sellers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Profile';
        $page_description = "Profile Sellers Baby Daily";
        $action = __FUNCTION__;

        // Component
        $header = 'auth';
        $roles = auth()->user()->id_peranan;
        $search = false;
        $extraHeader = false;
        $footer = false;
        $bottom = true;
        $sidebar = true;
        $header_title = 'Pengaturan Profile';

        return view('sellers/profile/index', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Profile';
        $page_description = "Buat Profile Sellers Baby Daily";
        $action = __FUNCTION__;

        // Component
        $header = false;
        $roles = auth()->user()->id_peranan;
        $search = false;
        $extraHeader = false;
        $footer = false;
        $bottom = false;
        $sidebar = false;
        $header_title = 'Profile';

        return view('sellers/profile/create', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'nama_toko' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat' => 'required',
            'kode_pos' => 'required|numeric',
            'tag' => 'required|numeric',
        ]);

        Sellers::create([
            'nama_penjual' => auth()->user()->nama_lengkap,
            'nomor_telepon' => auth()->user()->nomor_telepon,
            'nama_toko' => $request->nama_toko,
            'province_id' => $request->provinsi,
            'regency_id' => $request->kabupaten,
            'district_id' => $request->kecamatan,
            'village_id' => $request->kelurahan,
            'alamat' => strtoupper($request->alamat),
            'kode_pos' => $request->kode_pos,
            'tag' => $request->tag,
            'flag' => 1,
            'id_pengguna' => auth()->user()->id
        ]);

        return redirect()->route('home')->with('success', 'Berhasil membuat catatan toko');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sellers = Sellers::where('id_pengguna', auth()->user()->id)->first();
        $domicile = Sellers::with(['province', 'regency', 'district', 'village'])
            ->where('id_pengguna', auth()->user()->id)->first();
        $page_title = 'Profile Toko';
        $page_description = "Profile Toko Sellers Baby Daily";
        $action = __FUNCTION__;

        // Component
        $header = 'seller_profile';
        $roles = auth()->user()->id_peranan;
        $search = false;
        $extraHeader = false;
        $footer = false;
        $bottom = true;
        $sidebar = true;
        $header_title = 'Profile Toko';

        return view('sellers/profile/toko/index', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title', 'sellers', 'domicile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $action = __FUNCTION__;

        // Component
        $header = 'seller_profile';
        $roles = auth()->user()->id_peranan;
        $search = false;
        $extraHeader = false;
        $footer = false;
        $bottom = false;
        $sidebar = false;
        if ($id == 2) {
            $page_title = 'Edit Nomor Whatsapp';
            $page_description = "Edit Nomor Whatsapp Sellers Baby Daily";
            $header_title = 'Edit Nomor Whatsapp';
            $profile = Sellers::join('users', 'sellers.nomor_telepon', '=', 'users.nomor_telepon')
                ->where('sellers.nomor_telepon', auth()->user()->nomor_telepon)
                ->get('link_whatsapp')[0];

            return view('sellers/profile/edit', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title', 'profile', 'id'));
        } elseif ($id == 3) {
            $page_title = 'Edit E-Commerce';
            $page_description = "Edit E-Commerce Sellers Baby Daily";
            $header_title = 'Edit E-Commerce';
            $profile = Sellers::join('users', 'sellers.nomor_telepon', '=', 'users.nomor_telepon')
                ->where('sellers.nomor_telepon', auth()->user()->nomor_telepon)
                ->get()[0];
            return view('sellers/profile/edit', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title', 'profile', 'id'));
        } elseif ($id == 4) {
            $page_title = 'Edit Jam Operasional';
            $page_description = "Edit Jam Operasional Sellers Baby Daily";
            $header_title = 'Edit Jam Operasional';
            $profile = Sellers::join('users', 'sellers.nomor_telepon', '=', 'users.nomor_telepon')
                ->where('sellers.nomor_telepon', auth()->user()->nomor_telepon)
                ->get()[0];
            return view('sellers/profile/edit', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title', 'profile', 'id'));
        } elseif ($id == 5) {
            $page_title = 'Edit Nama Toko';
            $page_description = "Edit Nama Toko Sellers Baby Daily";
            $header_title = 'Edit Nama Toko';
            $profile = Sellers::join('users', 'sellers.nomor_telepon', '=', 'users.nomor_telepon')
                ->where('sellers.nomor_telepon', auth()->user()->nomor_telepon)
                ->get()[0];
            return view('sellers/profile/edit', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title', 'profile', 'id'));
        } elseif ($id == 6) {
            $page_title = 'Edit Alamat Toko';
            $page_description = "Edit Alamat Toko Sellers Baby Daily";
            $header_title = 'Edit Alamat Toko';
            $domicile = Sellers::with(['province', 'regency', 'district', 'village'])
                ->where('id_pengguna', auth()->user()->id)->first();
            $profile = Sellers::join('users', 'sellers.nomor_telepon', '=', 'users.nomor_telepon')
                ->where('sellers.nomor_telepon', auth()->user()->nomor_telepon)
                ->get()[0];
            return view('sellers/profile/edit', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title', 'profile', 'id', 'domicile'));
        } elseif ($id == 7) {
            $page_title = 'Edit Foto Toko';
            $page_description = "Edit Photo Toko Sellers Baby Daily";
            $header_title = 'Edit Foto Toko';
            $profile = Sellers::join('users', 'sellers.nomor_telepon', '=', 'users.nomor_telepon')
                ->where('sellers.nomor_telepon', auth()->user()->nomor_telepon)
                ->get()[0];
            return view('sellers/profile/edit', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title', 'profile', 'id'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private const folder_path = 'profiles';
    public static function path($path){
        return pathinfo($path, PATHINFO_FILENAME);
    }
    public function update(Request $request, $id)
    {
        if ($id == 2) {

            $request->validate([
                'link_whatsapp' => 'required|min:9|max:13'
            ]);

            Sellers::where('nomor_telepon', auth()->user()->nomor_telepon)
                ->update(['link_whatsapp' => $request->link_whatsapp]);

            return redirect()->route('profile.index')->with('success', 'Nomor Whatsapp berhasil diupdate');
        } elseif ($id == 3) {

            if ($request->link_buka) {
                Sellers::where('nomor_telepon', auth()->user()->nomor_telepon)
                    ->update(['link_buka' => $request->link_buka]);
            }

            if ($request->link_tokped) {
                Sellers::where('nomor_telepon', auth()->user()->nomor_telepon)
                    ->update(['link_tokped' => $request->link_tokped]);
            }

            if ($request->link_shopee) {
                Sellers::where('nomor_telepon', auth()->user()->nomor_telepon)
                    ->update(['link_shopee' => $request->link_shopee]);
            }


            return redirect()->route('profile.index')->with('success', 'Link E-Commerce berhasil diupdate');
        } elseif ($id == 4) {

            $request->validate([
                'jam_buka' => 'required',
                'jam_tutup' => 'required'
            ]);

            Sellers::where('nomor_telepon', auth()->user()->nomor_telepon)
                ->update([
                    'jam_buka' => $request->jam_buka,
                    'jam_tutup' => $request->jam_tutup
                ]);

            return redirect()->route('profile.index')->with('success', 'Jam Operasional berhasil diupdate');
        } elseif ($id == 5) {

            $request->validate([
                'nama_toko' => 'required'
            ]);

            Sellers::where('nomor_telepon', auth()->user()->nomor_telepon)
                ->update([
                    'nama_toko' => $request->nama_toko
                ]);

            return redirect()->route('profile.show', 1)->with('success', 'Nama Toko berhasil diupdate');
        } elseif ($id == 6) {

            $request->validate([
                'provinsi' => 'required',
                'kabupaten' => 'required',
                'kecamatan' => 'required',
                'kelurahan' => 'required',
                'alamat' => 'required',
                'kode_pos' => 'required|numeric'
            ]);

            Sellers::where('nomor_telepon', auth()->user()->nomor_telepon)
                ->update([
                    'province_id' => $request->provinsi,
                    'regency_id' => $request->kabupaten,
                    'district_id' => $request->kecamatan,
                    'village_id' => $request->kelurahan,
                    'alamat' => strtoupper($request->alamat),
                    'kode_pos' => $request->kode_pos
                ]);

            return redirect()->route('profile.show', 1)->with('success', 'Alamat berhasil diupdate');
        } elseif ($id == 7) {
            $request->validate([
                'gambar' => 'required',
                'gambar.*' => 'mimes:png,jpg,jpeg|max:10240'
            ]);

            
            $photo = Sellers::where('nomor_telepon', auth()->user()->nomor_telepon)
                ->get('foto_penjual')[0];

            if ($photo->foto_penjual != null) {
                $public_id = self::folder_path.'/'.self::path($photo->foto_penjual);
                $del = cloudinary()->destroy($public_id);

                $result = $request->file('gambar')->storeOnCloudinary('profiles');
                // Storage::delete($photo->foto_penjual);
            }
            
            $result = $request->file('gambar')->storeOnCloudinary('profiles');
            
            $image = $result->getFileName().".".$result->getExtension();

            Sellers::where('nomor_telepon', auth()->user()->nomor_telepon)
                ->update(['foto_penjual' => $image]);

            return redirect()->route('profile.show', 1)->with('success', 'Photo penjual berhasil diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
