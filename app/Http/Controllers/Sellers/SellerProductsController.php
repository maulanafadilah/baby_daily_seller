<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\Sellers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SellerProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Sellers::join('users', 'sellers.nomor_telepon', '=', 'users.nomor_telepon')
            ->where('sellers.nomor_telepon', auth()->user()->nomor_telepon)
            ->first();

        $products = Products::join('sellers', 'sellers.id', '=', 'products.id_penjual')
            ->where('sellers.nomor_telepon', auth()->user()->nomor_telepon)
            ->select('products.id', 'products.cover', 'products.nama_produk', 'products.harga', 'products.stok')
            ->paginate(6);
        $count = Products::join('sellers', 'sellers.id', '=', 'products.id_penjual')
            ->where('sellers.nomor_telepon', auth()->user()->nomor_telepon)
            ->select('products.id', 'products.cover', 'products.nama_produk', 'products.harga', 'products.stok')
            ->count();
        $page_title = 'Produk';
        $page_description = "Produk Sellers Baby Daily";
        $action = __FUNCTION__;

        // Component
        $header = false;
        $roles = auth()->user()->id_peranan;
        $search = false;
        $extraHeader = false;
        $footer = false;
        $bottom = true;
        $sidebar = true;
        $header_title = 'Produk';

        return view('sellers/produk/index', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'sellers', 'products', 'header_title', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('categories')->get();
        $page_title = 'Tambah Produk';
        $page_description = "Tambah Produk Sellers Baby Daily";
        $action = __FUNCTION__;

        // Component
        $header = 'seller_product';
        $roles = auth()->user()->id_peranan;
        $search = false;
        $extraHeader = false;
        $footer = false;
        $bottom = false;
        $sidebar = false;
        $header_title = 'Tambah Produk';

        return view('sellers/produk/create', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private const folder_path = 'products';
    public static function path($path)
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required',
            'gambar.*' => 'mimes:png,jpg,jpeg|max:10240',
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'brand' => 'required',
            'id_kategori' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'required'
        ]);

        $id_penjual = Sellers::where('id_pengguna', auth()->user()->id)->get('id')[0];

        $produk = new Products();
        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->brand = $request->brand;
        $produk->stok = $request->stok;
        $produk->deskripsi = $request->deskripsi;
        $produk->id_kategori = $request->id_kategori;
        $produk->id_penjual = $id_penjual->id;
        $produk->save();
        $id = DB::getPdo()->lastInsertId();

        $no = 0;
        foreach ($request->file('gambar') as $key => $image) {
            if ($no == 0) {
                // $photo = $image->store('products');
                $result = $image->storeOnCloudinary('products');
                $photo = $result->getFileName() . "." . $result->getExtension();
                Products::where('id', $id)
                    ->update(['cover' => $photo]);

                ProductImages::create([
                    'gambar' => $photo,
                    'id_produk' => $id
                ]);
                $no++;
            } else {
                // $photo = $image->store('products');
                $result = $image->storeOnCloudinary('products');
                $photo = $result->getFileName() . "." . $result->getExtension();
                ProductImages::create([
                    'gambar' => $photo,
                    'id_produk' => $id
                ]);
            }
        }

        if ($request->link_buka) {
            Products::where('id', $produk->id)
                ->update(['link_buka' => $request->link_buka]);
        }

        if ($request->link_tokped) {
            Products::where('id', $produk->id)
                ->update(['link_tokped' => $request->link_tokped]);
        }

        if ($request->link_shopee) {
            Products::where('id', $produk->id)
                ->update(['link_shopee' => $request->link_shopee]);
        }


        return redirect()->route('sellerproducts.index')->with('success', 'Berhasil menambahkan produk');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Products::where('products.id', $id)->join('categories', 'products.id_kategori', '=', 'categories.id')->select('products.nama_produk', 'products.stok', 'products.harga', 'products.id as id', 'products.brand', 'products.deskripsi','categories.nama_kategori')->first();
        $produk = Products::join('productimages', 'productimages.id_produk', '=', 'products.id')
            ->where('products.id', '!=', $id)->get();
        $images = Products::join('productimages', 'productimages.id_produk', '=', 'products.id')
            ->where('products.id', $id)->get('gambar');
        $page_title = 'Tambah Produk';
        $page_description = "Tambah Produk Sellers Baby Daily";
        $action = __FUNCTION__;

        // Component
        $header = 'seller_product';
        $roles = auth()->user()->id_peranan;
        $search = false;
        $extraHeader = false;
        $footer = false;
        $bottom = false;
        $sidebar = false;
        $header_title = 'Detail Produk';

        return view('sellers/produk/detail', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'products', 'header_title', 'produk', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Products::join('productimages', 'productimages.id_produk', '=', 'products.id')
            ->where('products.id', $id)
            ->select('products.id', 'products.nama_produk', 'products.harga', 'products.brand', 'products.stok', 'products.deskripsi', 'products.link_buka', 'products.link_tokped', 'products.link_shopee', 'products.id_kategori')->get()[0];
        $categories = DB::table('categories')->get();
        $page_title = 'Edit Produk';
        $page_description = "Edit Produk Sellers Baby Daily";
        $action = __FUNCTION__;

        // return $products;
        // Component
        $header = 'seller_product';
        $roles = auth()->user()->id_peranan;
        $search = false;
        $extraHeader = false;
        $footer = false;
        $bottom = false;
        $sidebar = false;
        $header_title = 'Edit Produk';

        return view('sellers/produk/edit', compact('page_title', 'page_description', 'action', 'header', 'search', 'extraHeader', 'footer', 'bottom', 'sidebar', 'roles', 'header_title', 'categories', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'brand' => 'required',
            'id_kategori' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'required'
        ]);

        Products::where('id', $id)
            ->update([
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'brand' => $request->brand,
                'stok' => $request->stok,
                'deskripsi' => $request->deskripsi,
                'id_kategori' => $request->id_kategori
            ]);


        if ($request->link_buka) {
            Products::where('id', $id)
                ->update(['link_buka' => $request->link_buka]);
        }

        if ($request->link_tokped) {
            Products::where('id', $id)
                ->update(['link_tokped' => $request->link_tokped]);
        }

        if ($request->link_shopee) {
            Products::where('id', $id)
                ->update(['link_shopee' => $request->link_shopee]);
        }


        return redirect()->route('sellerproducts.index')->with('success', 'Berhasil mengupdate produk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $images = ProductImages::where('id_produk', $id)
            ->select('id', 'gambar')
            ->get();

        foreach ($images as $key => $image) {
            Storage::delete($image->gambar);
            ProductImages::destroy($image->id);
        }

        Products::destroy($id);
        return redirect()->route('sellerproducts.index')->with('success', 'Berhasil menghapus produk');
    }
}
