<?php

namespace App\Http\Controllers\Apis\Controllers\search;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\products;
use App\Models\stores;
use Illuminate\Support\Str;

class searchController extends index
{
    public static $model;
    public static function api()
    {
        $search = self::$request->keyword;
        if (self::$request->type) {
            $type = self::$request->type;
            $model = "App\Models\\" . Str::plural(self::$request->type);
            $records =  $model::when(self::$request->keyword, function ($q) use ($type) {
                $keyword = self::$request->keyword;
                if ($type == 'product')
                    return $q->where(function ($q) use ($keyword) {
                        return $q->where('nameAr', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('nameEn', 'LIKE', '%' . $keyword . '%');
                    });
                else
                    return $q->where('name', 'LIKE', '%' . $keyword . '%');
            })
                ->when(self::$request->categoryId && $type == 'product', function ($q) {
                    return $q->where('categories_id', self::$request->categoryId);
                })
                ->when(self::$request->barcode && ($type == 'product'), function ($q) {
                    return $q->where('ID_', self::$request->barcode);
                })
                ->when(self::$request->brandId  && ($type == 'product'), function ($q) {
                    return $q->whereIn('brands_id', self::$request->brandId);
                })
                ->when(self::$request->categoriesId  && ($type == 'product'), function ($q) {
                    return $q->whereIn('categories_id',  self::$request->categoriesId);
                })
                ->when(self::$request->rangPrice  && ($type == 'product'), function ($q) {
                    $from = self::$request->rangPrice['from'] ?? 0;
                    $to = self::$request->rangPrice['to'] ?? 100000000000;
                    return $q->whereBetween('price', [$from, $to]);
                })->when(self::$request->isOffer == 'true', function ($q) {
                    return $q->whereHas('offers', function ($query) {
                        $query->where('isActive', 1)
                            ->where('startAt', '<=', date('Y-m-d'))
                            ->where('endAt', '>=', date('Y-m-d'));
                    })->with('offers');
                })->when(self::$request->hasWholesale == "true", function ($q) {
                    return $q->whereHas('prices');
                })
                ->where('isActive', 1);

            $sort = self::$request->sortBy;
            if ($sort != null) {
                $records->orderBy(self::$request->sortBy,  self::$request->isDesc == "false" ? 'asc' : 'desc');
            } else {
                $records->orderBy('id', 'DESC');
            }

            $count = $records->count();
            $records = $records->forPage(self::$request->page + 1, self::$itemPerPage)->get();
            return [
                "status" => $records->count() ? 200 : 204,
                "totalPages" => ceil($count / self::$itemPerPage),
                Str::plural(self::$request->type) => objects::ArrayOfObjects($records, self::$request->type),
            ];
        } else {
            $products =  products::allActive();
            if (self::$request->keyword) {
                $products = $products->filter(function ($item) use ($search) {
                    if (stripos($item['nameAr'], $search) !== false ||  stripos($item['nameEn'], $search) !== false)
                        return true;
                    return false;
                });
            }
            $stores =  stores::all();
            if (self::$request->keyword) {
                $stores = $stores->filter(function ($item) use ($search) {
                    if (stripos($item['name'], $search) !== false)
                        return true;
                    return false;
                });
            }
            $productsStatus = $products->forPage(self::$request->page + 1, $stores ? self::$itemPerPage : self::$itemPerPage / 2)->count() ? 1 : 0;
            $storesStatus = $products->forPage(self::$request->page + 1, $products ? self::$itemPerPage : self::$itemPerPage / 2)->count() ? 1 : 0;
            return [
                "status" => $productsStatus + $storesStatus > 0 ? 200 : 204,
                "totalPages" => ceil(($products->count() + $stores->count()) / self::$itemPerPage),
                "products" => objects::ArrayOfObjects($products->forPage(self::$request->page + 1, self::$itemPerPage), "product"),
                "stores" => objects::ArrayOfObjects($stores->forPage(self::$request->page + 1, self::$itemPerPage), "store"),
            ];
        }
    }
}
