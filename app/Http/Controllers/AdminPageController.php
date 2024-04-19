<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\ImagesSlider;
use App\Models\ImagesProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Item;
use Carbon\Carbon;

class AdminPageController extends Controller
{
    public function __construct()
    {
            $this->middleware('auth');
    }
    public function index(){
        $categories = Category::get();
        $images_slider= ImagesSlider::get();
        $products = Product::get();
        $invoices = Invoice::get();
        $items = Item::get();
        $now = Carbon::now();
        $start= $now->startOfMonth()->format("Y-m-d");
        $end= $now->endOfMonth()->format("Y-m-d");
        $invoicesMonth = Invoice::where('duedate',">=",$start)->where('duedate',"<=",$end)->get();
        $itemsMonth = Item::where('duedate',">=",$start)->where('duedate',"<=",$end)->get();
        // $startMonth = Carbon::now()
        $arrayOmset = array();
        $arrayProfit = array();
        $data_chart = $this->getDataForAmountRequestOrder();
        dd(data_chart);
        
        return view('admin.dashboard',[
            'categories' => $categories,
            'images_slider' => $images_slider,
            'products' => $products,
            "invoices" => $invoices,
            "items" => $items,
            "invoicesMonth" => $invoicesMonth,
            "itemsMonth" => $itemsMonth,
            "arrayProfit" => $arrayProfit,
            "arrayOmset" => $arrayOmset,
        ]);
    }

    public function getDataForAmountRequestOrder(){
        // Mendapatkan bulan dan tahun saat ini
        $current_month = date('m');
        $current_year = date('Y');
    
        // Array bulan-tahun
        $month_date = array();
        for ($i = 0; $i < 12; $i++) {
            $month = $current_month - $i;
            $year = $current_year;
            if ($month <= 0) {
                $month += 12;
                $year--;
            }
            $formatted_month = sprintf("%02d-%04d", $month, $year);
            array_push($month_date, $formatted_month);
        }
        // Membalikkan array agar urut secara menaik (ascending)
        $month_date = array_reverse($month_date);

        $labels_month = [];
        $data_month = [];
        $data_profit_month = [];
        foreach ($month_date as $month) {
            $count = $this->getAmountByMonth($month);
            $profit = $this->getProfitByMonth($month);

            array_push($labels_month, $month);
            array_push($data_month, $count);
            array_push($data_profit_month, $profit);
        }
        $data['labels_month'] = $labels_month;
        $data['data_profit_month'] = $data_profit_month;
        $data['data_month'] = $data_month;
        return $data;
    }
    
    public function getAmountByMonth($month){
        // Pisahkan bulan dan tahun
        list($m, $y) = explode('-', $month);
    
        $total_amount = Item::selectRaw('SUM(qty * item_price) as total_amount')
                            ->join('invoices as inv', 'items.invoice_id', '=', 'inv.id')
                            ->whereRaw('MONTH(inv.created_at) = ?', [$m])
                            ->whereRaw('YEAR(inv.created_at) = ?', [$y])
                            ->first();
    
        return $total_amount->total_amount ?? 0;
    }
    public function getProfitByMonth($month){
        // Pisahkan bulan dan tahun
        list($m, $y) = explode('-', $month);
    
        $total_profit = Invoice::whereMonth('created_at', $m)
                               ->whereYear('created_at', $y)
                               ->sum('profit');
    
        return $total_profit ?? 0;
    }
    
}
