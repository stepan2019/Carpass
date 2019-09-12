<?php

$result = $config->getInvoiceHistory();
?>

<div>
    <table class="table table-bordered" id="wang-dataTable">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Amount</th>
            <th>User</th>
            <th>Plate number</th>
            <th>Date</th>
            <!--<th>Amount</th>-->
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $s_sn = 1;
        while ($row = $result->fetch_assoc()) {
            $user = $config->getUserById($row['user_id']);
            $user_info = $user->fetch_assoc();
            ?>
            <tr>
                <td class="text-center"><?php echo $s_sn; ?></td>
                <td><?php echo $row['currency']; ?></td>
                <td><?php echo $user_info['name']; ?></td>
                <td><?php echo $row['plate_number']; ?></td>
                <td><?php echo date('Y-m-d', strtotime($row['date'])); ?></td>
                <td class="text-center">
                    <a href="javascript:gotoInvoice(<?php echo "'".$row['plate_number']."'".','."'".$row['vin']."'".','."'".$user_info['email']."'";?>)">
                        <i class="far fa-edit"></i>
                    </a>
                    <a href="home.php?query=deleteinvoicehistory&id=<?php echo $row['id']; ?>">
                        <i class="far fa-trash-alt pl-3" style=""></i>
                    </a>
                </td>
            </tr>
            <?php $s_sn++;
        } ?>
        </tbody>
    </table>
    <form action="/vehicle/invoice.php" method="post" id="invoice_form" target="_blank" name="invoice_form">
        <input type="hidden" name="vin" id="vin" value=""/>
        <input type="hidden" name="plate" id="plate" value=""/>
        <input type="hidden" name="email" id="email" value=""/>
    </form>
</div>

