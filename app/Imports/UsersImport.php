<?php

namespace App\Imports;

use App\Models\Product;

use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel

{

    /**

    * @param array $row

    *

    * @return \Illuminate\Database\Eloquent\Model|null

    */

    public function model(array $row)

    {

        return new Product([

            'title' => $row['title'],

            'slug' =>  $row['slug'],

            'summary' => $row['summary'],

            'description' => $row['description'],

            'stock' => $row['stock'],

            'brand_id' => $row['brand_id'],

            'cat_id' => $row['cat_id'],

            'child_cat_id' => $row['child_cat_id'],

            'photo' => $row['photo'],

            'price' => $row['price'],

            'offer_price' => $row['offer_price'],

            'discount' => $row['discount'],

            'size' => $row['size'],

            'conditions' => $row['conditions'],

            'vendor_id' => $row['vendor_id'],

            'status' => $row['status'],

            'additional_info' => $row['additional_info'],

            'return_cancellation' => $row['return_cancellation'],

            'size_guide' => $row['size_guide'],

        ]);

    }

}
