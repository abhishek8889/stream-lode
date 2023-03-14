<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use App\Models\MembershipTier;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'unique_id',
        'stripe_customer_id',
        'membership_id',
        'profile_image_name',
        'profile_image_url',
        'phone',
        'description',
        'public_visibility',
        'password',
        'status',
        'active_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function membershipDetails(){
        return $this->belongsTo(MembershipTier::class,'membership_id');
    }
    public function message(){
        return $this->hasMany(Message::class,'reciever_id','_id');
    }
    public function appoinments(){
        return $this->hasMany(HostAppointments::class,'host_id','_id');
    }
  
}
