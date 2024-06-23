<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'fk_gender',
        'fk_role',
        'password',
        'birthdate',
        'suspended',
        'contact_number',
        'company_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getName(): string
    {
        return $this->first_name . ' ' . ($this->middle_name ? $this->middle_name[0] . '. ' : '') . $this->last_name;
    }

    public function getProcessedOrders(): array|null
    {
        $orders = DB::table('carts')
            ->join('payment_transactions', 'payment_transactions.id', '=', 'carts.fk_payment_transaction')
            ->where('payment_transactions.fk_user', '=', $this->user_id)
            ->select([
                'payment_transactions.id',
                'payment_transactions.fk_payment_method',
                'payment_transactions.fk_user',
                'carts.fk_product',
                'carts.fk_product_snapshot',
                'carts.fk_discount',
                'payment_transactions.created_at',
                'payment_transactions.updated_at',
            ])
            ->orderBy('payment_transactions.created_at', 'DESC')
            ->get();

        if (count($orders) === 0) {
            return null;
        }

        $grouped = [];
        foreach ($orders as $order) {
            if (!isset($grouped[$order->id])) {
                $grouped[$order->id] = array();
            }

            array_push($grouped[$order->id], $order);
        }

        return $grouped;
    }

    public function getRole(): Role
    {
        return Role::query()->find($this->fk_role);
    }

    public function isEmployee(): bool
    {
        return Role::query()->find($this->fk_role)->role === 'Employee';
    }

    public function isManager(): bool
    {
        return Role::query()->find($this->fk_role)->role === 'Manager';
    }

    public function isAdmin(): bool
    {
        return Role::query()->find($this->fk_role)->role === 'Admin';
    }
}
