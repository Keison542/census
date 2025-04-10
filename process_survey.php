<?php
$conn = new mysqli('localhost', 'root', '', 'png_census');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Household
    $stmt = $conn->prepare("INSERT INTO household (village_name, head_of_household, cluster_number, dwelling_number, household_number, province, district, llg, area_type, census_unit, segment_number, house_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $_POST['village_name'], $_POST['head_of_household'], $_POST['cluster_number'], $_POST['dwelling_number'], $_POST['household_number'], $_POST['province'], $_POST['district'], $_POST['llg'], $_POST['area_type'], $_POST['census_unit'], $_POST['segment_number'], $_POST['house_type']);
    $stmt->execute();
    $household_id = $stmt->insert_id;

    // 2. Persons & Linked Tables
    foreach ($_POST['person_name'] as $index => $person_name) {
        if (!empty($person_name)) {
            $stmt2 = $conn->prepare("INSERT INTO persons (household_id, person_name, relationship_to_head, gender, age) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param("isssi", $household_id, $person_name, $_POST['relationship_to_head'][$index], $_POST['gender'][$index], $_POST['age'][$index]);
            $stmt2->execute();
            $person_id = $stmt2->insert_id;

            // Education table
            $stmt3 = $conn->prepare("INSERT INTO education (person_id, ever_attended_school, highest_grade_completed, currently_attending_school) VALUES (?, ?, ?, ?)");
            $stmt3->bind_param("isss", $person_id, $_POST['ever_attended_school'][$index], $_POST['highest_grade_completed'][$index], $_POST['currently_attending_school'][$index]);
            $stmt3->execute();

            // Economic table
            $stmt4 = $conn->prepare("INSERT INTO economic (person_id, employment_status, occupation, business_activity) VALUES (?, ?, ?, ?)");
            $stmt4->bind_param("isss", $person_id, $_POST['employment_status'][$index], $_POST['occupation'][$index], $_POST['business_activity'][$index]);
            $stmt4->execute();

            // Fertility table (if woman 15+)
            if ($_POST['gender'][$index] == 'Female' && $_POST['age'][$index] >= 15) {
                $stmt5 = $conn->prepare("INSERT INTO fertility (person_id, live_births, children_alive, children_elsewhere, children_dead, last_birth_date) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt5->bind_param("iiiiis", $person_id, $_POST['live_births'][$index], $_POST['children_alive'][$index], $_POST['children_elsewhere'][$index], $_POST['children_dead'][$index], $_POST['last_birth_date'][$index]);
                $stmt5->execute();
            }
        }
    }

    // 3. Water & Sanitation
    $stmt6 = $conn->prepare("INSERT INTO water_sanitation (household_id, drinking_water_source, toilet_type, handwashing_facility, water_availability, soap_availability) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt6->bind_param("isssii", $household_id, $_POST['drinking_water_source'], $_POST['toilet_type'], $_POST['handwashing_facility'], $_POST['water_availability'], $_POST['soap_availability']);
    $stmt6->execute();

    // 4. Housing
    $stmt7 = $conn->prepare("INSERT INTO housing (household_id, floor_material, roof_material, wall_material, number_of_rooms, electricity_source) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt7->bind_param("isssis", $household_id, $_POST['floor_material'], $_POST['roof_material'], $_POST['wall_material'], $_POST['number_of_rooms'], $_POST['electricity_source']);
    $stmt7->execute();

    // 5. Assets
    $stmt8 = $conn->prepare("INSERT INTO household_assets (household_id, has_car, has_radio, has_mobile_phone, has_tv, has_refrigerator, has_generator, has_internet) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt8->bind_param("iiiiiiii", $household_id, $_POST['has_car'], $_POST['has_radio'], $_POST['has_mobile_phone'], $_POST['has_tv'], $_POST['has_refrigerator'], $_POST['has_generator'], $_POST['has_internet']);
    $stmt8->execute();

    echo "<div style='padding:20px;'>✅ Full survey submitted successfully! <br><a href='index.php'>Return to form</a></div>";
}
?>
