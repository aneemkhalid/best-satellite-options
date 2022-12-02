<?php

$detail_Table[$ind]['id'] = $provider;
$internet_check = get_field('internet_check', $provider );
$internet = get_field('internet', $provider );
$splitOut = $internet['split_out_connection'];
if ( $splitOut != "" ){
    $detail_Table[$ind]['split_out'] = $splitOut;
}else{
    $detail_Table[$ind]['split_out'] = 0;
}
for ( $b = 0; $b <= (count($tblColumnsVal)-1); $b++ ){

    if ( strtolower($tblColumnsVal[$b]) == "connection_types" ){
        if ( $filterResult == 0 ){
            if ($internet[$tblColumnsVal[$b]] != ''){

                $conTypes = '';
                foreach ( $internet[$tblColumnsVal[$b]] as $conType => $key ){
                    if ( $conTypes == "" ){
                        $conTypes .= ucfirst($key);
                    }else{
                        $conTypes .= ", " . ucfirst($key);
                    }
                }
                $detail_Table[$ind][$tblColumnsVal[$b]][] = $conTypes;
            } else {
                $detail_Table[$ind][$tblColumnsVal[$b]][] = 'N/A';
            }
        }

    }else {
        $providerDetailsArr = array( "contracts", "acsi_rating", "fixed_price_guarentee", "credit_check_required", "contract_buyouts", "early_termination_fee");
        $internet2 = get_field_object('internet', $provider );
        if ($splitOut == 0){
            if( in_array( strtolower($tblColumnsVal[$b]), $providerDetailsArr) ){
                $data = get_field($tblColumnsVal[$b], $provider);
                if ($data != ''){
                    $detail_Table[$ind][$tblColumnsVal[$b]][] = $data;   
                } else {
                    $detail_Table[$ind][$tblColumnsVal[$b]][] = 'N/A';
                }                     
            } elseif( in_array( strtolower($tblColumnsVal[$b]), array("free_wifi_hotspots")) ){
                if($internet[$tblColumnsVal[$b]] == 1){
                $detail_Table[$ind][$tblColumnsVal[$b]][] = "Yes";
                } else{
                    $detail_Table[$ind][$tblColumnsVal[$b]][] = "No";
                }
            } else{
                if( strtolower($tblColumnsVal[$b]) == "starting_price" ){            

                    
                    $minValCol = "min_" . $tblColumnsVal[$b];
                    $maxValCol = "max_" . $tblColumnsVal[$b];
                    $minVal = $internet['details'][$minValCol];
                    $maxVal = $internet['details'][$maxValCol];
                    
                    if ( $internet['details']['show_asterisk'] == 1 ){
                        $showAsterisk0 = '*';
                    }else{
                        $showAsterisk0 = '';
                    }
                    if ($minVal == $maxVal && $minVal == ''){
                        $detail_Table[$ind][$tblColumnsVal[$b]][] = 'N/A';
                    } else {
                        if ($minVal == $maxVal ){
                            $detail_Table[$ind][$tblColumnsVal[$b]][] = $maxVal . $showAsterisk0 ;  
                        } else if ($minVal == ""){
                            $detail_Table[$ind][$tblColumnsVal[$b]][] = $maxVal . $showAsterisk0;
                        } else if ($maxVal == ""){
                            $detail_Table[$ind][$tblColumnsVal[$b]][] = $minVal . $showAsterisk0;
                        } else {
                            $detail_Table[$ind][$tblColumnsVal[$b]][] = $minVal . " – " . $maxVal . $showAsterisk0;
                        }
                    }    
                    
                }else if( strtolower($tblColumnsVal[$b]) == "install_fee" ){
                    $detail_Table[$ind]['install_fee']['before_min_install_fee'] = $internet['install_fee']['before_min_install_fee'];
                    $detail_Table[$ind]['install_fee']['after_min_install_fee'] = $internet['install_fee']['after_min_install_fee'];

                    $detail_Table[$ind]['install_fee']['before_max_install_fee'] = $internet['install_fee']['before_max_install_fee'];
                    $detail_Table[$ind]['install_fee']['after_max_install_fee'] = $internet['install_fee']['after_max_install_fee'];
                    
                    //self_install
                    $minVal = $internet['install_fee']['self_install']['min_fee'];
                    $maxVal = $internet['install_fee']['self_install']['max_fee'];
                    if ($minVal == $maxVal && $minVal == ''){
                        $detail_Table[$ind]['install_fee']['self_install'] = '';
                    } else {
                        $detail_Table[$ind]['install_fee']['self_install'] = $minVal . " – " . $maxVal;
                    }
                    
                    //pro_install
                    $minVal = $internet['install_fee']['pro_install']['min_fee'];
                    $maxVal = $internet['install_fee']['pro_install']['max_fee'];
                    if ($minVal == $maxVal && $minVal == ''){
                        $detail_Table[$ind]['install_fee']['pro_install'] = '';
                    } else {
                        $detail_Table[$ind]['install_fee']['pro_install'] = $minVal . " – " . $maxVal;
                    }
                    if ($detail_Table[$ind]['install_fee']['self_install'] != '' || $detail_Table[$ind]['install_fee']['pro_install'] != ''){                          
                        $installFeeRaw = $detail_Table[$ind]['install_fee']['self_install'] . " – " . $detail_Table[$ind]['install_fee']['pro_install'];
                        $installFee = explode( " – ", $installFeeRaw );

                        $beforeMinFee = $detail_Table[$ind]['install_fee']['before_min_install_fee'];
                        $minFee = min( array_filter($installFee) );
                        $afterMinFee = $detail_Table[$ind]['install_fee']['after_min_install_fee'];

                        $beforeMaxFee = $detail_Table[$ind]['install_fee']['before_max_install_fee'];
                        $maxFee = max( array_filter($installFee) );
                        $afterMaxFee = $detail_Table[$ind]['install_fee']['after_max_install_fee'];

                        if($minFee == $maxFee) {
                            $detail_Table[$ind]['install_fee'][$ind] = $beforeMinFee . $minFee . $afterMinFee;
                        } else if ($minFee == "") {
                            $detail_Table[$ind]['install_fee'][$ind] = $beforeMaxFee . $maxFee . $afterMaxFee;
                        } else if ($maxFee == "") {
                            $detail_Table[$ind]['install_fee'][$ind] = $beforeMinFee . $minFee . $afterMinFee;
                        } else {
                            $detail_Table[$ind]['install_fee'][$ind] = $beforeMinFee . $minFee . $afterMinFee . " – " . $beforeMaxFee . $maxFee . $afterMaxFee;
                        }
                    } 
                
                }else if( strtolower($tblColumnsVal[$b]) == "internet_equipment_rental_fee" ){
                    //internet_equipment_rental_fee
                    $minVal = $internet['internet_equipment_rental_fee']['internet_equipment_rental_fee_min'];
                    $maxVal = $internet['internet_equipment_rental_fee']['internet_equipment_rental_fee_max'];
                    if ($minVal == $maxVal && $minVal == ''){
                        $detail_Table[$ind]['internet_equipment_rental_fee'][] = 'N/A';
                    } else {
                        if ($minVal == $maxVal ){
                            $detail_Table[$ind]['internet_equipment_rental_fee'][] = $maxVal;  
                        } else if ($minVal == ""){
                            $detail_Table[$ind]['internet_equipment_rental_fee'][] = $maxVal;
                        } else if ($maxVal == ""){
                            $detail_Table[$ind]['internet_equipment_rental_fee'][] = $minVal;
                        } else {
                            $detail_Table[$ind]['internet_equipment_rental_fee'][] = $minVal . " – " . $maxVal;
                        }
                    }    
                } else if( strtolower($tblColumnsVal[$b]) == "free_wifi_hotspots" ){
                        if ($internet["free_wifi_hotspots"]){
                            $detail_Table[$ind][$tblColumnsVal[$b]][] = 'Yes';
                        } else {
                            $detail_Table[$ind][$tblColumnsVal[$b]][] = 'No';
                        }
                }else{
                    $pattern = "/(max)/i";
                    if ( preg_match($pattern, $tblColumnsVal[$b] ) ){
                        $maxPreA = '';
                        $minValCol = str_replace("max", "min", $tblColumnsVal[$b] );
                        $maxValCol = $tblColumnsVal[$b];
                        $maxPreA = getPre($maxValCol, $internet2, false);
                        
                        $minVal = $internet['details'][$minValCol];                                                
                        $maxVal = $internet['details'][$tblColumnsVal[$b]];
                        if ($minVal == $maxVal && $minVal == ''){
                            $detail_Table[$ind][$tblColumnsVal[$b]][] = 'N/A';
                        } else {
                            if( $minVal == $maxVal ) {
                                $detail_Table[$ind][$tblColumnsVal[$b]][] = $minVal . " " . $maxPreA;
                            } else if($minVal == "") {
                                $detail_Table[$ind][$tblColumnsVal[$b]][] = $maxVal . " " . $maxPreA;
                            
                            } else if($maxVal == "") {
                                $detail_Table[$ind][$tblColumnsVal[$b]][] = $minVal . " " . $maxPreA;
                            }else {
                                $detail_Table[$ind][$tblColumnsVal[$b]][] = $minVal . " – " . $maxVal . " " . $maxPreA;
                            }
                        }    
                    }else{
                        if ( strtolower($internet['details'][$tblColumnsVal[$b]]) == "yes" ){
                            $detail_Table[$ind][$tblColumnsVal[$b]][] = "Yes";
                        }else{
                            $detail_Table[$ind][$tblColumnsVal[$b]][] = "No";
                        }
                    }                               
                }
            }
        }else{

            if( in_array( strtolower($tblColumnsVal[$b]), $providerDetailsArr) ){
                $data = get_field($tblColumnsVal[$b], $provider);
                if ($data != ''){
                    $detail_Table[$ind][$tblColumnsVal[$b]][] = $data; 
                } else {
                    $detail_Table[$ind][$tblColumnsVal[$b]][] = 'N/A'; 
                }    
            }elseif( in_array( strtolower($tblColumnsVal[$b]), array("free_wifi_hotspots")) ){ 
                if($internet[$tblColumnsVal[$b]] == 1){
                $detail_Table[$ind][$tblColumnsVal[$b]][] = "Yes";
                } else{
                    $detail_Table[$ind][$tblColumnsVal[$b]][] = "No";
                }
            }else if( strtolower($tblColumnsVal[$b]) == "install_fee" ){
                $detail_Table[$ind]['install_fee']['before_min_install_fee'] = $internet['install_fee']['before_min_install_fee'];
                $detail_Table[$ind]['install_fee']['after_min_install_fee'] = $internet['install_fee']['after_min_install_fee'];

                $detail_Table[$ind]['install_fee']['before_max_install_fee'] = $internet['install_fee']['before_max_install_fee'];
                $detail_Table[$ind]['install_fee']['after_max_install_fee'] = $internet['install_fee']['after_max_install_fee'];
                //self_install                                
                $minVal = $internet['install_fee']['self_install']['min_fee'];
                $maxVal = $internet['install_fee']['self_install']['max_fee'];
                if ($minVal == $maxVal && $minVal == ''){
                    $detail_Table[$ind]['install_fee']['self_install'] = '';
                } else {
                    $detail_Table[$ind]['install_fee']['self_install'] = $minVal . " – " . $maxVal;
                }
                //pro_install
                $minVal = $internet['install_fee']['pro_install']['min_fee'];
                $maxVal = $internet['install_fee']['pro_install']['max_fee'];
                if ($minVal == $maxVal && $minVal == ''){
                    $detail_Table[$ind]['install_fee']['pro_install'] = '';
                } else {
                    $detail_Table[$ind]['install_fee']['pro_install'] = $minVal . " – " . $maxVal;
                }
                if ($detail_Table[$ind]['install_fee']['self_install'] != '' || $detail_Table[$ind]['install_fee']['pro_install'] != ''){                          
                    $installFeeRaw = $detail_Table[$ind]['install_fee']['self_install'] . " – " . $detail_Table[$ind]['install_fee']['pro_install'];
                    $installFee = explode( " – ", $installFeeRaw );

                    $beforeMinFee = $detail_Table[$ind]['install_fee']['before_min_install_fee'];
                    $minFee = min( array_filter($installFee) );
                    $afterMinFee = $detail_Table[$ind]['install_fee']['after_min_install_fee'];

                    $beforeMaxFee = $detail_Table[$ind]['install_fee']['before_max_install_fee'];
                    $maxFee = max( array_filter($installFee) );
                    $afterMaxFee = $detail_Table[$ind]['install_fee']['after_max_install_fee'];

                    if($minFee == $maxFee) {
                        $detail_Table[$ind]['install_fee'][$ind] = $beforeMinFee . $minFee . $afterMinFee;
                    } else if ($minFee == "") {
                        $detail_Table[$ind]['install_fee'][$ind] = $beforeMaxFee . $maxFee . $afterMaxFee;
                    } else if ($maxFee == "") {
                        $detail_Table[$ind]['install_fee'][$ind] = $beforeMinFee . $minFee . $afterMinFee;
                    } else {
                        $detail_Table[$ind]['install_fee'][$ind] = $beforeMinFee . $minFee . $afterMinFee . " – " . $beforeMaxFee . $maxFee . $afterMaxFee;
                    }
                } 
                
            }else if( strtolower($tblColumnsVal[$b]) == "internet_equipment_rental_fee" ){
                //internet_equipment_rental_fee
                $minVal = $internet['internet_equipment_rental_fee']['internet_equipment_rental_fee_min'];
                $maxVal = $internet['internet_equipment_rental_fee']['internet_equipment_rental_fee_max'];
                if ($minVal == $maxVal && $minVal == ''){
                    $detail_Table[$ind]['internet_equipment_rental_fee'][] = 'N/A';
                } else {
                    if ($minVal == $maxVal ){
                        $detail_Table[$ind]['internet_equipment_rental_fee'][] = $maxVal;  
                    } else if ($minVal == ""){
                        $detail_Table[$ind]['internet_equipment_rental_fee'][] = $maxVal;
                    } else if ($maxVal == ""){
                        $detail_Table[$ind]['internet_equipment_rental_fee'][] = $minVal;
                    } else {
                        $detail_Table[$ind]['internet_equipment_rental_fee'][] = $minVal . ' – ' . $maxVal;
                    }
                }    
            }else if( strtolower($tblColumnsVal[$b]) == "free_wifi_hotspots" ){
                if ($internet["free_wifi_hotspots"]){
                        $detail_Table[$ind][$tblColumnsVal[$b]][] = 'Yes';
                    } else {
                        $detail_Table[$ind][$tblColumnsVal[$b]][] = 'No';
                    }
            }
            else{                            
                $conectionTypes = $internet['connection_types'];
                $ind2 = 0;

                foreach ( $conectionTypes as $conectionType ){
                    $conType = $internet[$conectionType . '_connection'];

                    switch (strtolower( $tblColumnsVal[$b] )) {
                        case "starting_price":
                            $astk = $conType[$conectionType . '_show_asterisk'];                                        
                            if ( $astk == 1 ){
                                if ( $doFiltering == 1 ){
                                    if ( strtolower($providerFilter) == $conectionType ){
                                        $detail_Table[$ind][$tblColumnsVal[$b]][] = $conType[$conectionType . '_before_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_after_' . $tblColumnsVal[$b]] . "*";
                                    }
                                }else{
                                    if ( $filterResult == 0 ){
                                        $detail_Table[$ind][$tblColumnsVal[$b]][] = $conType[$conectionType . '_before_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_after_' . $tblColumnsVal[$b]] . "*";
                                    }
                                }
                            }else{
                                if ( $doFiltering == 1 ){
                                    if ( strtolower($providerFilter) == $conectionType ){
                                        $detail_Table[$ind][$tblColumnsVal[$b]][] = $conType[$conectionType . '_before_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_after_' . $tblColumnsVal[$b]] . "";
                                    }
                                }else{
                                    if ( $filterResult == 0 ){
                                        $detail_Table[$ind][$tblColumnsVal[$b]][] = $conType[$conectionType . '_before_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_after_' . $tblColumnsVal[$b]] . "";
                                    }
                                }
                            }
                        break;

                        case "max_upload_speed":
                        case "max_download_speed":
                            if ( $doFiltering == 1 ){
                                if ( strtolower($providerFilter) == $conectionType ){
                                    $detail_Table[$ind][$tblColumnsVal[$b]][] = $conType[$conectionType . '_before_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_after_' . $tblColumnsVal[$b]];
                                }
                            }else{
                                if ( $filterResult == 0 ){
                                    $detail_Table[$ind][$tblColumnsVal[$b]][] = $conType[$conectionType . '_before_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_' . $tblColumnsVal[$b]] . "^" . $conType[$conectionType . '_after_' . $tblColumnsVal[$b]];
                                }
                            }
                        break;

                        case "symmetrical_speeds":
                        case "data_caps":
                            if ( $doFiltering == 1 ){
                                if ( strtolower($providerFilter) == strtolower($conectionType) ){                                    
                                    $detail_Table[$ind][$tblColumnsVal[$b]][] = $conType[$conectionType . '_' . $tblColumnsVal[$b]];
                                }
                            }else{
                                if ( $filterResult == 0 ){
                                    $detail_Table[$ind][$tblColumnsVal[$b]][] = $conType[$conectionType . '_' . $tblColumnsVal[$b]];
                                }
                            }
                        break;
                    }
                }                            
            }
        }
    }
}
$ind++;
?>