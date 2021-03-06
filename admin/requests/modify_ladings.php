<?php
    require('connection.php');

    $action = mysqli_real_escape_string($connection, $_POST['action']);

    if($action == 'View') {
        $query = mysqli_query($connection, "SELECT * FROM clients") or die('Failed to connect to Database. Error: ' . mysqli_error($connection));

        echo '<div class="text-right"><button id="add-item-to-bill-button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Add Item</button></div>';
        echo '<form id="bill-of-lading-form">';
        echo '<input type="hidden" name="action" value="Add">';
        echo '<div class="row">';
        echo '<div class="col-lg-6 col-md-6"><label>Bill of Lading Number:</label><input type="text" class="form-control" name="billNumber" placeholder="Enter Bill of Lading Number here..." required></div>';
        echo '<div class="col-lg-6 col-md-6"><label>Shipping Line:</label><input type="text" class="form-control" name="shippingLine" placeholder="Enter Shipping Line here..." required></div>';
        echo '</div><br>';
        echo '<div class="row">';
        echo '<div class="col-lg-6 col-md-6"><label>Bill of Lading ID:</label>';
        echo '<select class="form-control" name="newBill" required>';
        echo '<option value="" selected disabled>Select a name</option>';

        while($row = mysqli_fetch_array($query)) {
            if(strlen($row['Middle_Name']) > 1) {
                $name = $row['First_Name'] . ' ' . substr($row['Middle_Name'], 0, 1) . '. ' . $row['Last_Name'];
            } else {
                $name = $row['First_Name'] . ' ' . $row['Last_Name'];
            }

            echo '<option value="' . $row['Client_ID'] . '">' . $name . '</option>';
        }

        echo '</select>';
        echo '</div>';
        echo '<div class="col-lg-6 col-md-6"><label>Consignee:</label><input type="text" class="form-control" name="consignee" placeholder="Enter Consignee here..." required></div>';
        echo '</div><br><div class="row">';
        echo '<div class="col-lg-6 col-md-6"><label>Export References:</label><input type="text" class="form-control" name="exportReferences" placeholder="Enter Export References here..." required></div>';
        echo '<div class="col-lg-6 col-md-6">';
        echo '<label>Date:</label><div class="nested-group">';
        echo '<input type="number" class="date-input-control input-group form-control" name="dateMonth" min="1" max="12" placeholder="Month" value="' . date('m') . '" required>';
        echo '<input type="number" class="date-input-control form-control" name="dateDay" min="1" max="31" placeholder="Day" value="' . date('d') . '" required>';
        echo '<input type="number" class="date-input-control form-control" name="dateYear" min="2000" max="' . date('Y') . '" placeholder="Year" value="' . date('Y') . '" required></div>';
        echo '</div></div><br><div class="row">';
        echo '<div class="col-lg-4 col-md-4">';
        echo '<label>Gross Weight:</label>';
        echo '<input type="text" class="form-control" name="grossWeight" placeholder="Enter Gross Weight here..." required>';
        echo '</div>';
        echo '<div class="col-lg-4 col-md-4">';
        echo '<label>Measurement:</label>';
        echo '<div class="input-group">';
        echo '<input type="text" id="measure-ment" class="form-control" name="measurement" placeholder="Enter Measurement here..." required>';
        echo '<span class="input-group-addon">m<sup>3</sup></span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="col-lg-4 col-md-4">';
        echo '<label>No. of Package(s):</label>';
        echo '<input type="text" class="form-control" name="packageCount" placeholder="Enter No. of Package(s) here...">';
        echo '</div>';
        echo '</div><br>';
        echo '<table id="bill-of-lading-table" class="table table-hover table-striped">';
        echo '<thead>';
        echo '<tr class="bg-dark">';
        echo '<th width="25%">Product/Item Name</th>';
        echo '<th width="25%">Quantity</th>';
        echo '<th width="75%">Item Description</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        echo '</tbody>';
        echo '</table>';
        echo '<input class="btn btn-primary" type="submit" value="Save">';
        echo '</form>';
    } else if($action == 'Edit') {
        $billId = mysqli_real_escape_string($connection, $_POST['billId']);

        $query = mysqli_query($connection, "SELECT * FROM ladings WHERE Bill_of_Lading_Number='$billId'") or die('Cannot connect to Database. Error: ' . mysqli_error($connection));
        $scan = mysqli_num_rows($query);

        if($scan == 1) {
            $row = mysqli_fetch_array($query);

            $query2 = mysqli_query($connection, "SELECT * FROM clients") or die('Failed to connect to Database. Error: ' . mysqli_error($connection));

            echo '<div class="text-right"><button id="add-item-to-bill-button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Add Item</button></div>';
            echo '<form id="edit-bill-of-lading-form">';
            echo '<input type="hidden" name="billId" value="' . $billId . '">';
            echo '<div class="row">';
            echo '<div class="col-lg-6 col-md-6"><label>Bill of Lading Number:</label><input type="text" class="form-control" name="billNumber" value="' . $row['Bill_of_Lading_Number'] . '" placeholder="Enter Bill of Lading Number here..." required></div>';
            echo '<div class="col-lg-6 col-md-6"><label>Shipping Line:</label><input type="text" class="form-control" name="shippingLine" placeholder="Enter Shipping Line here..." value="' . $row['Shipping_Line'] . '" required></div>';
            echo '</div><br>';
            echo '<div class="row">';
            echo '<div class="col-lg-6 col-md-6"><label>Bill of Lading ID:</label>';
            echo '<select class="form-control" name="newBill" required>';
            echo '<option value="" selected disabled>Select a name</option>';

            while($row2 = mysqli_fetch_array($query2)) {
                if(strlen($row2['Middle_Name']) > 1) {
                    $name = $row2['First_Name'] . ' ' . substr($row2['Middle_Name'], 0, 1) . '. ' . $row2['Last_Name'];
                } else {
                    $name = $row2['First_Name'] . ' ' . $row2['Last_Name'];
                }

                echo '<option value="' . $row2['Client_ID'] . '"' . ($row2['Client_ID'] == $row['Bill_of_Lading_ID'] ? ' selected' : '') . '>' . $name . '</option>';
            }

            echo '</select>';
            echo '</div>';
            echo '<div class="col-lg-6 col-md-6"><label>Consignee:</label><input type="text" class="form-control" name="consignee" placeholder="Enter Consignee here..." value="' . $row['Consignee'] . '" required></div>';
            echo '</div><br><div class="row">';
            echo '<div class="col-lg-6 col-md-6"><label>Export References:</label><input type="text" class="form-control" name="exportReferences" placeholder="Enter Export References here..." value="' . $row['Export_References'] . '" required></div>';
            echo '<div class="col-lg-6 col-md-6">';
            echo '<label>Date:</label><div class="nested-group">';
            echo '<input type="number" class="date-input-control input-group form-control" name="dateMonth" min="1" max="12" placeholder="Month" value="' . date('n', strtotime($row['Date_of_Transaction'])) . '" required>';
            echo '<input type="number" class="date-input-control form-control" name="dateDay" min="1" max="31" placeholder="Day" value="' . date('j', strtotime($row['Date_of_Transaction'])) . '" required>';
            echo '<input type="number" class="date-input-control form-control" name="dateYear" min="2000" max="' . date('Y') . '" placeholder="Year" value="' . date('Y', strtotime($row['Date_of_Transaction'])) . '" required></div>';
            echo '</div></div><br><div class="row">';
            echo '<div class="col-lg-4 col-md-4">';
            echo '<label>Gross Weight:</label>';
            echo '<input type="text" class="form-control" name="grossWeight" placeholder="Enter Gross Weight here..." value="' . $row['Gross_Weight'] . '" required>';
            echo '</div>';
            echo '<div class="col-lg-4 col-md-4">';
            echo '<label>Measurement:</label>';
            echo '<div class="input-group">';
            echo '<input type="text" id="measure-ment" class="form-control" name="measurement" placeholder="Enter Measurement here..." value="' . $row['Measurement'] . '" required>';
            echo '<span class="input-group-addon">m<sup>3</sup></span>';
            echo '</div>';
            echo '</div>';
            echo '<div class="col-lg-4 col-md-4">';
            echo '<label>No. of Package(s):</label>';
            echo '<input type="text" class="form-control" name="packageCount" placeholder="Enter No. of Package(s) here..." value="' . $row['Package_Count'] . '">';
            echo '</div>';
            echo '</div><br>';

            $mark = json_decode($row['Item_Mark']);
            $quantity = json_decode($row['Item_Quantity']);
            $description = json_decode($row['Item_Description']);
            
            if(count($mark) > count($quantity)) {
                if(count($mark) > count($description)) {
                    $count = count($mark);
                } else {
                    $count = count($description);
                }
            } else {
                if(count($quantity) > count($description)) {
                    $count = count($quantity);
                } else {
                    $count = count($description);
                }
            }

            echo '<div class="text-right"><span id="lading-count">' . $count . '</span> item(s) listed.</div>';
            echo '<table id="bill-of-lading-table" class="table table-hover table-striped">';
            echo '<thead>';
            echo '<tr class="bg-dark">';
            echo '<th width="25%">Product/Item Name</th>';
            echo '<th width="25%">Quantity</th>';
            echo '<th width="75%">Item Description</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            for($i = 0; $i < $count; $i++) {
                echo '<tr>';
                echo '<td><textarea name="billItemMark-' . $i . '" class="form-control" required>' . @$mark[$i] . '</textarea></td>';
                echo '<td><textarea name="billItemQuantity-' . $i . '" class="form-control" required>' . @$quantity[$i] . '</textarea></td>';
                echo '<td><textarea name="billItemDescription-' . $i . '" class="form-control" required>' . @$description[$i] . '</textarea></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '<input class="btn btn-primary" type="submit" value="Save">';
            echo '</form>';
        }
    } else if($action == 'Add') {
        $mark = array('');
        $quantity = array('');
        $description = array('');
        $loopCount = 0;

        $billNumber = mysqli_real_escape_string($connection, $_POST['billNumber']);
        $shippingLine = mysqli_real_escape_string($connection, $_POST['shippingLine']);
        $newBill = mysqli_real_escape_string($connection, $_POST['newBill']);
        $consignee = mysqli_real_escape_string($connection, $_POST['consignee']);
        $exportReferences = mysqli_real_escape_string($connection, $_POST['exportReferences']);
        $dateMonth = mysqli_real_escape_string($connection, $_POST['dateMonth']);
        $dateDay = mysqli_real_escape_string($connection, $_POST['dateDay']);
        $dateYear = mysqli_real_escape_string($connection, $_POST['dateYear']);
        $grossWeight = mysqli_real_escape_string($connection, $_POST['grossWeight']);
        $measurement = mysqli_real_escape_string($connection, $_POST['measurement']);
        $packageCount = mysqli_real_escape_string($connection, $_POST['packageCount']);

        $billDate = $dateYear . '-' . $dateMonth . '-' . $dateDay;
        $datetime = date('Y-m-d');

        foreach($_POST as $key => $post) {
            if($post != '') {
                $loopCount += 1;

                if($loopCount % 3 == 0) {
                    array_push($description, mysqli_real_escape_string($connection, $post));
                } else if($loopCount % 3 == 1) {
                    array_push($mark, mysqli_real_escape_string($connection, $post));
                } else {
                    array_push($quantity, mysqli_real_escape_string($connection, $post));
                }
            }
        }

        array_shift($mark);
        array_shift($mark);
        array_shift($mark);
        array_shift($mark);
        array_shift($mark);
        array_shift($quantity);
        array_shift($quantity);
        array_shift($quantity);
        array_shift($quantity);
        array_shift($quantity);
        array_shift($description);
        array_shift($description);
        array_shift($description);
        array_shift($description);
        array_shift($description);

        $query = mysqli_query($connection, "SELECT * FROM ladings WHERE Bill_of_Lading_Number='$billNumber'") or die('Cannot connect to Database. Error: ' . mysqli_error($connection));
        $scan = mysqli_num_rows($query);

        if($scan == 0) {
            $mark = json_encode($mark);
            $quantity = json_encode($quantity);
            $description = json_encode($description);

            $query = mysqli_query($connection, "INSERT INTO ladings (Bill_of_Lading_Number, Bill_of_Lading_ID, Shipping_Line, Consignee, Export_References, Item_Mark, Item_Quantity, Item_Description, Date_of_Transaction, Date_Added, Gross_Weight, Measurement, Package_Count) VALUES ('$billNumber', '$newBill', '$shippingLine', '$consignee', '$exportReferences', '$mark', '$quantity', '$description', '$billDate', '$datetime', '$grossWeight', '$measurement', '$packageCount')") or die('Cannot connect to Database. Error: ' . mysqli_error($connection));

            if($query) {
                echo 'You successfully created a new bill of lading.';
            } else {
                echo 'Failed to create bill of lading.';
            }
        } else {
            echo 'Bill of Lading already exist.';
        }
    } else if($action == 'Save') {
        $mark = array('');
        $quantity = array('');
        $description = array('');
        $loopCount = 0;

        $billId = mysqli_real_escape_string($connection, $_POST['billId']);
        $billNumber = mysqli_real_escape_string($connection, $_POST['billNumber']);
        $newBill = mysqli_real_escape_string($connection, $_POST['newBill']);
        $shippingLine = mysqli_real_escape_string($connection, $_POST['shippingLine']);
        $consignee = mysqli_real_escape_string($connection, $_POST['consignee']);
        $exportReferences = mysqli_real_escape_string($connection, $_POST['exportReferences']);
        $dateMonth = mysqli_real_escape_string($connection, $_POST['dateMonth']);
        $dateDay = mysqli_real_escape_string($connection, $_POST['dateDay']);
        $dateYear = mysqli_real_escape_string($connection, $_POST['dateYear']);
        $grossWeight = mysqli_real_escape_string($connection, $_POST['grossWeight']);
        $measurement = mysqli_real_escape_string($connection, $_POST['measurement']);
        $packageCount = mysqli_real_escape_string($connection, $_POST['packageCount']);

        $billDate = $dateYear . '-' . $dateMonth . '-' . $dateDay;
        $datetime = date('Y-m-d');

        foreach($_POST as $key => $post) {
            if($post != '') {
                $loopCount += 1;

                if($loopCount % 3 == 0) {
                    array_push($description, mysqli_real_escape_string($connection, $post));
                } else if($loopCount % 3 == 1) {
                    array_push($mark, mysqli_real_escape_string($connection, $post));
                } else {
                    array_push($quantity, mysqli_real_escape_string($connection, $post));
                }
            }
        }

        array_shift($mark);
        array_shift($mark);
        array_shift($mark);
        array_shift($mark);
        array_shift($mark);
        array_shift($quantity);
        array_shift($quantity);
        array_shift($quantity);
        array_shift($quantity);
        array_shift($quantity);
        array_shift($description);
        array_shift($description);
        array_shift($description);
        array_shift($description);
        array_shift($description);
        array_pop($mark);

        $mark = json_encode($mark);
        $quantity = json_encode($quantity);
        $description = json_encode($description);

        $query = mysqli_query($connection, "UPDATE ladings SET Bill_of_Lading_Number='$billNumber', Bill_of_Lading_ID='$newBill', Shipping_Line='$shippingLine', Consignee='$consignee', Export_References='$exportReferences', Item_Mark='$mark', Item_Quantity='$quantity', Item_Description='$description', Date_of_Transaction='$billDate', Gross_Weight='$grossWeight', Measurement='$measurement', Package_Count='$packageCount' WHERE Bill_of_Lading_Number='$billId'") or die('Cannot connect to Database. Error: ' . mysqli_error($connection));

        if($query) {
            echo 'Bill of Lading successfully modified.';
        } else {
            echo 'Failed to modify bill of lading.';
        }
    } else if($action == 'Delete') {
        $billId = mysqli_real_escape_string($connection, $_POST['billId']);

        $query = mysqli_query($connection, "UPDATE ladings SET Status='Inactive' WHERE Bill_of_Lading_Number='$billId'") or die('Cannot connect to Database. Error: ' . mysqli_error($connection));

        if($query) {
            echo 'Bill of Lading successfully deleted.';
        } else {
            echo 'Failed to delete bill of lading.';
        }
    }
?>