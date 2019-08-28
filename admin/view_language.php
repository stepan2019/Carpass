<div>
    <?php
    $language = $config->getLanguages();
    $count = $language->num_rows;
    ?>
    <div class="mb-4 row">
        <div class="col">
            <span class="dashboard-txt">Total Languages : <?php echo $count; ?></span>
        </div>
        <div class="col text-right">
            <a href="home.php?query=add_language" class="btn btn-primary submit-fs btn-custom ml-5">New Language</a>
        </div>
    </div>
    <table class="table table-bordered" id="wang-dataTable">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Priority</th>
            <th>Language Id</th>
            <th>Language Name</th>
            <th>Language Image</th>
            <th>Default</th>
            <th>Enabled</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $s_sn = 1;
        if ($count > 0) {
            while ($lang = $language->fetch_assoc()) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $s_sn; ?></td>
                    <td><?php echo $lang['id']; ?></td>
                    <td><?php echo $lang['code']; ?></td>
                    <td><?php echo $lang['name']; ?></td>
                    <td><img src="../img/languages/<?php echo $lang['image']; ?>"/></td>
                    <td><input type="checkbox" <?php if ($lang['default']) echo 'checked'; ?>></td>
                    <td><input type="checkbox" <?php if ($lang['enabled']) echo 'checked'; ?>></td>
                    <td class="text-center">
                        <a href="home.php?query=languageedit&id=<?php echo $lang['id']; ?>">
                            <i class="far fa-edit" style="float:left;"></i>
                        </a>
                        <a href="home.php?query=languagedelete&id=<?php echo $lang['id']; ?>">
                            <i class="far fa-trash-alt" style="float:right;"></i>
                        </a>
                    </td>
                </tr>
                <?php $s_sn++;
            }
        } else {
            ?>
            <td colspan="12">No any vehicle information found
            </td>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
