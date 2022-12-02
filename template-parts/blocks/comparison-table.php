<?php

/**
 * Comparison Table
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$providers = get_field('providers');
$logo_header = get_field('header_text_for_logos_row');
$button_text = get_field('button_text_for_ctas');
if (!$logo_header){ 
    $logo_header = 'Our Picks';
}
if (!$button_text){ 
    $button_text = 'View Plans';
}
$tableColumns = get_field(('table_columns'));
$ctaButton = true;

$filterResult = 0;

// Default Columns
$tblColumns = $tblColumnsVal = [];

// User Added Columns
foreach( $tableColumns as $column ) {
    $tblColumns[] = $column['column_name'];
    $tblColumnsVal[] = $column['data_type'];
}

// Add Last Column
$tblColumns[] = '';

$ind = $doFiltering = 0;

$td_width_desktop = 80/count($providers);

foreach( $providers as $provider ){

    include( "compare-provider-tbl-internet-data-array.php");
}?>

<section id="comparetable" class="compare-providers-wrap container">
    <div class="compare-providers-table minimal-table comparison-template">

<?php

//add logos to beginning of arrays
array_unshift($tblColumnsVal , 'our_picks');
array_unshift($tblColumns , $logo_header);

//add CTA buttons to end of arrays
$tblColumnsVal[] = '';

if ( is_array($detail_Table) ){ ?>
<table class="compare-providers-table-inner desktop-table">
    <tbody>
        <?php
            for ( $d=0; $d<( count($tblColumnsVal) ); $d++){

                if ($d === count($tblColumnsVal)-1):
                    echo '<tr style="background-color:#fff;">';
                else:    
                    echo '<tr>';
                endif;
   
                echo '<th class="border-bottom-0 pt-3 pb-3" style="width:20%;"><p class="font-weight-bold mb-0">'.$tblColumns[$d].'</p></th>';
                foreach($detail_Table as $detail){

                    $splitOut = $detail['split_out'];
                    $logo = get_field( 'logo', $detail['id'] );
                    $provider_url = get_post_permalink( $detail['id'] );
                    echo '<td class="text-center" style="width:'.$td_width_desktop.'%;">';
                    //if it's the first row
                    if ($d === 0):
                        echo '<img src="'.$logo.'" alt="logo" class="provider-logo m-2" width="180" height="40">';
                    //if it's the last row
                    elseif($d === count($tblColumnsVal)-1):
                        echo '<a href="'.$provider_url.'" class="btn-primary btn">'.$button_text.'</a>';
                    else: 

                        $arInd = $tblColumnsVal[$d];      
                        $detailFilter = '';                     
                        $rangEcols = array( "max_download_speed", "max_upload_speed", "starting_price" );
                        $yesNoCols = array( "symmetrical_speeds", "data_caps" );
                        if (isset($detail[$arInd])){
                            $detailFilter = $detail[$arInd];
                        }

                        if ( $arInd != "split_out" ){
                           if ( $splitOut == 0 ){
                                if (isset($detailFilter[0])){
                                    if ($detailFilter[0]){
                                        echo $detailFilter[0];
                                    } else {
                                        echo 'N/A';
                                    }
                                } else {
                                    echo 'N/A';
                                }
                            }else{
                                if ( $arInd != "" ){
                                    $minVal = min( array_filter($detailFilter) );
                                    $maxVal = max( array_filter($detailFilter) );
                                    if ( in_array( $arInd, $rangEcols ) ){
                                        $cellData = '';
                                        if ( ($arInd == "max_download_speed") ){
                                            foreach($detailFilter as $key => $indSpeed){
                                                $speedArrayMb[$key] = explode("^", $indSpeed);
                                            }
                                            
                                            $minSpeed = min(array_filter(array_column($speedArrayMb, 1)));
                                            $keyMin = array_search($minSpeed, array_column($speedArrayMb, 1));

                                            $maxSpeed = max(array_filter(array_column($speedArrayMb, 1)));
                                            $keyMax = array_search($maxSpeed, array_column($speedArrayMb, 1));
                                            if ( $minSpeed == $maxSpeed ){ // BOTH ARE EQUAL
                                                $cellData .= $speedArrayMb[$keyMax][0] . $maxSpeed . ' ' . $speedArrayMb[$keyMax][2];
                                            }else{ // BOTH ARE DIFFERNT
                                                $cellData .= $speedArrayMb[$keyMin][0] . $minSpeed . ' ' . $speedArrayMb[$keyMin][2] . " – " . $speedArrayMb[$keyMax][0] . $maxSpeed . ' ' . $speedArrayMb[$keyMax][2];
                                            }
                                        
                                        }else if($arInd == "max_upload_speed"){

                                            foreach($detailFilter as $key => $indSpeed1){
                                                $speedArrayMb1[$key] = explode("^", $indSpeed1);
                                            }
                                            
                                            $minSpeed = min(array_filter(array_column($speedArrayMb1, 1)));
                                            $keyMin = array_search($minSpeed, array_column($speedArrayMb1, 1));

                                            $maxSpeed = max(array_filter(array_column($speedArrayMb1, 1)));
                                            $keyMax = array_search($maxSpeed, array_column($speedArrayMb1, 1));
                                            if ( $minSpeed == $maxSpeed ){ // BOTH ARE EQUAL
                                                $cellData .= $speedArrayMb1[$keyMax][0] . $maxSpeed . $speedArrayMb1[$keyMax][2];
                                            }else{ // BOTH ARE DIFFERNT
                                                $cellData .= $speedArrayMb1[$keyMin][0] . $minSpeed . $speedArrayMb1[$keyMin][2] . " – " . $speedArrayMb1[$keyMax][0] . $maxSpeed . $speedArrayMb1[$keyMax][2];
                                            }
                                        }else{

                                            $stPrice1 = $minVal = $maxVal = $showAsterisk = '';
                                            foreach ($detailFilter as $singledetailFilter ){
                                                if ( $stPrice1 == "" ){
                                                    $stPrice1 = $singledetailFilter;
                                                }else{
                                                    $stPrice1 .= " – " . $singledetailFilter;
                                                }
                                            }                                                
                                            $pattern = "/(\*)/i";
                                            if  ( preg_match($pattern, $stPrice1) ){
                                                $showAsterisk = '*';
                                            }else{
                                                $showAsterisk = '';
                                            }                                                
                                            $stPrice1 = preg_replace($pattern, "", $stPrice1);
                                            $stPrice1Arr = explode(" – ",$stPrice1);
                                            foreach($stPrice1Arr as $key => $indStPrice){
                                                $stPriceVal[$key] = explode("^", $indStPrice);
                                            }
                                            $minVal = min(array_filter(array_column($stPriceVal, 1)));
                                            $key_min = array_search($minVal, array_column($stPriceVal, 1));

                                            $maxVal = max(array_filter(array_column($stPriceVal, 1)));
                                            $key_max = array_search($maxVal, array_column($stPriceVal, 1));

                                            if ( $minVal == $maxVal ){ // BOTH ARE EQUAL
                                                $cellData .= $stPriceVal[$key_max][0] . $maxVal . $stPriceVal[$key_max][2] . $showAsterisk;
                                            }else{ // BOTH ARE DIFFERNT
                                                $cellData .= $stPriceVal[$key_min][0] . $minVal . $stPriceVal[$key_min][2] . " – " . $stPriceVal[$key_max][0] . $maxVal . $stPriceVal[$key_max][2] . $showAsterisk;
                                            }
                                        }
                                        echo $cellData;
                                    }else if ( in_array( $arInd, $yesNoCols ) ){
                                        
                                        $cellData = ''; $yesAns = 0; $noAns = 0;
                                        foreach ( $detailFilter as $Ans ){
                                            if ( strtolower($Ans) == "yes" ){
                                                $yesAns++;
                                            }else{
                                                $noAns++;
                                            }
                                            if ( $yesAns >= 1 ){
                                                $cellData = 'Yes';
                                            }else{
                                                $cellData = 'No';
                                            }
                                        }
                                        echo $cellData;

                                    }else{
                                        $cellData = '';
                                        $cellData = $detailFilter[0];
                                        if ($cellData){
                                            echo $cellData;
                                        } else {
                                            echo 'N/A';
                                        }
                                    }
                                }
                            }
                        }
                        echo '</td>';
                    endif;
                }
                echo '</tr>';                   
            }
        ?>
    </tbody>
</table>

<table class="compare-providers-table-inner mobile-table" style="table-layout: fixed;">
    <tbody>
        <?php
            $tbl_count = 1;
            foreach($detail_Table as $detail){

                $providers_spacing = '';

                if ($tbl_count !== count($detail_Table)){
                    $providers_spacing = 'pb-5';
                }
                $tbl_count++;
                for ( $d=0; $d<( count($tblColumnsVal) ); $d++){

                    if ($d === count($tblColumnsVal)-1):
                        echo '<tr style="background-color:#fff;">';
                    else:    
                        echo '<tr>';
                        echo '<th class="border-bottom-0 pt-3 pb-3 font-weight-bold" style="width:50%;"><p class="font-weight-bold mb-0">'.$tblColumns[$d].'</p></th>';
                    endif;
    
                        $splitOut = $detail['split_out'];
                        $logo = get_field( 'logo', $detail['id'] );
                        $provider_url = get_post_permalink( $detail['id'] );
                        //if it's the first row
                        if ($d === 0):
                            echo '<td class="text-center">';
                            echo '<img src="'.$logo.'" alt="logo" class="provider-logo m-2" width="180" height="40">';
                        //if it's the last row
                        elseif($d === count($tblColumnsVal)-1):
                            echo '<td class="text-center '.$providers_spacing.'" colspan=100%>';
                            echo '<a href="'.$provider_url.'" class="btn-primary btn">'.$button_text.'</a>';
                            //echo '<a href="#" class="cta_btn zip-popup-btn font-weight-bold pt-2 pb-2" style="width:100%;" data-toggle="modal" data-target="#zipPopupModal-'.$rand.'">Check Availability</a>';
                        else: 
                            echo '<td class="text-center">';

                            $arInd = $tblColumnsVal[$d];      
                            $detailFilter = '';                     
                            $rangEcols = array( "max_download_speed", "max_upload_speed", "starting_price" );
                            $yesNoCols = array( "symmetrical_speeds", "data_caps" );
                            if (isset($detail[$arInd])){
                                $detailFilter = $detail[$arInd];
                            }

                            if ( $arInd != "split_out" ){
                                if ( $splitOut == 0 ){
                                    if (isset($detailFilter[0])){
                                        if ($detailFilter[0]){
                                            echo $detailFilter[0];
                                        } else {
                                            echo 'N/A';
                                        }
                                    }else {
                                        echo 'N/A';
                                    }

                                }else{
                                    if ( $arInd != "" ){
                                        $minVal = min( array_filter($detailFilter) );
                                        $maxVal = max( array_filter($detailFilter) );
                                        if ( in_array( $arInd, $rangEcols ) ){
                                            $cellData = '';
                                            if ( ($arInd == "max_download_speed") ){
                                                foreach($detailFilter as $key => $indSpeed){
                                                    $speedArrayMb[$key] = explode("^", $indSpeed);
                                                }
                                                
                                                $minSpeed = min(array_filter(array_column($speedArrayMb, 1)));
                                                $keyMin = array_search($minSpeed, array_column($speedArrayMb, 1));

                                                $maxSpeed = max(array_filter(array_column($speedArrayMb, 1)));
                                                $keyMax = array_search($maxSpeed, array_column($speedArrayMb, 1));
                                                if ( $minSpeed == $maxSpeed ){ // BOTH ARE EQUAL
                                                    $cellData .= $speedArrayMb[$keyMax][0] . $maxSpeed . ' ' . $speedArrayMb[$keyMax][2];
                                                }else{ // BOTH ARE DIFFERNT
                                                    $cellData .= $speedArrayMb[$keyMin][0] . $minSpeed . ' ' . $speedArrayMb[$keyMin][2] . " – " . $speedArrayMb[$keyMax][0] . $maxSpeed . ' ' . $speedArrayMb[$keyMax][2];
                                                }
                                            
                                            }else if($arInd == "max_upload_speed"){

                                                foreach($detailFilter as $key => $indSpeed1){
                                                    $speedArrayMb1[$key] = explode("^", $indSpeed1);
                                                }
                                                
                                                $minSpeed = min(array_filter(array_column($speedArrayMb1, 1)));
                                                $keyMin = array_search($minSpeed, array_column($speedArrayMb1, 1));

                                                $maxSpeed = max(array_filter(array_column($speedArrayMb1, 1)));
                                                $keyMax = array_search($maxSpeed, array_column($speedArrayMb1, 1));
                                                if ( $minSpeed == $maxSpeed ){ // BOTH ARE EQUAL
                                                    $cellData .= $speedArrayMb1[$keyMax][0] . $maxSpeed . $speedArrayMb1[$keyMax][2];
                                                }else{ // BOTH ARE DIFFERNT
                                                    $cellData .= $speedArrayMb1[$keyMin][0] . $minSpeed . $speedArrayMb1[$keyMin][2] . " – " . $speedArrayMb1[$keyMax][0] . $maxSpeed . $speedArrayMb1[$keyMax][2];
                                                }
                                            }else{

                                                $stPrice1 = $minVal = $maxVal = $showAsterisk = '';
                                                foreach ($detailFilter as $singledetailFilter ){
                                                    if ( $stPrice1 == "" ){
                                                        $stPrice1 = $singledetailFilter;
                                                    }else{
                                                        $stPrice1 .= " – " . $singledetailFilter;
                                                    }
                                                }                                                
                                                $pattern = "/(\*)/i";
                                                if  ( preg_match($pattern, $stPrice1) ){
                                                    $showAsterisk = '*';
                                                }else{
                                                    $showAsterisk = '';
                                                }                                                
                                                $stPrice1 = preg_replace($pattern, "", $stPrice1);
                                                $stPrice1Arr = explode(" – ",$stPrice1);
                                                foreach($stPrice1Arr as $key => $indStPrice){
                                                    $stPriceVal[$key] = explode("^", $indStPrice);
                                                }
                                                $minVal = min(array_filter(array_column($stPriceVal, 1)));
                                                $key_min = array_search($minVal, array_column($stPriceVal, 1));

                                                $maxVal = max(array_filter(array_column($stPriceVal, 1)));
                                                $key_max = array_search($maxVal, array_column($stPriceVal, 1));

                                                if ( $minVal == $maxVal ){ // BOTH ARE EQUAL
                                                    $cellData .= $stPriceVal[$key_max][0] . $maxVal . $stPriceVal[$key_max][2] . $showAsterisk;
                                                }else{ // BOTH ARE DIFFERNT
                                                    $cellData .= $stPriceVal[$key_min][0] . $minVal . $stPriceVal[$key_min][2] . " – " . $stPriceVal[$key_max][0] . $maxVal . $stPriceVal[$key_max][2] . $showAsterisk;
                                                }
                                            }
                                            echo $cellData;
                                        }else if ( in_array( $arInd, $yesNoCols ) ){
                                            
                                            $cellData = ''; $yesAns = 0; $noAns = 0;
                                            foreach ( $detailFilter as $Ans ){
                                                if ( strtolower($Ans) == "yes" ){
                                                    $yesAns++;
                                                }else{
                                                    $noAns++;
                                                }
                                                if ( $yesAns >= 1 ){
                                                    $cellData = 'Yes';
                                                }else{
                                                    $cellData = 'No';
                                                }
                                            }
                                            echo $cellData;

                                        }else{
                                            if ($cellData){
                                                echo $cellData;
                                            } else {
                                                echo 'N/A';
                                            }
                                        }
                                    }
                                }
                            }
                            echo '</td>';
   
                        endif;
                }
                echo '</tr>';
                                
            }
        ?>
    </tbody>
</table>
<?php
} 

?>
</div>
</section>