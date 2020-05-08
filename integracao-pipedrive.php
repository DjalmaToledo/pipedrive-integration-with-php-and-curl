<?php

//Token do Vendedor
$api_token = '';

// main data about the organization
$organization = array(
    'name' => '',
    'address' => '',
);

// main data about the People
$person = array(
    'name' => '',
    'email' => '',
    'phone' => '',
);

// main data about the deal. person_id and org_id is added later dynamically
$deal = array(
    'title' => '',
    'value' => '250',
    'token_custom_field' => 'value',
);

// try adding an organization and get back the ID
$org_id = create_organization($api_token, $organization);

// if the organization was added successfully add the person and link it to the organization
if ($org_id) {

    $person['org_id'] = $org_id;

    // try adding a person and get back the ID
    $person_id = create_person($api_token, $person);

    // if the person was added successfully add the deal and link it to the organization and the person
    if ($person_id) {

        $deal['org_id'] = $org_id;
        $deal['person_id'] = $person_id;

        // try adding a person and get back the ID
        $deal_id = create_deal($api_token, $deal);

    } else {
      // echo "There was a problem with adding the person!";
    }

} else {
  // echo "There was a problem with adding the organization!";
}

function create_organization($api_token, $organization)
{
    $url = "https://api.pipedrive.com/v1/organizations?api_token=" . $api_token;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $organization);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    // create an array from the data that is sent back from the API
    $result = json_decode($output, 1);

    // check if an id came back
    if (!empty($result['data']['id'])) {
        $org_id = $result['data']['id'];
        return $org_id;
    } else {
        return false;
    }
}

function create_person($api_token, $person){

  $url = "https://api.pipedrive.com/v1/persons?api_token=" . $api_token;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, true);

  curl_setopt($ch, CURLOPT_POSTFIELDS, $person);
  $output = curl_exec($ch);
  $info = curl_getinfo($ch);
  curl_close($ch);

  // create an array from the data that is sent back from the API
  $result = json_decode($output, 1);

    // check if an id came back
    if (!empty($result['data']['id'])) {
        $person_id = $result['data']['id'];
        return $person_id;
    } else {
        return false;
    }

}

function create_deal($api_token, $deal){

    $url = "https://api.pipedrive.com/v1/deals?api_token=" . $api_token;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $deal);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    // create an array from the data that is sent back from the API
    $result = json_decode($output, 1);

    // check if an id came back
    if (!empty($result['data']['id'])) {
        $deal_id = $result['data']['id'];
        return $deal_id;
    } else {
        return false;
    }

}