<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRestock;
use App\Models\ProductSnapshot;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query();
        $search = request()->query('search');

        if ($search) {
            $products = $products->where('product_name', 'LIKE', "%$search%");
        }

        $products = $products->paginate(12);

        return view('product.index')->with('products', $products);
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('product.create')
            ->with('categories', $categories)
            ->with('suppliers', $suppliers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => ['required', 'unique:products'],
            'category' => ['required', 'numeric'],
            'supplier' => ['required', 'numeric'],
            'stock_quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'image' => ['nullable', File::image(), 'max:16000'],
            'description' => ['required', 'min:32'],
        ]);

        $barcode = rand(100_000_000_000, 999_999_999_999);

        $validated['barcode'] = $barcode;
        $validated['fk_category'] = $request->input('category');
        $validated['fk_supplier'] = $request->input('supplier');
        $validated['available'] = $request->has('available');

        if ($request->hasFile('image')) {
            $extension = $request->file('image')
                ->getClientOriginalExtension();

            $filename = sha1(time()) . '.' . $extension;

            $request->file('image')
                ->storeAs('public/product/image', $filename);

            $validated['image_link'] = $filename;
        }

        $product = Product::query()->create($validated);

        ProductSnapshot::create([
            'product_name' => $product->product_name,
            'fk_supplier' => $product->fk_supplier,
            'fk_category' => $product->fk_category,
            'price' => $product->price,
            'fk_product' => $product->id,
            'fk_user' => auth()->user()->user_id,
        ]);

        return redirect('/product')->with('message', 'Successfully created product.');
    }

    public function show(Product $product)
    {
        return $product->product_name;
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('product.edit')
            ->with('product', $product)
            ->with('categories', $categories)
            ->with('suppliers', $suppliers);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => [
                'required',
                Rule::unique('products')->ignore($product),
            ],
            'category' => ['required', 'numeric'],
            'supplier' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'image' => ['nullable', File::image(), 'max:16000'],
            'description' => ['required', 'min:32'],
        ]);

        $validated['fk_category'] = $request->input('category');
        $validated['fk_supplier'] = $request->input('supplier');
        $validated['available'] = $request->has('available');

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = sha1(time()) . '.' . $extension;

            $request->file('image')->storeAs('public/product/image', $filename);
            $validated['image_link'] = $filename;

            if ($product->image_link) {
                Storage::delete('public/product/image/' . $product->image_link);
            }
        }

        if (
            $validated['product_name'] != $product->product_name ||
            $validated['fk_category'] != $product->fk_category ||
            $validated['fk_supplier'] != $product->fk_supplier ||
            $validated['price'] != $product->price
        ) {
            $validated['fk_user'] = auth()->user()->user_id;
            $validated['fk_product'] = $product->id;

            ProductSnapshot::create($validated);
        }

        $product->update($validated);

        return redirect('/product')->with('message', 'Successfully updated product.');
    }

    public function delete(Product $product)
    {
        return $product->product_name;
    }

    public function destroy(Product $product)
    {
        if ($product->image_link && Storage::exists('public/product/image' . $product->image_link)) {
            Storage::delete('public/product/image' . $product->image_link);
        }

        $product->delete();
    }

    public function restock_view(Product $product)
    {
        return view('product.restock')->with('product', $product);
    }

    public function restock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock' => ['required', 'numeric']
        ]);

        $validated['fk_user'] = auth()->user()->user_id;
        $validated['fk_product'] = $product->id;
        $validated['amount'] = $validated['stock'];

        ProductRestock::create($validated);
        $product->update(['stock_quantity' => $product->stock_quantity + $validated['amount']]);

        return redirect('/product')->with('message', 'Successfully added ' . $validated['amount'] . ' ' . $product->product_name . ' stock');
    }

    public function toggle_availability(Product $product)
    {
        $product->update(['available' => !$product->available]);

        return redirect('/product')->with('message', 'Successfully toggled availability of ' . $product->product_name);
    }
}
