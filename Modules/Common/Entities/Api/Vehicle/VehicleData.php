<?php

namespace Modules\Common\Entities\Api\Vehicle;

use App\Models\BaseModel;

class VehicleData extends BaseModel
{

    protected $table = 'c_vehicle_data';
    protected $fillable = [
        'code', 'vtype', 'plate_number', 'model', 'vehicle_kind',
        'base_size', 'secret_no', 'prod_country', 'prod_date',
        'chassis_no', 'color', 'tank_cap1', 'tank_cap2', 'weight',
        'max_mnt_order', 'allowed_ex_liter', 'purchase_date',
        'purchase_price', 'current_value', 'renew_date', 'vclass',
        'fuel_ratio', 'oil_ratio', 'base_type', 'trans_license',
        'GPS_device', 'ext_code', 'notes', 'cost_center_id',
        'account_id', 'vehicle_classification_id', 'vehicle_type_id',
        'car_status_id', 'document_type_id'
    ];
    public $translatable = ['plate_number','notes'];
    protected $with = ['vehicleDocument'];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function vehicleClassification()
    {
        return $this->belongsTo(VehicleClassification::class);
    }

    public function vehicleDocument()
    {
        return $this->hasMany(VehicleDocument::class);
    }

    public function vehicleWheel()
    {
        return $this->hasMany(VehicleWheel::class);
    }

    public function counts()
    {
        return $this->VehicleWheel()->count();
    }
}
