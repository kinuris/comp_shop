<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSnapshot extends Model
{
    use HasFactory;

    protected $table = 'product_snapshots';
    protected $fillable = [
        'product_name',
        'image_link',
        'fk_product',
        'fk_category',
        'fk_supplier',
        'fk_user',
        'price',
    ];

    static function firstOf($id): ProductSnapshot|null
    {
        $snapshot = ProductSnapshot::query()
            ->where('fk_product', '=', $id)
            ->orderBy('created_at', 'ASC')
            ->limit(1)
            ->first();

        return $snapshot;
    }

    static function latestOf($id): ProductSnapshot|null
    {
        $snapshot = ProductSnapshot::query()
            ->where('fk_product', '=', $id)
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->first();

        return $snapshot;
    }

    static function allOf($id): Collection|null
    {
        $snapshots = ProductSnapshot::query()
            ->where('fk_product', '=', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

        if (count($snapshots) === 0) {
            return null;
        }

        return $snapshots;
    }

    public function isCreation(): bool
    {
        return ProductSnapshot::query()
            ->where('created_at', '<', $this->created_at)
            ->where('fk_product', '=', $this->fk_product)
            ->first() === null;
    }

    public function product()
    {
        return Product::query()->find($this->fk_product);
    }

    public function previous()
    {
        $previous = ProductSnapshot::query()
            ->where('created_at', '<', $this->created_at)
            ->where('fk_product', '=', $this->fk_product)
            ->orderBy('created_at', 'DESC')
            ->first();

        return $previous;
    }

    public function diff(ProductSnapshot $to): array
    {
        if ($this->fk_product !== $to->fk_product) {
            throw new Exception('Instances must reference the same product!');
        }

        // if (date_create($this->created_at) > date_create($to->created_at)) {
        //     throw new Exception('Caller created_at is after destination created_at');
        // }

        $diffs = [];

        if ($to->product_name !== $this->product_name) {
            $diffs['product_name'] = [$this->product_name, $to->product_name];
        }

        if ($to->fk_category !== $this->fk_category) {
            $diffs['fk_category'] = [$this->fk_category, $to->fk_category];
        }

        if ($to->fk_supplier !== $this->fk_supplier) {
            $diffs['fk_supplier'] = [$this->fk_supplier, $to->fk_supplier];
        }

        if ($to->price !== $this->price) {
            $diffs['price'] = [$this->price, $to->price];
        }

        return $diffs;
    }

    public function kind(): string
    {
        return 'snapshot';
    }
}
