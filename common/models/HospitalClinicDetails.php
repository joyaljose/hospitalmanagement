<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hospital_clinic_details".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $type
 * @property string $phone_number
 * @property string $email
 * @property integer $have_diagnostic_center
 * @property integer $master_hospital_id
 * @property integer $same_as_hospital_details_flag
 * @property string $address
 * @property integer $pincode
 * @property string $street1
 * @property string $street2
 * @property string $city
 * @property string $area
 * @property string $latitude
 * @property string $longitude
 * @property integer $package_id
 * @property integer $created_by
 * @property integer $status
 * @property string $lab_name
 * @property string $lab_phone_number
 * @property string $lab_email
 * @property string $lab_address
 * @property integer $lab_pincode
 * @property string $lab_street1
 * @property string $lab_street2
 * @property string $lab_city
 * @property string $lab_area
 * @property string $lab_latitude
 * @property string $lab_longitude
 * @property string $state
 * @property string $hospital_clinic_image
 */
class HospitalClinicDetails extends \yii\db\ActiveRecord
{
    public $lab_name;

    public $lab_phone_number;

    public $lab_email;

    public $lab_address;

    public $lab_pincode;

    public $lab_street1;

    public $lab_street2;

    public $lab_city;

    public $lab_area;

    public $lab_latitude;

    public $lab_longitude;

    public $password;

    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hospital_clinic_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'email', 'status', 'created_by'], 'required'],

            [['name','email','phone_number','pincode','address','razorpay_id','razorpay_name','street1', 'street2', 'latitude', 'longitude','city', 'area','state'], 'required','on' => 'updateFrontend'],

[['phone_number'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],




            [['user_id', 'type', 'have_diagnostic_center', 'master_hospital_id', 'same_as_hospital_details_flag', 'package_id', 'created_by', 'status'], 'integer'],
            [['address'], 'string'],
            [['name', 'city', 'area'], 'string', 'max' => 150],
            [['phone_number'], 'string', 'min'=>10,'max' => 10,'message' => 'Please enter valid Phone Number.'],
            [['email', 'street1', 'street2', 'latitude', 'longitude'], 'string', 'max' => 250],
            ['email', 'unique'],
            ['email', 'email', 'message' => 'Please enter valid email address.'],

            [['lab_name','lab_phone_number','lab_email','lab_address','lab_pincode','lab_street1','lab_street2','lab_city','lab_area','lab_latitude','lab_longitude','hospital_clinic_image','state'],'safe'],

            [['lab_name','lab_phone_number','lab_email','lab_address','lab_pincode','lab_street1','lab_street2','lab_city','lab_area','lab_latitude','lab_longitude'],'required', 'when' => function($model) {
                return ($model->have_diagnostic_center == '1' && $model->same_as_hospital_details_flag == 0);
            },'enableClientValidation' => false],
            [['lab_phone_number'], 'string', 'min'=>10,'max' => 10,'message' => 'Please enter valid Phone Number.'],
            [['lab_phone_number'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['lab_pincode'], 'string', 'min'=>6,'max' => 6],
            [['lab_pincode'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            ['lab_email', 'unique'],
            ['lab_email', 'email', 'message' => 'Please enter valid email address.'],
            [['name','email', 'password','commision','commision_type'], 'required','on' => 'newrequest'],
            [['password'],'safe'],

            [['pincode'], 'string', 'min'=>6,'max' => 6],
            [['pincode'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['commision'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            ['commision', 'compare', 'compareValue' => 100, 'operator' => '<=','when' => function($model) {
                return $model->commision_type == '2'; 
            }],




            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'type' => 'Type',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'have_diagnostic_center' => 'Have Diagnostic Center',
            'master_hospital_id' => 'Master Hospital ID',
            'same_as_hospital_details_flag' => 'Same As Hospital Address',
            'address' => 'Address',
            'pincode' => 'Pincode',
            'street1' => 'Street1',
            'street2' => 'Street2',
            'city' => 'City',
            'area' => 'Area',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'package_id' => 'Subscription',
            'created_by' => 'Created By',
            'status' => 'Status',
            'state'=>'State',
            'hospital_clinic_image'=>'Image'
        ];
    }

   public function getStatusName($status)
    {
        $statArray=['4'=>'Account created','3'=>'Details entered','2'=>'Put on hold','1'=>'Approved'];    
        
            return $statArray[$status];
       
    }


    public function getPackageDetails() {
        return $this->hasOne(Packages::className(), ['id' => 'package_id']);
    }

    public function upload($file, $id, $name) {

       $targetFolder = \yii::$app->basePath . '/../uploads/hospitalClinicImage/' . $id . '/';
        if (!file_exists($targetFolder)) {
            mkdir($targetFolder, 0777, true);
            chmod($targetFolder,0777);
        }
        if ($file->saveAs($targetFolder . $id . '.' . $file->extension)) {
            chmod($targetFolder . $id . '.' . $file->extension,0777);
            return true;
        } else {
            return false;
        }
    }
}
