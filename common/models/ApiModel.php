<?php

namespace common\models;

use Yii;
use common\models\PatientDetails;
use yii\db\Query;
/**
 * This is the model class for table "admin_details".
 *
 * @property int $id
 * @property int $admin_id admin_id maps with id in login table
 * @property string $name
 * @property string $email
 * @property string $phone_number
 * @property string $address
 * @property int $role_id
 * @property int $status
 * @property string profile_image
 */
class ApiModel extends \yii\db\ActiveRecord
{
    public function getUserDetails($idx, $mobile) 
    {
        $con = \Yii::$app->db;
        $response = [];
        $images = 'http://investigohealth.com/uploads/';
        switch ($idx) {
            case 100:
                $query = "SELECT $idx as idx, id as UserId,first_name as firstname,last_name as lastname,email,age,CASE WHEN gender = 1 THEN 'Male' WHEN gender = 2 THEN ' Female' ELSE 'Others' END as gender,state,city,district,city,area,latitude,longitude,phone as mobileno,refer_id as refererid,city,area,phone as mobileno,case when profile_image <> '' then concat('$images','patientdetails/',id,'/',id,'.',profile_image) else concat('$images','patientdetails/default.png') end as profile_image
                    from patient_details where phone='$mobile' and status =1;";
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $result = $con->createCommand($query)->queryOne();
            $response = ["status" => 1, "userData" => $result];
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

    public function getVerifyMobile($idx, $mobile) 
    {
        $con = \Yii::$app->db;
        $response = [];
        switch ($idx) {
            case 100:
                $query = "SELECT id as UserId
                    from patient_details where phone='$mobile' and status =1;";
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $result = $con->createCommand($query)->queryOne();
            if($result && isset($result['UserId']))
            {
                $otpInsertion = "UPDATE patient_details SET otp = '1234' where phone='$mobile';";
                $con->createCommand($otpInsertion)->execute();
            }else{
                $insert = "INSERT INTO patient_details(phone,status,otp)values('$mobile','1','1234');";
                $result1 = $con->createCommand($insert)->execute();
                $userId = $con->getLastInsertId();
                $result['UserId']=$userId;
            }
            $response = ["status" => 1, "content" => $result];
            return $response;
            $con->close();
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

    public function getVerifyOtp($idx, $otp, $userId, $mobile, $firebaseToken) 
    {
        $con = \Yii::$app->db;
        $response = [];
        switch ($idx) {
            case 100:
                $query = "SELECT id as UserId,first_name,last_name
                    from patient_details where otp='$otp' and phone ='$mobile';";
                $insert="UPDATE patient_details SET firebase_token = '$firebaseToken' WHERE phone ='$mobile' AND id='$userId';";
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $profileComplete = false;
            $result = $con->createCommand($query)->queryOne();
            if($result && isset($result['UserId']))
            {
                $result2 = $con->createCommand($insert)->execute();
                if(!empty($result['UserId']))
                {

                    if(!empty($result['first_name']))
                    {
                        $profileComplete = true;
                    }
                    $content = "success";
                    $UserId = $result['UserId'];
                    $response = ["status" => 1, "content" => $content,"UserId"=>$UserId,"profileComplete"=>$profileComplete];
                }else{
                    $content = "failure";
                    $UserId = '';
                    $response = ["status" => 2, "content" => $content,"UserId"=>$UserId,"profileComplete"=>$profileComplete];
                }
            }else{
                $response = ["status" => 2, "content" => "failure","UserId"=>"$userId","profileComplete"=>$profileComplete];
            }
            
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

    public function setUserDetails($datas) 
    {   
        
        $con = \Yii::$app->db;
        $response = [];
        $idx = $datas['idx'];
        
        $images = 'http://investigohealth.com/uploads/';
       
        switch ($idx) {
            case 100:
                if($datas['gender']=='Male'){$gender=1;}else if($datas['gender']=='Female'){$gender=2;}else{$gender='';}
                $check = "SELECT count(id) as cnt from patient_details where id = '$datas[userId]'";
                //   $duplicateInsert = "INSERT INTO patient_details(id,first_name,last_name,email,phone,age,gender,state,district,city,area,status,refer_id,latitude,longitude,created_on,profile_image)VALUES('$datas[userId]','$datas[firstname]','$datas[lastname]','$datas[email]','$datas[mobileno]','$datas[age]','$datas[gender]','$datas[state]','$datas[district]','$datas[city],'$datas[area]',1,'$datas[refererid]','$datas[latitude]','$datas[longitude]',now(),'')ON DUPLICATE KEY UPDATE id =values(id),first_name=values(first_name),last_name=values(last_name),email = values(email),phone=values(phone),age=values(age),gender=values(gender),state=values(state),district = values(district),city = values(city),area = values(area),status = values(status),refer_id=values(refer_id),latitude=values(latitude),longitude = values(longitude),created_on=values(created_on),profile_image=values(profile_image);";
                $duplicateInsert = "INSERT INTO patient_details(id,first_name,last_name,email,phone,age,gender,state,district,city,area,status,refer_id,latitude,longitude,created_on)VALUES('$datas[userId]','$datas[firstname]','$datas[lastname]','$datas[email]','$datas[mobileno]','$datas[age]','$gender','$datas[state]','$datas[district]','$datas[city]','$datas[area]',1,'$datas[refererid]','$datas[latitude]','$datas[longitude]',now())ON DUPLICATE KEY UPDATE id =values(id),first_name=values(first_name),last_name=values(last_name),email = values(email),phone=values(phone),age=values(age),gender=values(gender),state=values(state),district = values(district),city = values(city),area = values(area),status = values(status),refer_id=values(refer_id),latitude=values(latitude),longitude = values(longitude),created_on=values(created_on);";
               
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        //try { 
            $checkResult = $con->createCommand($check)->queryOne();
            if($checkResult)
            {
                if($checkResult['cnt'] > 0)
                {
                    $result = $con->createCommand($duplicateInsert)->execute();
                    if($result)
                    {
                        $id = $datas['userId'];
                        $image = $datas['profile_image'];
                        if($image != '')
                        {
                            list($type, $image) = explode(';', $image);
                            list(, $image)      = explode(',', $image);
                            $image = base64_decode($image);
                            $extensions = explode('/', $type);
                            $extension = $extensions[1];
                            $targetFolder = \yii::$app->basePath . '/../uploads/patientdetails/' . $id ;
                            $files = glob($targetFolder . '/*');
                            //Loop through the file list.
                            foreach($files as $file){
                                //Make sure that this is a file and not a directory.
                                if(is_file($file)){
                                    //Use the unlink function to delete the file.
                                    unlink($file);
                                }
                            }
                            if (!file_exists($targetFolder. '/')) {
                                mkdir($targetFolder. '/', 0777, true);
                                chmod($targetFolder. '/',0777);
                            }
                            file_put_contents($targetFolder. '/' . $id . '.' . $extension, $image);
                            $imageInsertion = "UPDATE patient_details set profile_image = '$extension' where id='$id';";
                            $con->createCommand($imageInsertion)->execute();
                        }
                    }
                    $userQuery = "SELECT $idx as idx, id as userId,first_name as firstname,last_name as lastname,email,age,CASE WHEN gender = 1 THEN 'Male' WHEN gender = 2 THEN 'Female' ELSE 'Other' END as gender,state,city,district,city,area,latitude,longitude,phone as mobileno,refer_id as refererid,case when profile_image <> '' then concat('$images','patientdetails/',id,'/',id,'.',profile_image) else concat('$images','patientdetails/default.png') end as profile_image
                    from patient_details where id = '$datas[userId]' AND phone='$datas[mobileno]' and status =1;";
                    $userResult = $con->createCommand($userQuery)->queryOne();
                    $msg = "Profile Updated";
                    $status = 1;
                }else{
                    $userResult = [];
                    $msg = "Profile Not Found";
                    $status = 2;
                    $response = ["status" => $status, "content" => $userResult,"msg"=>$msg];
                    return $response;
                }
            }else{ 
                    $userResult = [];
                    $msg = "Profile Not Found";
                    $status = 2;
                }
            
            $response = ["status" => $status, "content" => $userResult,"msg"=>$msg];
            $con->close();
            return $response;
        // } catch (yii\db\Exception $e) {
        //     $response = ["status" => 0, "content" => $e];
        //     $con->close();
        //     return $response;
        // }
    }
    public function getHospitalLabsDetails($datas) 
    {
       
        $con = \Yii::$app->db;
        $response = [];
        $idx = $datas['idx'];
        $curDate = date('Y-m-d');
        $images = 'http://investigohealth.com/uploads/';
        
        switch ($idx) {
            case 100:
                $type = $datas['type'];
                $searchbyName = $datas['searchby_name'];
                $searchCndn = $latlonSelect = $limitOffset = "";
                $latitude = $datas['latitude'];
                $longitude = $datas['longitude'];
                $pageLength = $datas['page_length'];
                $curPage = isset($datas['current_page'])?$datas['current_page']:0;
                $city = $datas['city'];
                if($curPage == 0)
                {
                    $start = 0;
                }else{
                    $start = $curPage*$pageLength + 1;
                }
                if(!empty($pageLength) && isset($curPage))
                {
                    $limitOffset = " LIMIT $pageLength OFFSET $start ";
                }
                if($searchbyName != '')
                {
                    $searchCndn = "AND name like '%$searchbyName%' ";
                }
                $bannerQuery = "SELECT concat('$images','banners/',id,'/',id,'.',image) as image from banners where expiry_date > '$curDate' and status = 1; ";
                
                if ($type == 'Hospital')
                {
                    if(!empty($latitude) && !empty($longitude))
                    {
                        $query = "SELECT
                                user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,
                                case when hospital_clinic_image <> '' then concat('$images','hospitalClinicImage/',id,'/',id,'.',hospital_clinic_image) else '' end as image,
                                (
                                    6371 *
                                    acos(
                                        cos( radians( '$latitude' ) ) *
                                        cos( radians(latitude) ) *
                                        cos(
                                            radians(longitude) - radians('$longitude')
                                        ) +
                                        sin(radians('$latitude')) *
                                        sin(radians(latitude))
                                    )
                                ) distance
                            FROM
                                hospital_clinic_details
                                WHERE status = 1 AND type = 1 $searchCndn 
                            HAVING
                                distance <= 25 
                            ORDER BY
                                distance
                            $limitOffset";
                    }else {
                        if($city != '')
                        {
                            $searchCndn.= "AND city like '%$city%' ";
                        }
                        $query = "SELECT user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,case when hospital_clinic_image <> '' then concat('$images','hospitalClinicImage/',id,'/',id,'.',hospital_clinic_image) else '' end as image FROM hospital_clinic_details WHERE status = 1 AND type = 1 $searchCndn $limitOffset;";
                    }
                }else{
                    
                    if(!empty($latitude) && !empty($longitude))
                    {
                        $query = "SELECT
                                user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,case when hospital_clinic_image <> '' then concat('$images','hospitalClinicImage/',id,'/',id,'.',hospital_clinic_image) else '' end  as image,
                                (
                                    6371 *
                                    acos(
                                        cos( radians( '$latitude' ) ) *
                                        cos( radians(latitude) ) *
                                        cos(
                                            radians(longitude) - radians('$longitude')
                                        ) +
                                        sin(radians('$latitude')) *
                                        sin(radians(latitude))
                                    )
                                ) distance
                            FROM
                                hospital_clinic_details
                                WHERE status = 1 AND type = 2 $searchCndn 
                            HAVING
                                distance <= 25 
                            ORDER BY
                                distance
                            $limitOffset";
                            
                    }else{
                        if($city != '')
                        {
                            $searchCndn.= "AND city like '%$city%' ";
                        }
                        $query = "SELECT user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,case when hospital_clinic_image <> '' then concat('$images','hospitalClinicImage/',id,'/',id,'.',hospital_clinic_image) else '' end  as image FROM hospital_clinic_details WHERE status = 1 AND type = 2 $searchCndn $limitOffset;";
                    }
                } 
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $result = $con->createCommand($query)->queryAll();
            $banner = $con->createCommand($bannerQuery)->queryAll();
            $response = ["status" => 1, "data" => $result,"current_page"=>$curPage,"banner_images"=>$banner];
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

    public function getHospitalDetails($datas) 
    {
        $con = \Yii::$app->db;
        $response = [];
        $idx = $datas['idx'];
        $curDate = date('Y-m-d');
        $images = 'http://investigohealth.com/uploads/';
        switch ($idx) {
            case 100:
                $type = $datas['type'];
                $id = $datas['id'];
                $query = "SELECT user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,case when hospital_clinic_image <> '' then concat('$images','hospitalClinicImage/',id,'/',id,'.',hospital_clinic_image) else '' end
                 as image
                            FROM
                                hospital_clinic_details 
                            WHERE status = 1 AND type = 1 AND user_id = '$id';";
                $doctorsQuery = "SELECT doc.id,doc.name,doc.experience as experiance,CASE when profile_image <> '' then 
                concat('$images','doctors/',doc.id,'/',doc.id,'.',doc.profile_image) else concat('$images','doctors/default.png') end as doctor_image
                ,sep.name as speciality,coalesce(fee_charges,0.00) as fees_charges
                        FROM doctors_details doc
                        JOIN doctor_specialty_mst sep ON sep.id = doc.specialty_id WHERE doc.hospital_clinic_id = '$id';";
               
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $result = $con->createCommand($query)->queryOne();
            $docResult = $con->createCommand($doctorsQuery)->queryAll();
            $result['doctor_list'] = $docResult;
            $response = ["status" => 1, "hospital" => $result];
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

    public function getLabDetails($datas) 
    {
        $con = \Yii::$app->db;
        $response = [];
        $idx = $datas['idx'];
        $images = 'http://investigohealth.com/../uploads/';
        switch ($idx) {
            case 100:
                $type = $datas['type'];
                $id = $datas['id'];
                $query = "SELECT user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,case when hospital_clinic_image <> '' then concat('$images','hospitalClinicImage/',id,'/',id,'.',hospital_clinic_image) else '' end
                 as image
                            FROM
                                hospital_clinic_details 
                            WHERE status = 1 AND type = 2 AND user_id = '$id';";
                $labCategory = "SELECT DISTINCT cat.id as category_id,cat.category_name as category FROM hospital_investigation_mapping hp JOIN investigations inv ON inv.id = hp.investigation_id 
                    JOIN category_mst cat ON cat.id = inv.mst_id
                    WHERE hp.hospital_clinic_id = '$id' AND inv.status = 1;";
                
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        //try { 
            $result = $con->createCommand($query)->queryAll();
            $catResult = $con->createCommand($labCategory)->queryAll();
            $invResponse = [];
            if($catResult)
            {
                foreach ($catResult as $key => $cat) {
                    $investigations = "SELECT
                                hpmapping.investigation_id as sub_category_id,
                                inv.investigation_name as name,
                                hpmapping.amount as price,CASE hpmapping.isHomeCollection WHEN 1 THEN 'true' ELSE 'false'  END as isHomeCollection ,COALESCE(hpmapping.details,'') as package_details 
                            FROM
                                hospital_clinic_details hp
                            JOIN hospital_investigation_mapping hpmapping
                                ON hpmapping.hospital_clinic_id = hp.user_id
                            JOIN investigations inv ON inv.id = hpmapping.investigation_id
                            WHERE hp.status = 1 AND hp.type = 2 AND hp.user_id = '$id' AND inv.mst_id = 
                            '$cat[category_id]';";
                    $invResult = $con->createCommand($investigations)->queryAll();
                    if($invResult){
                        $invResponse[] = [
                            'category_id'=>$cat['category_id'],
                            'category'   =>$cat['category'],
                            'data'=>$invResult
                        ];
                    }
                }
            }
            $response = ["status" => 1, "laboratory" => $result,"service"=>$invResponse];
            $con->close();
            return $response;
        // } catch (yii\db\Exception $e) {
        //     $response = ["status" => 0, "content" => $e];
        //     $con->close();
        //     return $response;
        // }
    }

    public function getLaboratorySlotdetails($datas) 
    {   
        $con = \Yii::$app->db;
        $response = [];
        $idx = $datas['idx'];
        switch ($idx) {
            case 100:
                $type = $datas['type'];
                $id = $datas['id'];
                if(empty($datas['sub_category_id']) && $datas['sub_category_id'] != ''){
                    return 'empty invstigations';
                }
                $investigation = $datas['sub_category_id'];
                $date = $datas['date'];
                $today = date('Y-m-d');
                $typeVal = 1;
                if($type == 'Hospital')
                {
                    $typeVal = 1;
                }else{
                    $typeVal = 2;
                }
                $investigationsResponse = [];
                $invQuery = "SELECT DISTINCT
                            slot.id as slotId,
                            CONCAT(DATE_FORMAT(slot.from_time, '%H:%i %p'),'-',DATE_FORMAT(slot.to_time, '%H:%i %p'))as time
                        FROM slot_day_time_mapping slot
                        JOIN 
                            hospital_clinic_details hp ON hp.user_id = slot.hospital_clinic_id 
                        JOIN slot_day_mapping day ON day.hospital_clinic_id = slot.hospital_clinic_id  AND slot.investigation_id = day.investigation_id AND slot.slot_day_id = day.id
                        LEFT JOIN appointments ap ON ap.investigation_id = slot.investigation_id AND ap.hospital_clinic_id = slot.hospital_clinic_id AND slot.id = ap.slot_day_time_mapping_id
                        LEFT JOIN holiday_list holy ON 
                    -- holy.investigation_id = slot.investigation_id AND 
                    holy.hospital_id = slot.hospital_clinic_id AND holy.holiday_date = '$date'
                        LEFT JOIN holiday_list holy1 ON 
                    holy1.investigation_id = slot.investigation_id AND 
                    holy1.hospital_id = slot.hospital_clinic_id AND holy1.holiday_date = '$date'
                        WHERE ap.slot_day_time_mapping_id IS NULL AND 
                            holy.id IS NULL AND holy1.id IS NULL AND hp.status = 1 AND hp.type = '$typeVal' AND slot.hospital_clinic_id = '$id' AND slot.investigation_id = '$investigation' AND day.day ='$date' AND day.day>='$today' AND (slot.from_time > NOW() AND slot.to_time > NOW()) ORDER BY from_time asc;";
                    $result = $con->createCommand($invQuery)->queryAll();
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $response = ["status" => 1, "time_slot" => $result];
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

    public function getDoctorSlotdetails($datas) 
    {
        $con = \Yii::$app->db;
        $response = [];
        $idx = $datas['idx'];
        switch ($idx) {
            case 100:
                $type = $datas['type'];
                $id = $datas['id'];
                $doctorId = $datas['doctorId'];
                $date = $datas['date'];
                $today = date('Y-m-d');
                $typeVal = 1;
                if($type == 'Hospital')
                {
                    $typeVal = 1;
                }else{
                    $typeVal = 2;
                }
                $docQuery = "SELECT DISTINCT
                            slot.id as slotId,
                            CONCAT(DATE_FORMAT(slot.from_time, '%H:%i %p'),'-',DATE_FORMAT(slot.to_time, '%H:%i %p'))as time
                        FROM slot_day_time_mapping slot
                        JOIN 
                            hospital_clinic_details hp ON hp.user_id = slot.hospital_clinic_id 
                        JOIN slot_day_mapping day ON day.hospital_clinic_id = slot.hospital_clinic_id  AND slot.doctor_id = day.doctor_id AND slot.slot_day_id = day.id
                        LEFT JOIN appointments ap ON ap.doctor_id = slot.doctor_id AND ap.hospital_clinic_id = slot.hospital_clinic_id AND slot.id = ap.slot_day_time_mapping_id
                        LEFT JOIN holiday_list holy ON 
                        -- holy.doctor_id = slot.doctor_id AND 
                        holy.hospital_id = slot.hospital_clinic_id AND holy.holiday_date = '$date'
                        LEFT JOIN holiday_list holy1 ON 
                         holy1.doctor_id = slot.doctor_id AND 
                        holy1.hospital_id = slot.hospital_clinic_id AND holy1.holiday_date = '$date'
                        WHERE ap.slot_day_time_mapping_id IS NULL AND 
                            holy.id IS NULL AND holy1.id IS NULL AND hp.status = 1 AND hp.type = '$typeVal' AND slot.hospital_clinic_id = '$id' AND slot.doctor_id = '$doctorId' AND day.day ='$date' AND day.day>='$today' AND (slot.from_time > NOW() AND slot.to_time > NOW())  ORDER BY from_time asc;";
                    $result = $con->createCommand($docQuery)->queryAll();
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $response = ["status" => 1, "time_slot" => $result];
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

    public function bookAppointments($datas) 
    {
        try { 
            $con = \Yii::$app->db;
            $response = [];
            $idx = $datas['idx'];
            switch ($idx) {
                case 100:
                    $transaction = $con->beginTransaction();
                    $type = $datas['type'];
                    $id = $datas['id'];
                    $investigations = $datas['investigations'];
                    if(empty($investigations)){
                        return 'empty investigations';
                    }
                    $typeVal = 1;
                    if($type == 'Hospital')
                    {
                        $typeVal = 1;
                    }else{
                        $typeVal = 2;
                    }
                    $appointmentType = $datas['appointmentType'];
                    if($appointmentType == 'other')
                    {
                        $appointmentTypeVal = 1; 
                    }else{
                        $appointmentTypeVal = 0;
                    }
                    $totalPrice = 0;
                    $status = "";
                    $resultVal = 1;
                    $bookedDuplicateArray = [];
                    $bookedArray = [];
                    foreach ($investigations as $key => $appointment) {
                        $checkSql = "SELECT  count(patient_id) cnt from appointments where doctor_id = '$appointment[doctorId]' AND investigation_id = '$appointment[investigation_id]' AND slot_day_time_mapping_id ='$appointment[slotId]' AND  hospital_clinic_id = '$id' AND app_date = '$appointment[date]';";
                        $count = $result = $con->createCommand($checkSql)->queryOne();
                        if($count && $count['cnt'] > 0)
                        {
                            $status = 2 ;
                            $resultVal = 2;
                            $bookedDuplicateArray[] = $appointment;
                            $transaction->commit();
                            $response = ["status" => $status, "alradyBookedAppoinments" => $bookedDuplicateArray,"booking_status"=>"failure","total_amount_to_pay"=>$totalPrice];
                            return $response;
                        }
                        $totalPrice = $totalPrice + $appointment['price'];
                        $appointmentQuery = "INSERT INTO appointments(patient_id,doctor_id,investigation_id, slot_day_time_mapping_id,hospital_clinic_id,app_date,app_time,appointment_type,isHomeCollection,price)VALUES('$datas[paitientId]','$appointment[doctorId]','$appointment[investigation_id]','$appointment[slotId]','$id','$appointment[date]','$appointment[time]','$appointmentTypeVal','$appointment[isHomeCollection]','$appointment[price]');";
                        $result = $con->createCommand($appointmentQuery)->execute();
                        if($result)
                        {   $bookingId =$con->getLastInsertId();
                            if($appointmentType == 'other')
                            { 
                                if(empty($datas['detDatas']))
                                {
                                    // $transaction->rollback();
                                    // return "empty other patient details";
                                    $status = 3 ;
                                    $resultVal = 3;
                                    $msg = "empty other patient details";
                                    break;
                                }else{
                                    $det = $datas['detDatas'];
                                    $detInsert = "INSERT INTO appoinment_det(mst_id,first_name,last_name,age,gender)VALUES('$bookingId','$det[firstName]','$det[lastName]','$det[age]','$det[gender]')";
                                    $resultDet = $con->createCommand($detInsert)->execute();
                                    if($resultDet)
                                    {
                                        //$transaction->commit();
                                        $resultVal = 1;
                                        $status = 1;
                                        $bookedArray[] = $bookingId;
                                        // $response = ["status" => 1, "bookingId" => $bookingId,"booking_status"=>"pending","total_amount_to_pay"=>$totalPrice];
                                    }
                                }
                            }else{
                               //$transaction->commit(); 
                                $resultVal = 1;
                                $status = 1;
                                $bookedArray[] = $bookingId;
                            }
                            // $response = ["status" => 1, "bookingId" => $bookingId,"booking_status"=>"pending","total_amount_to_pay"=>$totalPrice];
                        }else{
                            // $transaction->rollback();
                            // return "Error in appointment bookings";
                            $resultVal = 4;
                            $status = 4;
                        }
                    }
                    if($resultVal == 1){
                        $transaction->commit();
                        $response = ["status" => 1, "bookingId" => $bookedArray,"booking_status"=>"pending","total_amount_to_pay"=>$totalPrice];
                    }else{
                        if($resultVal == 3)
                        {
                            $msg = "empty other patient details";
                        }elseif($resultVal == 4)
                        {
                            $msg ="Error in appointment bookings";
                        }
                        $transaction->rollback();
                        $response = ["status" => 1,"message"=>$msg];
                    }
                    break;
                default :
                    return $response;
            }
            return $response;
            $con->close();
        } catch (yii\db\Exception $e) {
            $transaction->rollback();
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

    public function registerUserDetails($datas) 
    {   
        $con = \Yii::$app->db;
        $response = [];
        $idx = $datas['idx'];
        $images ='http://investigohealth.com/../uploads/';
        switch ($idx) {
            case 100:
            $image = $datas['profile_image'];
            
            if($datas['mobileno'] == '' || empty($datas['mobileno']))
            {
                $response = ["status" => 0, "content" => '',"msg"=>"failure, empty mobile no"];
                return $response;
            }
            if(strlen($datas['mobileno']) > 10 || strlen($datas['mobileno']) < 10)
            { 
                $response = ["status" => 0, "content" => '',"msg"=>"failure, invalid mobile no"];
                return $response;
            }
            $checkMobile = "SELECT id from patient_details where phone = '$datas[mobileno]';";
            $checkResult = $con->createCommand($checkMobile)->queryOne();
            if($checkResult)
            {
                if($checkResult['id']){
                    $id = $checkResult['id'];
                }else{
                    $response = ["status" => 0, "content" => '',"msg"=>"failure"];
                    return $response;
                }
            }else{
                $response = ["status" => 0, "content" => '',"msg"=>"failure"];
                return $response;
            }
            if($datas['gender']=='Male'){$gender=1;}else if($datas['gender']=='Female'){$gender=2;}else{$gender='';}
            $query = "UPDATE patient_details SET first_name = '$datas[firstname]',last_name = '$datas[lastname]',email ='$datas[email]',age='$datas[age]',gender='$gender',state='$datas[state]',district = '$datas[district]',city='$datas[city]',area='$datas[area]',refer_id='$datas[refererid]',latitude = '$datas[latitude]',longitude = '$datas[longitude]' WHERE id = '$id' AND phone = '$datas[mobileno]';";
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            
            $result = $con->createCommand($query)->execute();
            if($result){
                if($image != '' || trim($image != ''))
                { 
                    list($type, $image) = explode(';', $image);
                    list(, $image)      = explode(',', $image);
                    $image = base64_decode($image);
                    $extensions = explode('/', $type);
                    $extension = $extensions[1];
                    $targetFolder = \yii::$app->basePath . '/../uploads/patientdetails/' . $id . '/';
                    if (!file_exists($targetFolder)) {
                        mkdir($targetFolder, 0777, true);
                        chmod($targetFolder,0777);
                    }
                    file_put_contents($targetFolder . $id . '.' . $extension, $image);
                }else{

                    $extension = '';
                }
                
            }
                $userQuery = "SELECT $idx as idx, id as userId,first_name as firstname,last_name as lastname,email,age,CASE WHEN gender = 1 THEN 'Male' WHEN gender = 2 THEN ' Female' ELSE 'Others' END as gender,state,city,district,city,area,latitude,longitude,phone as mobileno,refer_id as refererid,case when profile_image <> '' then concat('$images','patientdetails/',id,'/',id,'.',profile_image) else concat('$images','patientdetails/default.png') end as profile_image
                    from patient_details where id = '$id' AND phone='$datas[mobileno]' and status =1;";
                $userResult = $con->createCommand($userQuery)->queryOne();
                $response = ["status" => 1, "content" => $userResult];
            
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

    public function setFeedBack($data) 
    {
        $con = \Yii::$app->db;
        $response = [];
        $idx = $data['idx'];
        switch ($idx) {
            case 100:
                $date = date('Y-m-d');
                $insert = "INSERT INTO feedback(user_id,user_type,message,rating,submit_date)values('$data[userId]','$data[userType]','$data[message]','$data[rating]','$date');";
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $result = $con->createCommand($insert)->execute();
            $response = ["status" => 1, "content" => $result];
            return $response;
            $con->close();
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

}
