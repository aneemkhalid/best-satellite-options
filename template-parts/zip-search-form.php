<?php

$icon = get_template_directory_uri() . '/images/icons/search.svg';

?>

<form action="/zip-search" class="zip_search_form">
    <img class="zip_search_icon" width="18" height="18" src="<?php echo $icon; ?>" alt="magnifying glass">
    <input type="number" class="zip_search_input border-radius-10 pt-3 pb-3 pl-5" name="zip" minlength="5" maxlength="5" placeholder="Enter Zip Code" pattern="\d*"/>
    <button type="submit" class="submit-zip btn-primary border-radius-10 pl-4 pr-4">Search</button>
</form> 