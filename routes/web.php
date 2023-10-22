<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImagesProductController;
use App\Http\Controllers\ImagesSliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DeletedInvoiceController;
use App\Http\Controllers\DeletedItemController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\SuratPenawaranController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\InventoryController;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PageController::class, 'welcome'])->name('index');
Route::get('about',[PageController::class, 'about'])->name('about');
Route::get('contact',[PageController::class, 'contact'])->name('contact');
Route::get('product',[PageController::class, 'product'])->name('product');
Route::get('product/{slug}',[PageController::class, 'productdetail'])->name('product-detail');

Route::get('/sitemap', function(){
    $sitemap = Sitemap::create()
    ->add(Url::create('/about'))
    ->add(Url::create('/contact'))
    ->add(Url::create('/product'))
    ->add(Url::create('/'));
   
    $post = Product::all();
    foreach ($post as $post) {
        $sitemap->add(Url::create("/product/{$post->slug}"));
    }
    $sitemap->writeToFile(public_path('sitemap.xml'));
});


Route::get('admin/login', [CustomAuthController::class, 'index'])->name('login');
Route::group(['prefix' => 'admin'],function(){
    Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
    Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
    // Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
    // Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
    Route::get('/',[AdminPageController::class, 'index'])->name('admin.dashboard');
    Route::resource('kategori', CategoryController::class);
    Route::resource('perusahaan',CompanyController::class);
    Route::resource('slider',ImagesSliderController::class);
    Route::resource('produk',ProductController::class);
    Route::resource('invoice',InvoiceController::class);
    Route::resource('item',ItemController::class);
    Route::resource('deletedinvoice',DeletedInvoiceController::class);
    Route::resource('deleteditem',DeletedItemController::class);
    Route::resource('password',PasswordController::class);
    Route::resource('penawaran',PenawaranController::class);
    Route::resource('surat-penawaran',SuratPenawaranController::class);
    Route::resource('keuangan',KeuanganController::class);
    Route::resource('inventories',InventoryController::class);

    Route::get('proforma/invoice/{id}',[InvoiceController::class, 'show_proform'])->name("show_proform");
    Route::get('suratjalan/invoice/{id}',[InvoiceController::class, 'surat_jalan'])->name("surat_jalan");
});
