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
        switch ($idx) {
            case 100:
                $query = "SELECT $idx as idx, id as UserId,first_name as firstname,last_name as lastname,email,age,CASE WHEN gender = 1 THEN 'Male' WHEN gender = 1 THEN ' Female' ELSE 'Others' END as gender,state,city,district,city,area,latitude,longitude,phone as mobileno,refer_id as referid,city,area,phone as mobileno,profile_image
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
                $result['UserId']="0";
            }
            $response = ["status" => 1, "content" => $result];
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

    public function getVerifyOtp($idx, $otp, $userId) 
    {
        $con = \Yii::$app->db;
        $response = [];
        switch ($idx) {
            case 100:
                $query = "SELECT id as UserId
                    from patient_details where otp='$otp' and id ='$userId';";
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $result = $con->createCommand($query)->queryOne();
            if($result && isset($result['UserId']))
            {
                if(!empty($result['UserId']))
                {
                    $content = "success";
                    $UserId = $result['UserId'];
                    $response = ["status" => 1, "content" => $content,"UserId"=>$UserId];
                }else{
                    $content = "failure";
                    $UserId = '';
                    $response = ["status" => 2, "content" => $content,"UserId"=>$UserId];
                }
            }else{
                $response = ["status" => 2, "content" => "failure","UserId"=>"$userId"];
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
        switch ($idx) {
            case 100:

                $check = "SELECT count(id) as cnt from patient_details where id = '$datas[userId]';";
                $duplicateInsert = "INSERT INTO patient_details(id,first_name,last_name,email,phone,age,gender,state,district,city,area,status,refer_id,latitude,longitude,created_on,profile_image)VALUES('$datas[userId]','$datas[firstname]','$datas[lastname]','$datas[email]','$datas[mobileno]','$datas[age]','$datas[gender]','$datas[state]','$datas[district]','$datas[city]','$datas[area]',1,'$datas[refererid]','$datas[latitude]','$datas[longitude]',now(),'$datas[profile_image]')ON DUPLICATE KEY UPDATE id =values(id),first_name=values(first_name),last_name=values(last_name),email = values(email),phone=values(phone),age=values(age),gender=values(gender),state=values(state),district = values(district),city = values(city),area = values(area),status = values(status),refer_id=values(refer_id),latitude=values(latitude),longitude = values(longitude),created_on=values(created_on),profile_image=values(profile_image);";
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $checkResult = $con->createCommand($check)->queryOne();
            if($checkResult)
            {
                if($checkResult['cnt'] > 0)
                {
                    $result = $con->createCommand($duplicateInsert)->execute();
                    $userQuery = "SELECT $idx as idx, id as UserId,first_name as firstname,last_name as lastname,email,age,CASE WHEN gender = 1 THEN 'Male' WHEN gender = 1 THEN ' Female' ELSE 'Others' END as gender,state,city,district,city,area,latitude,longitude,phone as mobileno,refer_id as referid,profile_image
                    from patient_details where id = '$datas[userId]' AND phone='$datas[mobileno]' and status =1;";
                    $userResult = $con->createCommand($userQuery)->queryOne();
                    $msg = "Profile Updated";
                    $status = 1;
                }else{
                    $userResult = [];
                    $msg = "Profile Not Found";
                    $status = 2;
                }
            }else{
                    $userResult = [];
                    $msg = "Profile Not Found";
                    $status = 2;
                }
            
            $response = ["status" => $status, "content" => $userResult,"msg"=>$msg];
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }
    public function getHospitalLabsDetails($datas) 
    {
        $con = \Yii::$app->db;
        $response = [];
        $idx = $datas['idx'];
        $curDate = date('Y-m-d');
        switch ($idx) {
            case 100:
                $type = $datas['type'];
                $searchbyName = $datas['searchby_name'];
                $searchCndn = $latlonSelect = $limitOffset = "";
                $latitude = $datas['latitude'];
                $longitude = $datas['longitude'];
                $pageLength = $datas['pageLength'];
                $curPage = isset($datas['curPage'])?$datas['curPage']:0;
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
                $bannerQuery = "SELECT image from banners where expiry_date > '$curDate' and status = 1; ";
                if ($type == 'Hospital')
                {
                    if(!empty($latitude) && !empty($longitude))
                    {
                        $query = "SELECT
                                user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,hospital_clinic_image as image,
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
                            $searchCndn.= "AND city like '%$searchbyName%' ";
                        }
                        $query = "SELECT user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,hospital_clinic_image as image FROM hospital_clinic_details WHERE status = 1 AND type = 1 $searchCndn $limitOffset;";
                    }
                }else{
                    if(!empty($latitude) && !empty($longitude))
                    {
                        $query = "SELECT
                                user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,hospital_clinic_image as image,
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
                            $searchCndn.= "AND city like '%$searchbyName%' ";
                        }
                        $query = "SELECT user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,hospital_clinic_image as image FROM hospital_clinic_details WHERE status = 1 AND type = 2 $searchCndn $limitOffset;";
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
        switch ($idx) {
            case 100:
                $type = $datas['type'];
                $id = $datas['id'];
                $query = "SELECT user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,hospital_clinic_image as image
                            FROM
                                hospital_clinic_details 
                            WHERE status = 1 AND type = 1 AND user_id = '$id';";
                $doctorsQuery = "SELECT doc.name,doc.experience,doc.profile_image,sep.name as speciality,0 as fees_charges
                        FROM doctors_details doc
                        JOIN doctor_specialty_mst sep ON sep.id = doc.specialty_id WHERE doc.hospital_clinic_id = '$id';";
                
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $result = $con->createCommand($query)->queryAll();
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
        switch ($idx) {
            case 100:
                $type = $datas['type'];
                $id = $datas['id'];
                $query = "SELECT user_id as id,name,type,phone_number,email,address,pincode,street1,street2,city,area,hospital_clinic_image as image
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
        try { 
            $result = $con->createCommand($query)->queryAll();
            $catResult = $con->createCommand($labCategory)->queryAll();
            $invResponse = [];
            if($catResult)
            {
                foreach ($catResult as $key => $cat) {
                    $investigations = "SELECT
                                hpmapping.investigation_id as sub_category_id,
                                inv.investigation_name as name,
                                hpmapping.amount as price,0 as isHomeCollection 
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
                            'subcategory'=>$invResult
                        ];
                    }
                }
            }
            $response = ["status" => 1, "laboratory" => $result,"service"=>$invResponse];
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
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
                        WHERE ap.slot_day_time_mapping_id IS NULL AND hp.status = 1 AND hp.type = '$typeVal' AND slot.hospital_clinic_id = '$id' AND slot.investigation_id = '$investigation' AND day.day ='$date' ORDER BY from_time asc;";

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
                        WHERE ap.slot_day_time_mapping_id IS NULL AND hp.status = 1 AND hp.type = '$typeVal' AND slot.hospital_clinic_id = '$id' AND slot.doctor_id = '$doctorId' AND day.day ='$date' ORDER BY from_time asc;";

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
                    $totalPrice = '';
                    foreach ($investigations as $key => $appointment) {
                        //print_r($appointment);exit;
                        $totalPrice = $appointment['price'];
                        $appointmentQuery = "INSERT INTO appointments(patient_id,doctor_id,investigation_id, slot_day_time_mapping_id,hospital_clinic_id,app_date,app_time,appointment_type,isHomeCollection,price)VALUES('$datas[paitientId]','$appointment[doctorId]','$appointment[investigation_id]','$appointment[slotId]','$id','$appointment[date]','$appointment[time]','$appointmentTypeVal','$appointment[isHomeCollection]','$appointment[price]');";
                        $result = $con->createCommand($appointmentQuery)->execute();
                        if($result)
                        {   $bookingId =$con->getLastInsertId();
                            if($appointmentType == 'other')
                            { 
                                if(empty($datas['detDatas']))
                                {
                                    $transaction->rollback();
                                    return "empty other patient details";
                                }else{
                                    $det = $datas['detDatas'];
                                    $detInsert = "INSERT INTO appoinment_det(mst_id,first_name,last_name,age,gender)VALUES('$bookingId','$det[firstName]','$det[lastName]','$det[age]','$det[gender]')";
                                    $resultDet = $con->createCommand($detInsert)->execute();
                                    if($resultDet)
                                    {
                                        $transaction->commit();
                                        $response = ["status" => 1, "bookingId" => $bookingId,"booking_status"=>"pending","total_amount_to_pay"=>$totalPrice];
                                    }
                                }
                            }else{
                               $transaction->commit(); 
                            }
                            $response = ["status" => 1, "bookingId" => $bookingId,"booking_status"=>"pending","total_amount_to_pay"=>$totalPrice];
                        }else{
                            $transaction->rollback();
                            return "Error in appointment bookings";
                        }
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
        switch ($idx) {
            case 100:
                $query = "INSERT INTO patient_details(first_name,last_name,email,phone,age,gender,state,district,city,area,status,refer_id,latitude,longitude,created_on,profile_image)VALUES('$datas[firstname]','$datas[lastname]','$datas[email]','$datas[mobileno]','$datas[age]','$datas[gender]','$datas[state]','$datas[district]','$datas[city]','$datas[area]',1,'$datas[refererid]','$datas[latitude]','$datas[longitude]',now(),'$datas[profile_image]')";
                break;
            default :
                $response = ["status" => 2, "content" => ""];
                return $response;
        }
        try { 
            $result = $con->createCommand($query)->execute();
            if($result){
                $id = $con->getLastInsertId();
                $otpInsertion = "UPDATE patient_details SET otp = '1234' where id='$id';";
                    $con->createCommand($otpInsertion)->execute();
                $userQuery = "SELECT $idx as idx, id as UserId,first_name as firstname,last_name as lastname,email,age,CASE WHEN gender = 1 THEN 'Male' WHEN gender = 1 THEN ' Female' ELSE 'Others' END as gender,state,city,district,city,area,latitude,longitude,phone as mobileno,refer_id as referid,profile_image
                    from patient_details where id = '$id' AND phone='$datas[mobileno]' and status =1;";
                $userResult = $con->createCommand($userQuery)->queryOne();
                $msg = "Profile Created";
                $response = ["status" => 1, "content" => $userResult,"msg"=>$msg];
            }else{
                $response = ["status" => 0, "content" => '',"msg"=>"failure"];
            }
            $con->close();
            return $response;
        } catch (yii\db\Exception $e) {
            $response = ["status" => 0, "content" => $e];
            $con->close();
            return $response;
        }
    }

}
