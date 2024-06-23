<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\assertTrue;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'name',
        'type',
        'absolute_discount',
        'percentage_discount',
        'disabled',
    ];

    static function createAbsoluteDiscount($name, $value): Discount
    {
        return Discount::query()->create([
            'name' => $name,
            'type' => 'absolute',
            'absolute_discount' => $value
        ]);
    }

    static function createPercentageDiscount($name, $percentage): Discount
    {
        assertTrue($percentage > 0 && $percentage <= 100, 'Percentage must be between 0 exclusive and 100 inclusive');

        return Discount::query()->create([
            'name' => $name,
            'type' => 'percentage',
            'percentage_discount' => $percentage
        ]);
    }

    static function able()
    {
        return ApplicableDiscount::query()->where('disabled', false);
    }

    function isGeneral(): bool {
        return GeneralDiscount::query()->where('fk_discount', '=', $this->id)->first() !== null;
    }

    function solveFinal(int $price): int
    {
        if ($this->type === 'absolute') {
            return $price - $this->absolute_discount;
        }

        return $price - ($this->percentage_discount / 100) * $price;
    }

    function getValue(): int
    {
        return $this->isPercentage() ? $this->percentage_discount : $this->absolute_discount;
    }

    function isPercentage(): bool
    {
        return $this->type === 'percentage';
    }

    function isAbsolute(): bool
    {
        return $this->type === 'absolute';
    }
}
