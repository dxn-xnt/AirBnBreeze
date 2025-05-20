<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyRules extends Model
{
    protected $table = 'property_rules';
    protected $primaryKey = 'prop_id';

    // ✅ Include prop_id in fillable
    protected $fillable = [
        'prop_id',
        'rule_check_in',
        'rule_check_out',
        'rule_no_smoking',
        'rule_no_pet',
        'rule_no_events',
        'rule_security_cam',
        'rule_alarm',
        'rule_stairs',
        'rule_cancellation',
        'rule_cancellation_rate',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'prop_id');
    }
}
