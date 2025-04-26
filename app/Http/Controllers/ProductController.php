<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Menerima parameter pencarian jika ada
        $search = $request->input('search', '');

        // Mengambil data produk dengan pencarian dan pagination
        $products = Product::query()
            ->where('name', 'like', "%{$search}%") // Menambahkan pencarian berdasarkan nama produk
            ->orWhere('description', 'like', "%{$search}%") // Menambahkan pencarian berdasarkan deskripsi produk
            ->paginate(10); // Pagination 10 item per halaman

        // Mengembalikan data produk dalam format JSON
        return response()->json($products);
    }
}
