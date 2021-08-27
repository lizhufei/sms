<?php


namespace Hsvisus\Sms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;
    protected $table = 'verification_codes';
    protected $guarded = [];
    public $timestamps = false;
}
