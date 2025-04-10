<?php
// SDES 2022 - Full Multi-tab Bootstrap form with dynamic person-level inputs
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SDES 2022 - Full Survey Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-4 mb-5">
    <h1 class="text-center mb-4">SDES 2022 - Complete Household Survey</h1>

    <form action="process_survey.php" method="POST">
        <ul class="nav nav-tabs" id="surveyTabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#household">1. Household Info</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#demo">2. Demographics + Person Details</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#water">3. Water & Sanitation</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#housing">4. Housing</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#assets">5. Household Assets</button></li>
        </ul>

        <div class="tab-content p-4 bg-white shadow-sm border border-top-0">
            <!-- Household Info Section -->
            <div class="tab-pane fade show active" id="household">
                <h4>Household Information</h4>
                <div class="mb-3">
                    <label>Village Name</label>
                    <input type="text" name="village_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Head of Household</label>
                    <input type="text" name="head_of_household" class="form-control" required>
                </div>
            </div>

            <!-- Demographics + Per Person Inputs -->
            <div class="tab-pane fade" id="demo">
                <h4>Demographics + Person Details</h4>
                <div id="persons-list">
                    <div class="person-entry mb-3 p-3 border rounded">
                        <input type="text" name="person_name[]" placeholder="Person Name" class="form-control mb-2">
                        <select name="relationship_to_head[]" class="form-select mb-2">
                            <option>Head of household</option><option>Husband/wife</option><option>Own Son/Daughter</option><option>Other relative</option>
                        </select>
                        <select name="gender[]" class="form-select mb-2"><option>Male</option><option>Female</option></select>
                        <input type="number" name="age[]" placeholder="Age" class="form-control mb-2">

                        <!-- Education Section -->
                        <h6>Education</h6>
                        <select name="ever_attended_school[]" class="form-select mb-2">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <input type="text" name="highest_grade_completed[]" placeholder="Highest Grade Completed" class="form-control mb-2">
                        <select name="currently_attending_school[]" class="form-select mb-2">
                            <option value="1">Currently Attending</option>
                            <option value="0">Not Attending</option>
                        </select>

                        <!-- Economic Section -->
                        <h6>Economic</h6>
                        <select name="employment_status[]" class="form-select mb-2">
                            <option>Employed</option><option>Unemployed</option><option>Self-employed</option><option>Student</option>
                        </select>
                        <input type="text" name="occupation[]" placeholder="Occupation" class="form-control mb-2">
                        <input type="text" name="business_activity[]" placeholder="Business Activity (if any)" class="form-control mb-2">

                        <!-- Fertility Section (optional) -->
                        <h6>Fertility (for Females 15+)</h6>
                        <input type="number" name="live_births[]" placeholder="Live births" class="form-control mb-2">
                        <input type="number" name="children_alive[]" placeholder="Children alive" class="form-control mb-2">
                        <input type="number" name="children_elsewhere[]" placeholder="Children elsewhere" class="form-control mb-2">
                        <input type="number" name="children_dead[]" placeholder="Children dead" class="form-control mb-2">
                        <input type="date" name="last_birth_date[]" placeholder="Last birth date" class="form-control mb-2">
                    </div>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addPerson()">+ Add Another Person</button>
            </div>

            <!-- Water & Sanitation Section -->
            <div class="tab-pane fade" id="water">
                <h4>Water & Sanitation</h4>
                <select name="drinking_water_source" class="form-select mb-3">
                    <option>Piped into dwelling</option>
                    <option>Piped into yard/plot</option>
                    <option>Public tap/standpipe</option>
                    <option>Borehole</option>
                    <option>Rainwater</option>
                    <option>Other</option>
                </select>
                <select name="toilet_type" class="form-select mb-3">
                    <option>Flush to sewer</option>
                    <option>Flush to septic tank</option>
                    <option>Pit latrine</option>
                    <option>No facility</option>
                </select>
                <select name="handwashing_facility" class="form-select mb-3">
                    <option>Sink/tap in dwelling</option>
                    <option>In yard/plot</option>
                    <option>Mobile object (bucket/jug)</option>
                    <option>Not available</option>
                </select>
            </div>

            <!-- Housing Section -->
            <div class="tab-pane fade" id="housing">
                <h4>Housing Information</h4>
                <input type="number" name="number_of_rooms" placeholder="Number of rooms" class="form-control mb-3">
                <select name="floor_material" class="form-select mb-3">
                    <option>Earth/sand</option><option>Cement</option><option>Tiles</option><option>Wood/planks</option>
                </select>
                <select name="roof_material" class="form-select mb-3">
                    <option>Metal Sheet</option><option>Thatched</option><option>Concrete</option>
                </select>
                <select name="electricity_source" class="form-select mb-3">
                    <option>Grid electricity</option><option>Solar</option><option>Generator</option><option>None</option>
                </select>
            </div>

            <!-- Assets Section -->
            <div class="tab-pane fade" id="assets">
                <h4>Household Assets</h4>
                <label><input type="checkbox" name="has_car" value="1"> Car/Truck/Van</label><br>
                <label><input type="checkbox" name="has_radio" value="1"> Radio</label><br>
                <label><input type="checkbox" name="has_mobile_phone" value="1"> Mobile Phone</label><br>
                <label><input type="checkbox" name="has_tv" value="1"> Television</label><br>
                <label><input type="checkbox" name="has_refrigerator" value="1"> Refrigerator</label><br>
                <label><input type="checkbox" name="has_generator" value="1"> Generator</label><br>
                <label><input type="checkbox" name="has_internet" value="1"> Internet Access</label>
            </div>

        </div>

        <br>
        <button type="submit" class="btn btn-success w-100">Submit Survey ✅</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function addPerson() {
    const personEntry = document.querySelector('.person-entry').cloneNode(true);
    personEntry.querySelectorAll('input').forEach(input => input.value = '');
    document.getElementById('persons-list').appendChild(personEntry);
}
</script>
</body>
</html>