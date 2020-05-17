<?php

namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Characteristic;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


class ParserController extends Controller
{

    private $price = [];
    private $storage;
    private $prod_model;

    public function __construct()
    {
        $this->storage    = Storage::disk('admin');
        $this->prod_model = app(Product::class);
    }

    public function process()
    {
        $array_files = $this->storage->files('files');
        $this->price = json_decode($this->storage->get($array_files[0]));
//        $collectionA = $this->model->get()->keyBy('id');
//        $collection = $collectionA->intersectByKeys($this->price);
//        dd($collectionA, $this->price, $collection);

        $this->prod_model->getQuery()->delete();
        Characteristic::getQuery()->delete();


        foreach ($this->price as $item) {
            $prod = $this->prod_model->create(['id' => $item->id, 'name' => $item->name, 'price' => $item->price]);
            if ($item->characteristics) {
                foreach ($item->characteristics as $val) {
                    $char = new Characteristic(['name' => $val]);
                    $prod->characteristics()->save($char);
                }
            }
        }
        return redirect()->route('admin.home');
    }
}