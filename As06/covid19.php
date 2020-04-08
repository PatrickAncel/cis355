<?php

$api_url = 'https://api.covid19api.com/summary';

// Gets COVID-19 data from API.
$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);

// Parses the JSON.
$data_obj = json_decode($data);

$country_array = array();

// Adds each country to the array.
foreach ($data_obj->Countries as $i => $value) {
    // The country name is the key, and the total number of confirmed cases is the value.
    $country_array[$value->Country] = $value->TotalConfirmed;
}

// Sorts the array in reverse order.
arsort($country_array);

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../As03/bootstrap.min.css">
    </head>
    <body>
        <table class='table'>
            <thead>
                <tr>
                    <th>Country</th>
                    <th>Total Confirmed Cases of COVID-19</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $country_names = array_keys($country_array);

                for ($i = 0; $i < 10; $i++) {
                    $country = $country_names[$i];
                    echo '<tr><td>' . $country . '</td><td>' . $country_array[$country] . '</td></tr>';
                }

                ?>
            </tbody>
        </table>
    </body>
</html>