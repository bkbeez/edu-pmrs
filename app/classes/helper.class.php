<?php
/**
 * Helper Class
 */
class Helper {

    /**
     * Is Local
     * @param void
     * @return boolean
     */
    static function isLocal()
    {
        return in_array($_SERVER["HTTP_HOST"], array('127.0.0.1','localhost','prms.edu.cmu'));
    }

    /**
     * Get Budget Year
     * @param be or ce
     * @return year
     */
    static function getBudgetYear($date=null, $be=false)
    {
        if( $date==null ){
            $datetime = new datetime();
        }else if( $date instanceof DateTime ){
            // This is date
            $datetime = $date;
        }else{
            $datetime = new datetime($date);
        }
        $year = null;
        if($be){
            if( intval($datetime->format('m'))>9 ){
                $year = intval($datetime->format('Y'))+543+1;
            }else{
                $year = intval($datetime->format('Y'))+543;
            }
        }else{
            if( intval($datetime->format('m'))>9 ){
                $year = intval($datetime->format('Y'))+1;
            }else{
                $year = intval($datetime->format('Y'));
            }
        }

        return $year;
    }

    /**
     * Get Holiday Name
     * @param date
     * @return string
     */
    static function getHolidayName($date){
        $datetime = new datetime($date);
        if( in_array($datetime->format("l"), array('Sunday','Saturday') ) ){
            return ( ($datetime->format("l")=="Saturday") ? "วันเสาร์" : "วันอาทิตย์" );
        }else{
            $holiday = DB::one("SELECT day,description FROM tbl_holiday WHERE day=:day AND active=0;", array("dbname"=>DB_PREFIX."employee"), array('day'=>$date));
            if(isset($holiday['day'])&&$holiday['day']){
                return $holiday['description'];
            }
        }
        
        return null;
    }

    /**
     * Number Save
     * @param number
     * @return number
     */
    static function numberSave($number)
    {
        return intval(str_replace(',', '', $number));
    }

    /**
     * Number Digit
     * @param number
     * @return string
     */
    static function numberDigit($number, $digit=1, $is_hidden=false)
    {
        $numberdigit = sprintf("%1$0".$digit."d", $number);
        if( $is_hidden ){
            $hide = ".";
            $show = "";
            for($i=0;$i<(strlen($numberdigit)-1);$i++){
                if(intval($numberdigit[$i])>0){
                    break;
                }
                $hide .= "0";
                $show .= "0";
            }
            $numberdigit = str_replace($hide, '<span style=visibility:hidden;>'.$show.'</span>', ".".$numberdigit);
        }

        return $numberdigit;
    }

    /**
     * Number Quantity
     * @param amount
     * @return string
     */
    static function numberQuantity($number)
    {
        return str_replace(".00", "", $number);
    }

    /**
     * Number Thai
     * @param number
     * @return string
     */
    static function numberThai($number, $is_reverse=false)
    {
        if( $is_reverse ){
            return str_replace(array( '๐', '๑', '๒', '๓', '๔', '๕', '๖', '๗', '๘', '๙' ), array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ), $number); 
        }

        return str_replace(array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ), array( '๐', '๑', '๒', '๓', '๔', '๕', '๖', '๗', '๘', '๙' ), $number);  
    }

    /**
     * Number Thai String
     * @param number
     * @return string
     */
    static function numberThaiString($number)
    {
        $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
        $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
        $number = $number + 0;
        $string = "";
        if ($number == 0) return $string;
        if ($number > 1000000) {
            $string .= Helper::numberThaiString(intval($number / 1000000)) . "ล้าน";
            $number = intval(fmod($number, 1000000));
        }
       
        $divider = 100000;
        $pos = 0;
        while($number > 0) {
            $d = intval($number / $divider);
            $string .= (($divider == 10) && ($d == 2)) ? "ยี่" :
                ((($divider == 10) && ($d == 1)) ? "" :
                ((($divider == 1) && ($d == 1) && ($string != "")) ? "เอ็ด" : $number_call[$d]));
            $string .= ($d ? $position_call[$pos] : "");
            $number = $number % $divider;
            $divider = $divider / 10;
            $pos++;
        }

        return $string;
    }

    /**
     * Number Thai Money
     * @param number
     * @return string
     */
    static function numberThaiMoney($number)
    {
        $number = number_format($number, 2, ".","");
        $pt = strpos($number , ".");
        $amount = $fraction = "";
        if ($pt === false){
            $amount = $number;
        }else{
            $amount = substr($number, 0, $pt);
            $fraction = substr($number, $pt + 1);
        }
       
        $string = "";
        $baht = Helper::numberThaiString($amount);
        if ($baht != ""){ $string .= $baht . "บาท"; }
        if( $amount<=0 ){ $string = "ศูนย์บาท"; }
        $satang = Helper::numberThaiString($fraction);
        if ($satang != ""){
            $string .=  $satang . "สตางค์";
        }else{
            $string .= "ถ้วน";
        }

        return $string;
    }

    /**
     * Number Thai Month
     * @param  number
     * @return string
     */
    static function numberThaiMonth($number, $is_short=false)
    {
        $month = null;
        $m = intval($number);
        if( $is_short ){
            switch ( $m ) {
                case  1 : $month = "ม.ค.";     break;
                case  2 : $month = "ก.พ.";     break;
                case  3 : $month = "มี.ค.";     break;
                case  4 : $month = "เม.ย.";    break;
                case  5 : $month = "พ.ค.";     break;
                case  6 : $month = "มิ.ย.";     break;
                case  7 : $month = "ก.ค.";     break;
                case  8 : $month = "ส.ค.";     break;
                case  9 : $month = "ก.ย.";     break;
                case 10 : $month = "ต.ค.";     break;
                case 11 : $month = "พ.ย.";     break;
                case 12 : $month = "ธ.ค.";     break;
                default :
                    $month = null;
                    break;
            }
        }else{
            switch ( $m ) {
                case  1 : $month = "มกราคม";   break;
                case  2 : $month = "กุมภาพันธ์";  break;
                case  3 : $month = "มีนาคม";    break;
                case  4 : $month = "เมษายน";   break;
                case  5 : $month = "พฤษภาคม";  break;
                case  6 : $month = "มิถุนายน";   break;
                case  7 : $month = "กรกฎาคม";  break;
                case  8 : $month = "สิงหาคม";   break;
                case  9 : $month = "กันยายน";   break;
                case 10 : $month = "ตุลาคม";    break;
                case 11 : $month = "พฤศจิกายน"; break;
                case 12 : $month = "ธันวาคม";   break;
                default :
                    $month = null;
                    break;
            }
        }

        return $month;
    }

    /**
     * Decimal Save
     * @param decimal
     * @return decimal
     */
    static function decimalSave($decimal)
    {
        return doubleval(str_replace(',', '', $decimal));
    }

    /**
     * String Save
     * @param string
     * @return string
     */
    static function stringSave($string)
    {
        $values = explode(" ", $string);
        $results = "";
        foreach ($values as $value) {
            if($value&&$value!=" "){
                $results .= " ".trim($value);
            }
        }

        return substr($results, 1);
    }

    /**
     * String Html
     * @param string
     * @return string
     */
    static function stringHtml($string)
    {
        return htmlentities($string);
    }

    /**
     * String Sql In
     * @param string
     * @return string
     */
    static function stringSqlIn($string)
    {
        $values = explode(",", $string);
        $results = "";
        foreach ($values as $value) {
            if($value){
                $results .= ",'".$value."'";
            }
        }
        $results = substr($results, 1);

        return $results;
    }

    /**
     * String Title Short
     * @param  string
     * @return string
     */
    static function stringTitleShort($string)
    {
        return str_replace(array( 'ผู้ช่วยศาสตราจารย์ ดร.', 'ผู้ช่วยศาสตราจารย์', 'รองศาสตราจารย์ ดร.', 'รองศาสตราจารย์', 'ศาสตราจารย์ ดร.', 'ศาสตราจารย์', 'อาจารย์ ดร.', 'อาจารย์', 'นางสาว' )
                         , array( 'ผศ.ดร.', 'ผศ.', 'รศ.ดร.', 'รศ.', 'ศ.ดร.', 'ศ.', 'อ.ดร.', "อ.", 'น.ส.' )
                         , $string);  
    }

    /**
     * String Title Ignore
     * @param  string
     * @return string
     */
    static function stringTitleIgnore($string)
    {
        return str_replace(array( 'ผู้ช่วยศาสตราจารย์ ดร.', 'ผู้ช่วยศาสตราจารย์', 'รองศาสตราจารย์ ดร.', 'รองศาสตราจารย์', 'ศาสตราจารย์ ดร.', 'ศาสตราจารย์', 'อาจารย์ ดร.' )
                         , array( 'ผศ.ดร.', 'ผศ.', 'รศ.ดร.', 'รศ.', 'ศ.ดร.', 'ศ.', 'อ.ดร.' )
                         , $string);  
    }

    /**
     * Year Save
     * @param year
     * @return string
     */
    static function yearSave($year, $is_be=false)
    {
        $results = null;
        if( $year ){
            if( $is_be ){
                $results = intval($year);
            }else{
                $results = intval($year)-543;
            }
        }

        return $results;
    }

    /**
     * Date
     * @param date
     * @return string
     */
    static function date($date, $is_be=true)
    {
        if( $date instanceof DateTime ){
            // This is date
        }else{
            $date = new datetime($date);
        }
        $year = intval($date->format("Y"));
        if( $is_be ){
            $year += 543;
        }

        return ($date->format("d")."/".$date->format("m")."/".$year);
    }

    /**
     * Date Short
     * @param date
     * @return string
     */
    static function dateShort($date, $is_be=true)
    {
        if( $date instanceof DateTime ){
            // This is date
        }else{
            $date = new datetime($date);
        }
        $year = intval($date->format("Y"));
        if( $is_be ){
            $year += 543;
        }
        $year = substr($year, 2, 2);

        return ($date->format("d")."/".$date->format("m")."/".$year);
    }

    /**
     * Date Save
     * @param date
     * @return string
     */
    static function dateSave($date, $is_be=true)
    {
        $results = null;
        $dates = explode(" ", $date);
        if( isset($dates[0])&&$dates[0] ){
            $date = explode("/", $dates[0]);
            $year = intval($date[2]);
            if( $is_be ){
                $year -= 543;
            }
            $results = $year."-".$date[1]."-".$date[0];
        }
        if( isset($dates[1])&&$dates[1] ){
            $results .= $dates[1];
        }

        return $results;
    }

    /**
     * Date Thai
     * @param  date
     * @return string
     */
    static function dateThai($date, $is_be=true, $is_day=true)
    {
        if( $date instanceof DateTime ){
            // This is date
        }else{
            $date = new datetime($date);
        }
        $day = intval($date->format("d"));
        switch ( $date->format("m") ) {
            case '01': $month = "มกราคม";   break;
            case '02': $month = "กุมภาพันธ์";  break;
            case '03': $month = "มีนาคม";    break;
            case '04': $month = "เมษายน";   break;
            case '05': $month = "พฤษภาคม";  break;
            case '06': $month = "มิถุนายน";   break;
            case '07': $month = "กรกฎาคม";  break;
            case '08': $month = "สิงหาคม";   break;
            case '09': $month = "กันยายน";   break;
            case '10': $month = "ตุลาคม";    break;
            case '11': $month = "พฤศจิกายน"; break;
            case '12': $month = "ธันวาคม";   break;
            default:
                $month = null;
                break;
        }
        $year = intval($date->format("Y"))+543;
        $result = (($is_day)?$day:null)." ".$month.(($is_be)?" พ.ศ. ":" ").$year;

        return $result;
    }

    /**
     * Date Thai Short
     * @param  date
     * @return string
     */
    static function dateThaiShort($date, $is_short_year=true, $is_day=true)
    {
        if( $date instanceof DateTime ){
            // This is date
        }else{
            $date = new datetime($date);
        }
        $day = intval($date->format("d"));
        switch ( $date->format("m") ) {
            case '01': $month = "ม.ค.";   break;
            case '02': $month = "ก.พ.";   break;
            case '03': $month = "มี.ค.";   break;
            case '04': $month = "เม.ย.";  break;
            case '05': $month = "พ.ค.";   break;
            case '06': $month = "มิ.ย.";   break;
            case '07': $month = "ก.ค.";   break;
            case '08': $month = "ส.ค.";   break;
            case '09': $month = "ก.ย.";   break;
            case '10': $month = "ต.ค.";   break;
            case '11': $month = "พ.ย.";   break;
            case '12': $month = "ธ.ค.";   break;
            default:
                $month = null;
                break;
        }

        $year = intval($date->format("Y"))+543;
        if( $is_short_year ){
            $year = substr($year, 2, 2);
        }
        
        $result = (($is_day)?$day:null)." ".$month." ".$year;

        return $result;
    }

    /**
     *  Date Thai Short Range
     *  @param  from, to, short_year, is_day
     *  @return string
     */
    static function dateThaiShortRange($from, $to, $short_year=false, $is_day=true)
    {
        if( $from instanceof DateTime ){
            // This is datetime
        }else{
            $from = new datetime($from);
        }

        if( $to instanceof DateTime ){
            // This is datetime
        }else{
            $to = new datetime($to);
        }

        if( 0&&($from->format("Y")==$to->format("Y"))&&($from->format("m")==$to->format("m")) ){
            $m = $from->format("m");
            switch ($m) {
                case '01': $month = "ม.ค.";   break;
                case '02': $month = "ก.พ.";   break;
                case '03': $month = "มี.ค.";   break;
                case '04': $month = "เม.ย.";  break;
                case '05': $month = "พ.ค.";   break;
                case '06': $month = "มิ.ย.";   break;
                case '07': $month = "ก.ค.";   break;
                case '08': $month = "ส.ค.";   break;
                case '09': $month = "ก.ย.";   break;
                case '10': $month = "ต.ค.";   break;
                case '11': $month = "พ.ย.";   break;
                case '12': $month = "ธ.ค.";   break;
                default:
                    $month = null;
                    break;
            }
            $year = intval($from->format("Y"))+543;
            if( $short_year ){
                $year = substr($year, 2, 2);
            }
            
            $result = (($is_day)?intval($from->format("d"))." - ".intval($to->format("d")):null)." ".$month." ".$year;
        }else{
            $result = Helper::dateThaiShort($from, $short_year, $is_day)." - ".Helper::dateThaiShort($to, $short_year, $is_day);
        }

        return $result;
    }

    /**
     * Date Thai Week
     * @param  date
     * @return string
     */
    static function dateThaiWeek($date, $is_short=false)
    {
        $result = null;
        if( $date instanceof DateTime ){
            // This is date
        }else{
            $date = new datetime($date);
        }
        $day = $date->format("l");
        if($is_short ){
            switch ($day) {
                case 'Sunday':    $result = "อา"; break;
                case 'Monday':    $result = "จ";  break;
                case 'Tuesday':   $result = "อ";  break;
                case 'Wednesday': $result = "พ";  break;
                case 'Thursday':  $result = "พฤ"; break;
                case 'Friday':    $result = "ศ";  break;
                case 'Saturday':  $result = "ส";  break;
                default:          $result = null; break;
            }
        }else{
            switch ($day) {
                case 'Sunday':    $result = "อาทิตย์";   break;
                case 'Monday':    $result = "จันทร์";    break;
                case 'Tuesday':   $result = "อังคาร";   break;
                case 'Wednesday': $result = "พุธ";      break;
                case 'Thursday':  $result = "พฤหัสบดี";  break;
                case 'Friday':    $result = "ศุกร์";     break;
                case 'Saturday':  $result = "เสาร์";    break;
                default:          $result = null;      break;
            }
        }

        return $result;
    }

    /**
     *  Date Thai Week Full
     *  @param  datetime, is_full, is_be, is_day
     *  @return string
     */
    static function dateThaiWeekFull($datetime, $is_full=false, $is_be=true, $is_day=true)
    {
        if( $datetime instanceof DateTime ){
            // This is datetime
        }else{
            $datetime = new datetime($datetime);
        }
        $w = $datetime->format("l");
        if($is_full){
            $week = null;
            switch ($w) {
                case 'Sunday':    $week = "อาทิตย์";   break;
                case 'Monday':    $week = "จันทร์";    break;
                case 'Tuesday':   $week = "อังคาร";   break;
                case 'Wednesday': $week = "พุธ";      break;
                case 'Thursday':  $week = "พฤหัสบดี";  break;
                case 'Friday':    $week = "ศุกร์";     break;
                case 'Saturday':  $week = "เสาร์";    break;
                default:          $week = null;      break;
            }

            $day = intval($datetime->format("d"));
            $m = $datetime->format("m");
            switch ($m) {
                case '01': $month = "มกราคม";   break;
                case '02': $month = "กุมภาพันธ์";  break;
                case '03': $month = "มีนาคม";    break;
                case '04': $month = "เมษายน";   break;
                case '05': $month = "พฤษภาคม";  break;
                case '06': $month = "มิถุนายน";   break;
                case '07': $month = "กรกฎาคม";  break;
                case '08': $month = "สิงหาคม";   break;
                case '09': $month = "กันยายน";   break;
                case '10': $month = "ตุลาคม";    break;
                case '11': $month = "พฤศจิกายน"; break;
                case '12': $month = "ธันวาคม";   break;
                default:
                    $month = null;
                    break;
            }
            $year = intval($datetime->format("Y"))+543;
            $result = $week.'ที่ '.(($is_day)?$day:null)." ".$month.(($is_be)?" พ.ศ. ":" ").$year;
        }else{
            $week = null;
            switch ($w) {
                case 'Sunday':    $result = "อา"; break;
                case 'Monday':    $result = "จ";  break;
                case 'Tuesday':   $result = "อ";  break;
                case 'Wednesday': $result = "พ";  break;
                case 'Thursday':  $result = "พฤ"; break;
                case 'Friday':    $result = "ศ";  break;
                case 'Saturday':  $result = "ส";  break;
                default:          $result = null; break;
            }
            $day_month = $datetime->format("d/m");
            $year = intval($datetime->format("Y"))+543;
            $result = $week.' ที่ '.$day_month."/".$year;
        }
        return $result;
    }

    /**
     * Date Thai Month
     * @param  date
     * @return string
     */
    static function dateThaiMonth($date, $is_short=false)
    {
        if( $date instanceof DateTime ){
            // This is date
        }else{
            $date = new datetime($date);
        }
        $month = null;
        $m = $date->format("m");
        if( $is_short ){
            switch ($m) {
                case '01': $month = "ม.ค.";     break;
                case '02': $month = "ก.พ.";     break;
                case '03': $month = "มี.ค.";     break;
                case '04': $month = "เม.ย.";    break;
                case '05': $month = "พ.ค.";     break;
                case '06': $month = "มิ.ย.";     break;
                case '07': $month = "ก.ค.";     break;
                case '08': $month = "ส.ค.";     break;
                case '09': $month = "ก.ย.";     break;
                case '10': $month = "ต.ค.";     break;
                case '11': $month = "พ.ย.";     break;
                case '12': $month = "ธ.ค.";     break;
                default:
                    $month = null;
                    break;
            }
        }else{
            switch ($m) {
                case '01': $month = "มกราคม";   break;
                case '02': $month = "กุมภาพันธ์";  break;
                case '03': $month = "มีนาคม";    break;
                case '04': $month = "เมษายน";   break;
                case '05': $month = "พฤษภาคม";  break;
                case '06': $month = "มิถุนายน";   break;
                case '07': $month = "กรกฎาคม";  break;
                case '08': $month = "สิงหาคม";   break;
                case '09': $month = "กันยายน";   break;
                case '10': $month = "ตุลาคม";    break;
                case '11': $month = "พฤศจิกายน"; break;
                case '12': $month = "ธันวาคม";   break;
                default:
                    $month = null;
                    break;
            }
        }

        return $month;
    }

    /**
     * Date Thai Year
     * @param  date
     * @return string
     */
    static function dateThaiYear($date, $is_short=false)
    {
        if( $date instanceof DateTime ){
            // This is date
        }else{
            $date = new datetime($date);
        }
        $year = null;
        if( $is_short ){
            $year = substr((intval($date->format("Y"))+543), 2);
        }else{
            $year = (intval($date->format("Y"))+543);
        }

        return $year;
    }

    /**
     * Date Signature
     * @param date
     * @return string
     */
    static function dateSignature($date, $is_short_year=true, $separate=" / ", $is_time=null)
    {
        if( $date instanceof DateTime ){
            // This is date
        }else{
            $date = new datetime($date);
        }
        $month = $date->format("m");
        switch ($month) {
            case '01': $month = "ม.ค.";   break;
            case '02': $month = "ก.พ.";   break;
            case '03': $month = "มี.ค.";   break;
            case '04': $month = "เม.ย.";  break;
            case '05': $month = "พ.ค.";   break;
            case '06': $month = "มิ.ย.";   break;
            case '07': $month = "ก.ค.";   break;
            case '08': $month = "ส.ค.";   break;
            case '09': $month = "ก.ย.";   break;
            case '10': $month = "ต.ค.";   break;
            case '11': $month = "พ.ย.";   break;
            case '12': $month = "ธ.ค.";   break;
            default:
                $month = $date->format("m");
                break;
        }
        $year = intval($date->format("Y"))+543;
        if( $is_short_year ){
            $year = substr($year, 2, 2);
        }

        return (intval($date->format("d")).$separate.$month.$separate.$year).( $is_time ? $date->format($is_time) : null );
    }

    /**
     * Date Calculate
     * @param  start_date, end_date
     * @return array
     */
    static function dateCalculate($start_date, $end_date=null)
    {
        $result = array('years'=>0,'months'=>0,'days'=>0);
        $from = new datetime($start_date);
        $to = ( ($end_date) ? new datetime($end_date) : new datetime() );
        $fy = intval($from->format("Y"));
        $fm = intval($from->format("m"));
        $fcheck = $from->format("Ym");
        $ly = intval($to->format("Y"));
        $lm = intval($to->format("m"));
        $lcheck = $to->format("Ym");
        for( $y=$fy;$y<=$ly;$y++ ){
            for( $m=1;$m<=12;$m++ ){
                $icheck = $y.sprintf("%1$02d",$m);
                if( ($y==$fy&&$m<$fm) || ($y==$ly&&$m>$lm) ){
                    continue;
                }
                $days = cal_days_in_month(CAL_GREGORIAN,$m,$y);
                if($icheck==$fcheck){
                    $fd = intval($from->format("d"));
                    if($fd==1){
                        $result['months']++;
                    }else{
                        $result['days']+=$days-(intval($from->format("d"))-1);
                    }
                }else if($icheck==$lcheck){
                    $ld = intval($to->format("d"));
                    if($ld==$days){
                        $result['months']++;
                    }else{
                        $result['days']+=$ld;

                    }
                }else{
                    $result['months']++;
                }
            }
        }
        if($result['months']>=12){
            $result['years'] = floor($result['months']/12);
            $result['months'] = $result['months']-($result['years']*12);
        }

        return $result;
    }

    /**
     * Datetime Calculate
     * @param  start_date_time, end_date_time
     * @return array
     */
    static function datetimeCalculate($start_date_time, $end_date_time=null)
    {
        $from = new datetime($start_date_time);
        $to = ( ($end_date_time) ? new datetime($end_date_time) : new datetime() );
        $result = array('year'   => 0,
                        'month'  => 0,
                        'week'   => 0,
                        'day'    => 0,
                        'hour'   => 0,
                        'minute' => 0,
                        'second' => 0,
        );
        foreach($result as $set => &$inx) {
            while($from <= $to){ 
                $from->modify('+1 ' . $set);
                if ($from > $to) {
                    $from->modify('-1 ' . $set);
                    break;
                } else {
                    $inx++;
                }
            }
        }

        return $result;
    }

    /**
     * Datetime Thai Format
     * @param  datetime[datetime]
     * @return string
     */
    static function datetimeThaiFormat($datetime, $format="d/m/Y H:i:s", $is_short_year=false)
    {
        if( $datetime instanceof DateTime ){
            // This is datetime
        }else{
            $datetime = new datetime($datetime);
        }
        
        $result = $datetime->format($format);
        $search_year = intval($datetime->format("Y"));
        $replace_year = intval($datetime->format("Y"))+543;
        if( $is_short_year ){
           $replace_year = substr($replace_year, 2, 2); 
        }
        $result = str_replace($search_year, $replace_year, $result);

        return $result;
    }

    /**
     * Datetime Ago
     * @param  date, showdate
     * @return integer
     */
    static function datetimeAgo($date, $showdate=true)
    {
        $display = "";
        $recent = Helper::datetimeCalculate($date);
        $dayshow = false;
        if( $recent['year']>0 ){
            $display .= $recent['year']."Y ";
            if($showdate){
                $dayshow = $showdate;
            }
        }
        if( $recent['month']>0 ){
            $display .= $recent['month']."M ";
            if($showdate){
                $dayshow = $showdate;
            }
        }
        if( $recent['week']>0 ){
            $display .= $recent['week']."W ";
            if($showdate){
                $dayshow = $showdate;
            }
        }
        if( $recent['day']>0 ){
            $display .= $recent['day']."D ";
            if($showdate){
                $dayshow = $showdate;
            }
        }
        if( $recent['hour']>0 ){
            $display .= $recent['hour']."h ";
        }
        if( $recent['minute']>0 ){
            $display .= $recent['minute']."m ";
        }
        $display = ( ($display!="") ? trim($display)." ago" : null );
        if($display&&$dayshow){
            $display = Helper::dateShort($date)."&bull;".$display;
        }

        return $display;
    }

    /**
     * Print Date
     * @param  date
     * @return string
     */
    static function printDate($date)
    {
        return Helper::dateThai($date, false);
    }

    /**
     * Print Month Year
     * @param  date
     * @return string
     */
    static function printMonthYear($date)
    {
        return Helper::dateThai($date, false, false);
    }

    /**
     * Get Organize Group
     * @param  group_id, parent
     * @return string
     */
    static function getOrganizeGroup($group_id, $parent=true)
    {
        $sql = "SELECT tbl_organize_group.group_id
                , GROUP_CONCAT(tbl_organize.org_child SEPARATOR ',') AS orgs
                FROM tbl_organize_group
                INNER JOIN tbl_organize ON tbl_organize_group.org_id=tbl_organize.org_id
                WHERE tbl_organize_group.group_id=:group_id
                GROUP BY 1;";
        $check = DB::one($sql, array('dbname'=>"edumis_employee"), array('group_id'=>$group_id));
        return ( (isset($check['orgs'])&&$check['orgs']) ? ( ($parent==1&&$group_id==1) ? $group_id.',' : null ).$check['orgs'] : null );
    }

    /**
     * Random Number
     * @param  length 
     * @return string
     */
    static function randomNumber($length=6)
    {
        $characters = '0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters)-1)];
        }
        return $password;
    }

    /**
     * Random String
     * @param  length 
     * @return string
     */
    static function randomString($length=6)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters)-1)];
        }
        return $password;
    }

    /**
     * Random Password
     * @param  length 
     * @return string
     */
    static function randomPassword($length=6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters)-1)];
        }
        return $password;
    }

    /**
     * Make Directory
     * @param  string 
     * @return true/false[Boolean]
     */
    static function mkdir($dir) { 
        if (file_exists($dir)) return true;
        if( mkdir($dir) ){
            chmod($dir, 0777);
            $htaccess = fopen($dir."/.htaccess", "w") or die("Unable to create file!");
            fwrite($htaccess, "<IfModule mod_rewrite.c>\nOptions -Indexes\n</IfModule>");
            fclose($htaccess);
            return true; 
        }
        return false;
    } 

    /**
     * Remove Directory
     * @param  string 
     * @return true/false[Boolean]
     */
    static function rmdir($dir) { 
        if (!file_exists($dir)) return true; 
        if (!is_dir($dir) || is_link($dir)) return unlink($dir); 
        foreach (scandir($dir) as $item) { 
            if ($item == '.' || $item == '..') continue; 
            if (!Helper::rmdir($dir . "/" . $item)) { 
                chmod($dir . "/" . $item, 0777); 
                if (!Helper::rmdir($dir . "/" . $item)) return false; 
            }; 
        } 
        return rmdir($dir); 
    }

    /**
     * Remove File
     * @param  string 
     * @return true/false[Boolean]
     */
    static function rmfile($file) { 
        if (!file_exists($file)) return true; 
        return unlink($file); 
    }

    /**
     * bit Format
     * @param  bit, point, base
     * @return htmls
     */
    static function bitFormat($bit, $point=0, $cal_base=1000){
        $units = array( 'bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $bit > 0 ? floor(log($bit, $cal_base)) : 0;
        return (number_format($bit / pow($cal_base, $power), $point, '.', ','). $units[$power]);
    }

    /**
     * Redirect
     * @param  url
     * @return void
     */
    static function redirect($url=null)
    {
        if( $url==null ){
            $url = APP_HOME;
        }
        header("location:".$url);
        exit();
    }

    /**
     * Call API
     * @param  url
     * @return result
     */
    static function callApi($url){
        //Init
        $chanel_reg = curl_init();
        curl_setopt($chanel_reg, CURLOPT_URL, $url);
        curl_setopt($chanel_reg, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($chanel_reg);
        curl_close($chanel_reg);

        return json_decode($result, true);
    }

    /**
     * Get Http Response
     * @param  code
     * @return String
     */
    static function getHttpResponse($code){
        $text = null;
        switch ($code) {
            case 100: $text = 'Continue'; break;
            case 101: $text = 'Switching Protocols'; break;
            case 200: $text = 'OK'; break;
            case 201: $text = 'Created'; break;
            case 202: $text = 'Accepted'; break;
            case 203: $text = 'Non-Authoritative Information'; break;
            case 204: $text = 'No Content'; break;
            case 205: $text = 'Reset Content'; break;
            case 206: $text = 'Partial Content'; break;
            case 300: $text = 'Multiple Choices'; break;
            case 301: $text = 'Moved Permanently'; break;
            case 302: $text = 'Moved Temporarily'; break;
            case 303: $text = 'See Other'; break;
            case 304: $text = 'Not Modified'; break;
            case 305: $text = 'Use Proxy'; break;
            case 400: $text = 'Bad Request'; break;
            case 401: $text = 'Unauthorized'; break;
            case 402: $text = 'Payment Required'; break;
            case 403: $text = 'Forbidden'; break;
            case 404: $text = 'Not Found'; break;
            case 405: $text = 'Method Not Allowed'; break;
            case 406: $text = 'Not Acceptable'; break;
            case 407: $text = 'Proxy Authentication Required'; break;
            case 408: $text = 'Request Time-out'; break;
            case 409: $text = 'Conflict'; break;
            case 410: $text = 'Gone'; break;
            case 411: $text = 'Length Required'; break;
            case 412: $text = 'Precondition Failed'; break;
            case 413: $text = 'Request Entity Too Large'; break;
            case 414: $text = 'Request-URI Too Large'; break;
            case 415: $text = 'Unsupported Media Type'; break;
            case 500: $text = 'Internal Server Error'; break;
            case 501: $text = 'Not Implemented'; break;
            case 502: $text = 'Bad Gateway'; break;
            case 503: $text = 'Service Unavailable'; break;
            case 504: $text = 'Gateway Time-out'; break;
            case 505: $text = 'HTTP Version not supported'; break;
            default:
                exit('Unknown http status code "' . htmlentities($code) . '"');
            break;
        }

        return $text;
    }

    /**
     * Debug
     * @param  datas, exit 
     * @return true/false[Boolean]
     */
    static function debug($datas, $is_exit=false){
        echo '<pre style="border:none!important;">';
        print_r($datas);
        echo '</pre>';
        if($is_exit) exit();
    }

}
?>