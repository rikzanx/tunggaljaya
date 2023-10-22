<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Validator;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
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

            DB::commit();

            return redirect()->route("inventories.index")->with('status', "Inventory item created successfully");
        } catch (\Exception $e) {
            DB::rollback();
            $error = "An error occurred while creating the inventory item: " . $e->getMessage();
            return redirect()->route("inventories.index")->with('danger', $error);
        }
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

            DB::commit();

            return redirect()->route("inventories.index")->with('status', "Inventory item deleted successfully");
        } catch (\Exception $e) {
            DB::rollback();
            $error = "An error occurred while deleting the inventory item: " . $e->getMessage();
            return redirect()->route("inventories.index")->with('danger', $error);
        }
    }
}
