<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\ImagesInventory;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with('images')->get();
        return view('admin.inventory', [
            'inventories' => $inventories,
        ]);
    }

    public function create()
    {
        $nextId = Inventory::max('id') + 1;

        return view('admin.inventory-create',[
            "nextId" => $nextId
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku' => 'required|unique:inventories,sku',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'lokasi' => 'required',
            'qty' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route("inventories.index")->with('danger', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $inventory = new Inventory();
            $inventory->sku = $request->sku;
            $inventory->name = $request->name;
            $inventory->description = $request->description;
            $inventory->lokasi = $request->lokasi;
            $inventory->qty = $request->qty;
            $inventory->save();
            if($request->hasfile('filenames')){
                foreach($request->file('filenames') as $file)
                {
                    $imageinventory = new ImagesInventory();
                    $uploadFolder = "img/inventory/";
                    $image = $file;
                    $imageName = time().'-'.$image->getClientOriginalName();
                    $image->move(public_path($uploadFolder), $imageName);
                    $image_link = $uploadFolder.$imageName;
                    $imageinventory->inventory_id = $inventory->id;
                    $imageinventory->image_inventory = $image_link;
                    $imageinventory->save();
                }
            }
            DB::commit();
            return redirect()->route("inventories.index")->with('status', "Inventory item created successfully");
        } catch (\Exception $e) {
            DB::rollback();
            $error = "An error occurred while creating the inventory item: " . $e->getMessage();
            return redirect()->route("inventories.index")->with('danger', $error);
        }
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);
        if ($validator->fails()) {
            return redirect()->route("inventories.index")->with('danger', $validator->errors()->first());
        }
        if ($request->hasFile('file')) {
            DB::beginTransaction();
            try{
                $file = $request->file('file');
                // Baca isi file CSV
                $csvData = file_get_contents($file);
                // Ubah isi CSV menjadi array
                $rows = array_map('str_getcsv', explode("\n", $csvData));
                // Ambil header sebagai nama kolom
                $header = array_shift($rows);
                $header = array_map('trim', $header);
                // Loop untuk setiap baris dalam file CSV
                $jumlah = 0;
                $duplicate_kib = "";
                $jumlah_duplicate = 0;
                $nextId = Inventory::max('id') + 1;
                foreach ($rows as $index=>$row) {
                    if (count($header) !== count($row)) {
                        continue; // Lewati baris yang tidak sesuai format
                    }
                    $data = array_combine($header, $row);
                    $inventory = new Inventory();
                    $inventory->sku = str_pad($nextId, 8, '0', STR_PAD_LEFT);
                    $name = $data['jenis']." ".$data['ukuran']." ".$data['class']." ".$data['material']." ".$data['merk'];
                    $inventory->name = $this->clear_char_non_ascii($name);
                    $inventory->description = $this->clear_char_non_ascii($name);
                    $inventory->lokasi = $this->clear_char_non_ascii($data['lokasi']);
                    $inventory->qty = $this->clear_char_non_ascii($data['qty']);
                    $inventory->save();
                    $jumlah++;
                    $nextId++;
                }
                $duplicate_kib = "Duplicate Item ($jumlah_duplicate) : ".$duplicate_kib;
                DB::commit();
                return redirect()->route("inventories.index")->with('status', "Sukses mengimport $jumlah data barang, $duplicate_kib");
            }catch(\Exception $e){
                DB::rollback();
                $ea = "Terjadi Kesalahan saat menambah data invenotry: " . $e->getMessage(); // Change here
                Log::error($ea);
                return redirect()->route("inventories.index")->with('danger', $ea);
            }
        }else{
            return redirect()->route("inventories.index")->with('danger', "File Not Found, File tidak terkirim");
        }
        return redirect()->route("inventories.index");
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('admin.inventory-edit', [
            'inventory' => $inventory,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required',
            'lokasi' => 'required',
            'qty' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route("inventories.edit", $id)->with('danger', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->name = $request->name;
            $inventory->description = $request->description;
            $inventory->lokasi = $request->lokasi;
            $inventory->qty = $request->qty;
            $inventory->save();
            if($request->hasfile('filenames')){
                foreach($request->file('filenames') as $file)
                {
                    $imageinventory = new ImagesInventory();
                    $uploadFolder = "img/inventory/";
                    $image = $file;
                    $imageName = time().'-'.$image->getClientOriginalName();
                    $image->move(public_path($uploadFolder), $imageName);
                    $image_link = $uploadFolder.$imageName;
                    $imageinventory->inventory_id = $id;
                    $imageinventory->image_inventory = $image_link;
                    $imageinventory->save();
                }
            }
            DB::commit();

            return redirect()->route("inventories.index")->with('status', "Inventory item updated successfully");
        } catch (\Exception $e) {
            DB::rollback();
            $error = "An error occurred while updating the inventory item: " . $e->getMessage();
            return redirect()->route("inventories.edit", $id)->with('danger', $error);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->delete();
            $delete = ImagesInventory::where('inventory_id',$id)->delete();
            DB::commit();

            return redirect()->route("inventories.index")->with('status', "Inventory item deleted successfully");
        } catch (\Exception $e) {
            DB::rollback();
            $error = "An error occurred while deleting the inventory item: " . $e->getMessage();
            return redirect()->route("inventories.index")->with('danger', $error);
        }
    }
    public function destroy_image($id)
    {
        $imageselected = ImagesInventory::with('inventory')->findOrFail($id);
        DB::beginTransaction();
        try{
            ImagesInventory::destroy($id);
            DB::commit();
            return redirect()->route("inventories.index")->with('status', "Sukses menghapus foto");

        }catch (\Exception $e) {
            DB::rollback();
            $ea = "Terjadi Kesalahan saat merubah foto".$e->message;
            return redirect()->route("inventories.index")->with('danger', $ea);
        }
    }
    public function clear_char_non_ascii($string){
        return preg_replace('/[^\x20-\x7E]/', '',$string);
    }
}
